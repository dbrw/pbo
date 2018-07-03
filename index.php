<?php

define('VERSION', '0.1.0');

require_once './lib/settings.php';
require_once './bootstrap.php';

$app = new \Pbo\App();

$app->route('GET', '/', 'HomeController@index');
$app->route('POST', '/tugas', 'HomeController@store');
$app->route('PUT', '/tugas/(\d+)', 'HomeController@update');
$app->route('DELETE', '/tugas/(\d+)', 'HomeController@delete');

$app->run();
