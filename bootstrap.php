<?php

require_once __DIR__ . '/vendor/autoload.php'; // Đúng đường dẫn

try {
    // Cấu hình database
    $dbhost = "localhost";
    $dbname = "nha_thuoc";
    $dbuser = "root";
    $dbpass = "";

    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $ex) {
    die('Không thể kết nối đến MySQL. Lỗi: ' . $ex->getMessage());
}
