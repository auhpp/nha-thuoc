<?php
const ROOT_DIR = __DIR__ . '/..';
const PAGES_DIR = __DIR__ . "/../src/views";

require_once __DIR__ . "/../bootstrap.php";

session_start();

$router = new \Bramus\Router\Router();
$router->setNamespace("\App\Controllers");

// Khởi tạo controller và truyền PDO vào
$authController = new \App\Controllers\AuthController($pdo);

// Trang thống kê
$router->get("/statistical", "StatisticalController@index");

// Trang đăng nhập, đăng ký
$router->get("/login", [$authController, "showLoginForm"]);
$router->post("/login", [$authController, "login"]);
$router->get("/register", [$authController, "showRegisterForm"]);
$router->post("/register", [$authController, "register"]);
$router->get("/logout", [$authController, "logout"]);

$router->run();
