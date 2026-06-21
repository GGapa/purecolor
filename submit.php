<?php
require_once('main.php');
header('Content-Type:application/json; charset=utf-8');

$colorjson = isset($_POST['color_json']) ? $_POST['color_json'] : '';
$title     = isset($_POST['title']) ? trim($_POST['title']) : '';
$author    = isset($_POST['author']) ? trim($_POST['author']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$themecolor = isset($_POST['themecolor']) ? $_POST['themecolor'] : '';

if (!check_json($colorjson)){
    exit(json_encode(['status' => 'failed', 'msg' => '格式错误']));
}
if (empty($title) || strlen($title) > 500){
    exit(json_encode(['status' => 'failed', 'msg' => '标题错误']));
}
if (empty($author) || strlen($author) > 500){
    exit(json_encode(['status' => 'failed', 'msg' => '作者错误']));
}
if (strlen($description) > 5000){
    exit(json_encode(['status' => 'failed', 'msg' => '介绍过长']));
}
if (!check_hex($themecolor)){
    $themecolor = '#5e72e4';
}

$json = json_decode($colorjson);
if (count($json) == 0){
    exit(json_encode(['status' => 'failed', 'msg' => '请至少新建一个分组']));
}
foreach ($json as $item) {
    if (count($item->colors) == 0){
        exit(json_encode(['status' => 'failed', 'msg' => '分组中至少需要有一个颜色']));
    }
    foreach ($item->colors as $color){
        if (!check_hex($color->hex)){
            exit(json_encode(['status' => 'failed', 'msg' => '请检查色值是否正确']));
        }
    }
}

// Generate unique ID
$id = get_random_id();
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM palettes WHERE id = ?");
mysqli_stmt_bind_param($stmt, 's', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $count);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

while ($count > 0) {
    $id = get_random_id();
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM palettes WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

$time = time();

// Insert with prepared statement
$stmt = mysqli_prepare($conn, "INSERT INTO palettes (id, color_json, title, description, author, themecolor, create_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'ssssssi', $id, $colorjson, $title, $description, $author, $themecolor, $time);
$sqlres = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$sqlres){
    exit(json_encode(['status' => 'failed', 'msg' => 'SQL 操作失败']));
}
exit(json_encode(['status' => 'success', 'id' => $id]));
