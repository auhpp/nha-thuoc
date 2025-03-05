<?php

namespace App\Models;

use PDO;

class Account {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function authenticate($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM taikhoan WHERE tendangnhap = :username");
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["matkhau"])) {
            return true;
        }
        return false;
    }

    public function register($username, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO taikhoan (tendangnhap, matkhau) VALUES (:username, :password)");
        return $stmt->execute(["username" => $username, "password" => $password]);
    }
}
