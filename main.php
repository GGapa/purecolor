<?php
require_once('config.php');

function check_id($id){
    return (strlen($id) == 10);
}

function get_random_id(){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $res = '';
    for ($i = 1; $i <= 10; $i++) {
        $res .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $res;
}

function check_json($str){
    if (!is_string($str) || strlen($str) > 100000) return false;
    json_decode($str);
    return (json_last_error() == JSON_ERROR_NONE);
}

function check_hex($hex){
    if (!is_string($hex)) return false;
    return (bool) preg_match('/^#[0-9A-Fa-f]{6}$/', $hex);
}

function esc_str($str){
    global $conn;
    return mysqli_real_escape_string($conn, $str);
}
