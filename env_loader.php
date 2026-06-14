<?php
/**
 * .env 文件加载器
 *
 * 将 .env 文件中的 KEY=VALUE 写入 $_SERVER 和 $_ENV。
 * 使用 $_SERVER 而非 getenv()，因为在 PHP-FPM 下 $_SERVER 是最可靠的来源。
 * 零依赖，适用于任何 PHP 项目。
 */

function load_env(string $path): bool {
	if (!is_readable($path)) {
		return false;
	}

	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#') {
			continue;
		}

		$pos = strpos($line, '=');
		if ($pos === false) {
			continue;
		}

		$key   = trim(substr($line, 0, $pos));
		$value = trim(substr($line, $pos + 1));
		$value = trim($value, '"\'');

		$_ENV[$key]   = $value;
		$_SERVER[$key] = $value;
	}

	return true;
}
