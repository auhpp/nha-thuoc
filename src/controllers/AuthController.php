<?php

namespace App\Controllers;

use App\Models\Account;
use PDO;

class AuthController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function showLoginForm() {
        require PAGES_DIR . "/login.php";
    }

    public function showRegisterForm() {
        require PAGES_DIR . "/register.php";
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";

            $account = new Account($this->pdo);
            if ($account->authenticate($username, $password)) {
                $_SESSION["user"] = $username;
                header("Location: /medicine");
                exit;
            } else {
                $_SESSION["error_message"] = "Sai tên đăng nhập hoặc mật khẩu!";
                header("Location: /login");
                exit;
            }
        }
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $account = new Account($this->pdo);
            if ($account->register($username, $hashedPassword)) {
                echo "<script>
                    alert('Đăng ký thành công! Vui lòng đăng nhập.');
                    window.location.href = '/login';
                </script>";
                exit;
            } else {
                echo "<script>
                    alert('Đăng ký thất bại! Vui lòng thử lại.');
                    window.location.href = '/register';
                </script>";
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
