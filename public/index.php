<?php
const ROOT_DIR = __DIR__ . '/..';
const PAGES_DIR = __DIR__ . "/../src/views";

require_once __DIR__ . "/../bootstrap.php";

session_start();

$router = new \Bramus\Router\Router();
$router->setNamespace("\App\Controllers");


// Quản lý thuốc
$router->get('/medicine', 'MedicineController@index');
$router->get('/medicine/add', 'MedicineController@add');
$router->post('/medicine/add', 'MedicineController@add');

$router->get('/medicine/edit/(\d+)', 'MedicineController@edit');
$router->post('/medicine/edit/(\d+)', 'MedicineController@edit');
$router->get('/medicine/export', 'MedicineController@exportExcel'); // Xuất Excel
$router->post('/medicine/delete', 'MedicineController@delete');


//Trang thống kê
$router->get("/statistical", "StatisticalController@index");
$router->get("/revenueByWeek", "StatisticalController@revenueByWeek");
$router->get("/revenueByDay", "StatisticalController@revenueByDay");
$router->get("/revenueByMonth", "StatisticalController@revenueByMonth");
$router->get("/statistical/export", "StatisticalController@exportRevenueExcel");
$router->run();
