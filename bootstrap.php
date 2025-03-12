<?php

require_once __DIR__ . '/vendor/autoload.php'; 

try {
    $dbhost = "localhost";
    $dbname = "nha_thuoc";
    $dbuser = "root";
    $dbpass = "";

    $PDO = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $ex) {
    die('Không thể kết nối đến MySQL. Lỗi: ' . $ex->getMessage());
}
