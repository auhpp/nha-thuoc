<?php
const ROOT_DIR = __DIR__ . '/..';
const PAGES_DIR = __DIR__ . "/../src/views";

require_once __DIR__ . "/../bootstrap.php";

session_start();

$router = new \Bramus\Router\Router();
$router->setNamespace("\App\Controllers");

// Trang thống kê
$router->get('/statistical', 'StatisticalController@index');

// Quản lý thuốc
$router->get('/medicine', 'MedicineController@index'); // Danh sách thuốc
$router->get('/medicine/add', 'MedicineController@add'); // Hiển thị form thêm thuốc
$router->post('/medicine/add', 'MedicineController@add'); // Xử lý thêm thuốc

$router->get('/medicine/edit/(\d+)', 'MedicineController@edit'); // Hiển thị form chỉnh sửa thuốc
$router->post('/medicine/edit/(\d+)', 'MedicineController@edit'); // Xử lý cập nhật thuốc
$router->get('/medicine/export', 'MedicineController@exportExcel'); // Xuất Excel
$router->post('/medicine/delete', 'MedicineController@delete'); // Xử lý xóa thuốc (dùng POST để gửi ID qua form)
$router->run();