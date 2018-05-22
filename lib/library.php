<?php

if(!defined('VERSION')) die();

/*
 * mengaktifkan pesan kesalahan jika DEBUG bernilai true dan memulai session
 *
 */
function init() {
    if(defined('DEBUG') && DEBUG == true){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }
    error_reporting(E_ALL);
    ses_start();
}

/*
 * menangkap route yang tidak didefinisikan dan mengembalikan respon 404
 *
 */
function run() {
    http_response_code(404);
    die('Not Found!');
}

/* ROUTING */

/*
 * @param String $method HTTP method
 * @param String $regex string regex untuk dicocokkan dengan PATH_INFO
 * @param Callable $callback fungsi atau method yang dipanggil jika $path dan $method sesuai
 * @return void
 */
function route($method, $regex, $callback) {
    $method = explode(',', $method);
    $method = array_map('trim', array_map('strtoupper', $method));
    $path = !empty( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '/';
    $regex = '~^' . BASE_PATH . $regex . '/?$~';
    $valid_req = ( in_array('ANY', $method) || in_array(req_method(), $method) );

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

/* VIEW */

function render_view($template='', $vars=null) {
    $template = VIEWS_DIR . $template . '.php';
    if(!file_exists($template)) die("View {$template} tidak ditemukan!");
    if(is_array($vars)) extract($vars);
    ob_start();
    require($template);
    return ob_get_clean();
}

function e($var) {
    return htmlspecialchars($var);
}

/* DATABASE */

function db_run($sql, $param = []) {
    $opt = [
        PDO::ATTR_PERSISTENT         => true,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $sql = trim($sql);
    try {
        $con = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $opt);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    try {
        $hasil = $con->prepare($sql);
        $hasil->execute($param);
        return $hasil;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function db_select($sql, $param = []) {
    $hasil = db_run($sql, $param);
    $baris = [];
    while($b = $hasil->fetch()) $baris[] = $b;
    return $baris;
}

/* REQUEST */

function req_method($key=null) {
    $rm = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : getenv('request_method');
    $method = isset( $_POST['_method'] ) ? strtoupper( $_POST['_method'] ) : $rm;
    return ( !empty( $key ) ) ? ( $method === $key ) : $method;
}

function req_env($key = '') {
    return (!empty($_SERVER[$key])) ? $_SERVER[$key] : getenv($key);
}

function req_post($key = null, $def = null) {
    return isset($_POST[$key]) ? $_POST[$key] : $def;
}

function req_get($key = null, $def = null) {
    return isset( $_GET[$key] ) ? $_GET[$key] : $def;
}

function req_put($key = null, $def = null) {
    return req_method('PUT') ? ( req_raw( $key ) ) : $def;
}

function req_patch($key = null, $def = null) {
    return req_method('PATCH') ? ( req_raw( $key ) ) : $def;
}

/* HEADER */

function add_header($str, $code = null) {
    header($str, $code);
}

/* URL */

function base_url($str = '/') {
    $base = defined('BASE_URL') ? BASE_URL : 'http://' . $_SERVER['HTTP_HOST'] . BASE_PATH;
    return $base . $str;
}

function redirect_to($url) {
    add_header('Location: ' . $url);
}

/* SESSION */
function ses_start() {
    session_start();
}

function ses_set($key, $val) {
    $_SESSION[$key] = $val;
}

function ses_has($key) {
    return isset($_SESSION[$key]);
}

function ses_get($key, $def = null) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $def;
}

function ses_delete($key) {
    if(ses_has($key)) unset($_SESSION[$key]);
}

function ses_id($newid = null) {
    return (!empty($newid)) ? session_id($newid) : session_id();
}

function ses_reset() {
    session_destroy();
}

/* FLASH */

function flash_set($key, $val) {
    if(!ses_id()) ses_start();
    $_SESSION['pbo_flash_message'][$key] = $val;
}

function flash_has($key) {
    return isset($_SESSION['pbo_flash_message'][$key]);
}

function flash_get($key) {
    if(!ses_id()) ses_start();
    if(!flash_has($key)) return null;
    $val = $_SESSION['pbo_flash_message'][$key];
    unset($_SESSION['pbo_flash_message'][$key]);
    return $val;
}

function flash_keep($key) {
    if(!ses_id()) ses_start();
    if(!flash_has($key)) return null;
    return $_SESSION['pbo_flash_message'][$key];
}
