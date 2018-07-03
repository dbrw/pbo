<?php
namespace Pbo;

class Session
{
    public static function start($name = [])
    {
        session_start($name);
    }

    public static function get($key, $default = '')
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function delete($key)
    {
        if(ses_has($key)) unset($_SESSION[$key]);
    }

    public static function id($new_id = null)
    {
        return (!empty($new_id)) ? session_id($new_id) : session_id();
    }

    public static function reset()
    {
        session_destroy();
    }
}
