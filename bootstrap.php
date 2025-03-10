<?php
require_once 'vendor/autoload.php';
try {
    $PDO = (new App\Models\PDOFactory())->create([
        'dbhost' => "localhost:3306",
        'dbname' => "nha_thuoc",
        'dbuser' => "root",
        'dbpass' => "",
    ]);
} catch (Exception $ex) {
    echo 'Không thể kết nối đến MySQL,
          kiểm tra lại username/password đến MySQL.<br>';
}
