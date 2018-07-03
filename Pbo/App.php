<?php
namespace Pbo;

class App
{
    /**
     * Memulai session dan memeriksa apakah aplikasi dalam mode DEBUG.
     * @param null
     * @return void
     */
    public function __construct()
    {
        if(defined('DEBUG') && DEBUG == true){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
        }
        error_reporting(E_ALL);
        Session::start();
    }

    /**
     * Memeriksa route dan menjalankan fungsi callback yang sesuai.
     * @param String $method HTTP method
     * @param String $regex string regex untuk dicocokkan dengan PATH_INFO
     * @param Callable $callback fungsi atau method yang dipanggil jika $path dan $method sesuai
     * @return void
     */
    public function route($method, $regex, $callback)
    {
        $method = explode(',', $method);
        $method = array_map('trim', array_map('strtoupper', $method));
        $path = !empty( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '/';
        $regex = '~^' . BASE_PATH . $regex . '/?$~';
        $valid_req = Request::validate($method);

        if(preg_match($regex, $path, $args) && $valid_req) {
            if(is_string($callback) && strpos($callback, '@')) {
                $bag = explode('@', $callback);
                $ctl = $bag[0];
                $mtd = $bag[1];
                $ctl_path = CONTROLLER_DIR . $ctl . '.php';
                if(!file_exists($ctl_path)) die("File {$ctl_path} tidak ditemukan!");
                include $ctl_path;
                if(!method_exists($ctl, $mtd)) die("Methode {$mtd} tidak ditemukan pada {$ctl_path}!");
                $callback = [new $ctl, $mtd];
            }
            array_shift($args);
            die(call_user_func_array($callback, array_values($args)));
        }
    }

    /**
     * Jika route tidak ditemukan, berikan pesan error
     */
    public function run()
    {
        http_response_code(404);
        die('Not Found!');
    }
}
