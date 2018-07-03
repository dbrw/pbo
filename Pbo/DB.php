<?php
namespace Pbo;

use PDO;

class DB
{
    public static function run($sql, $param = [])
    {
        $opt = [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $sql = trim($sql);
        try {
            $con = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $opt);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
        try {
            $hasil = $con->prepare($sql);
            $hasil->execute($param);
            return $hasil;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function select($sql, $param = [])
    {
        $hasil = static::run($sql, $param);
        $baris = [];
        while($b = $hasil->fetch()) $baris[] = $b;
        return $baris;
    }
}
