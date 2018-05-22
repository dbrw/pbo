<?php

if(!defined('VERSION')) die();

/*
 * @const CONTROLLER_DIR folder tempat file-file controller disimpan
 *
 */
define('CONTROLLER_DIR', 'Controller/');

/*
 * @const VIEWS_DIR folder tempat file-file view disimpan
 *
 */
define('VIEWS_DIR', 'Views/');

/*
 * @const DB_HOST host untuk database, biasanya bernilai `localhost`
 *
 */
define('DB_HOST', 'mariadb');

/*
 * @const DB_USER pengguna yang diperbolehkan mengakses database
 *
 */
define('DB_USER', 'root');

/*
 * @const DB_PASS password untuk pengguna DB_USER
 *
 */
define('DB_PASS', 'root');

/*
 * @const DB_NAME nama database
 *
 */
define('DB_NAME', 'tugasku');

/*
 * @const DEBUG ubah menjadi `false` jika tidak dalam development
 *
 */
define('DEBUG', true);

/*
 * @const BASE_PATH isikan dengan nama folder tempat file `index.php` berada dengan diawali garing (`/`).
 * Contoh: `/pbo`
 *
 */
define('BASE_PATH', '/pbo');

/*
 * @const BASE_URL isikan dengan FQDN. Contoh: `http://pbo.test`
 *
 */
define('BASE_URL', '');
