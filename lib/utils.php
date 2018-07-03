<?php

use Pbo\Session;

function base_url($str = '/') {
    $base = defined('BASE_URL') ? BASE_URL : 'http://' . $_SERVER['HTTP_HOST'] . BASE_PATH;
    return $base . $str;
}

function redirect_to($url) {
    add_header('Location: ' . $url);
}

function flash_set($key, $val) {
    if(!Session::id()) Session::start();
    $_SESSION['pbo_flash_message'][$key] = $val;
}

function flash_has($key) {
    return isset($_SESSION['pbo_flash_message'][$key]);
}

function flash_get($key) {
    if(!Session::id()) Session::start();
    if(!flash_has($key)) return null;
    $val = $_SESSION['pbo_flash_message'][$key];
    unset($_SESSION['pbo_flash_message'][$key]);
    return $val;
}

function flash_keep($key) {
    if(!Session::id()) Session::start();
    if(!flash_has($key)) return null;
    return $_SESSION['pbo_flash_message'][$key];
}

function add_header($str, $code = null) {
    header($str, $code);
}
