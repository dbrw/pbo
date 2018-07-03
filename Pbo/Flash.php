<?php
namespace Pbo;

class Flash
{
    public static function set($key, $val) {
        if(!Session::id()) Session::start();
        $_SESSION['pbo_flash_message'][$key] = $val;
    }

    public static function has($key) {
        return isset($_SESSION['pbo_flash_message'][$key]);
    }

    public static function get($key) {
        if(!Session::id()) Session::start();
        if(!flash_has($key)) return null;
        $val = $_SESSION['pbo_flash_message'][$key];
        unset($_SESSION['pbo_flash_message'][$key]);
        return $val;
    }

    public static function keep($key) {
        if(!Session::id()) Session::start();
        if(!flash_has($key)) return null;
        return $_SESSION['pbo_flash_message'][$key];
    }
}
