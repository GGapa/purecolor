<?php
/**
 * .env 文件加载器 — 类似 Python 的 python-dotenv
 * 用法: require_once('env_loader.php'); load_env(__DIR__ . '/.env');
 */

function load_env($path) {
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // 跳过注释和空行
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        // 解析 KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);

            // 去掉首尾引号
            $value = trim($value, '"\'');

            // 写入 $_ENV 和 $_SERVER
            $_ENV[$key]   = $value;
            $_SERVER[$key] = $value;

            // 同时用 putenv 设置（兼容 getenv）
            putenv("{$key}={$value}");
        }
    }

    return true;
}

/**
 * 获取 .env 变量，支持默认值
 */
function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) {
        $value = isset($_ENV[$key]) ? $_ENV[$key] : false;
    }
    if ($value === false) {
        $value = isset($_SERVER[$key]) ? $_SERVER[$key] : false;
    }
    return $value !== false ? $value : $default;
}
