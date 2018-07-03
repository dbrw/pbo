<?php
namespace Pbo;

class Request
{
    /**
     * Validasi $method dengan method sesungguhnya yang dilakukan oleh client.
     * @param String $method metode yang diperiksa
     * @return boolean $is_valid
     */
    public static function validate($method)
    {
        $is_valid = ( in_array('ANY', $method) || in_array(static::method(), $method) );
        return $is_valid;
    }

    /**
     * Mendapatkan request method saat ini.
     * @param string $key key untuk dicocokkan dengan request method
     */
    public static function method($key = null)
    {
        $request_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : getenv('request_method');
        $method = isset( $_POST['_method'] ) ? strtoupper( $_POST['_method'] ) : $request_method;
        return ( !empty( $key ) ) ? ( $method === $key ) : $method;
    }

    public static function env($key = '')
    {
        return (!empty($_SERVER[$key])) ? $_SERVER[$key] : getenv($key);
    }

    public static function get($key = null, $default = null)
    {
        return isset( $_GET[$key] ) ? $_GET[$key] : $default;
    }

    public static function post($key = null, $default = null)
    {
        return isset( $_POST[$key] ) ? $_POST[$key] : $default;
    }

}
