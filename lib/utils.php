<?php

function base_url($str = '/') {
    $base = defined('BASE_URL') ? BASE_URL : 'http://' . $_SERVER['HTTP_HOST'] . BASE_PATH;
    return $base . $str;
}

function redirect_to($url) {
    add_header('Location: ' . $url);
}
