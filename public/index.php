<?php
const ROOT_DIR = __DIR__ . '/..';
const PAGES_DIR = __DIR__ . "/../src/views";

require_once __DIR__ . "/../bootstrap.php";

session_start();

$router = new \Bramus\Router\Router();
$router->setNamespace("\App\Controllers");
//Trang thống kê
$router->get("/statistical", "StatisticalController@index");
$router->get("/revenueByWeek", "StatisticalController@revenueByWeek");
$router->get("/revenueByDay", "StatisticalController@revenueByDay");
$router->get("/revenueByMonth", "StatisticalController@revenueByMonth");
$router->get("/medicine_searchByCategory/{category}", "MedicineController@getMedicinesByCategory");
$router->get("/medicine_searchByHSX/{hsx}", "MedicineController@getMedicinesByHSX");
$router->get("/medicine_searchByNCC/{ncc}", "MedicineController@getMedicinesByNCC");
$router->run();
