<?php
const ROOT_DIR = __DIR__ . '/..';
const PAGES_DIR = __DIR__ . "/../src/views";

require_once __DIR__ . "/../bootstrap.php";

session_start();

$router = new \Bramus\Router\Router();
$router->setNamespace("\App\Controllers");
//Trang thống kê
$router->get("/statistical", "StatisticalController@index");

$router->run();
