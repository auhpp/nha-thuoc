<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../models/MedicineModel.php';

use App\Models\MedicineModel; // Gọi đúng namespace

// Khởi tạo model
$model = new MedicineModel();
$manufacturers = $model->getAllManufacturers();
$suppliers = $model->getAllSuppliers();

// Xử lý lỗi (nếu có) từ MedicineController
$error = "";
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thuốc</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        form {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }
        button {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.8;
        }
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2>➕ Thêm thuốc mới</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form action="/medicine/add" method="POST">
        <input type="text" name="tenthuoc" placeholder="Tên thuốc" value="" required>
        <input type="text" name="congdung" placeholder="Công dụng" value="" required>
        <input type="number" name="dongia" placeholder="Đơn giá (VND)" step="0.01" required min="0">
        <input type="number" name="soluongton" placeholder="Số lượng tồn" required min="0">
        <input type="date" name="hansudung" required>

        <label>Loại thuốc:</label>
        <input type="number" name="maloai" placeholder="Mã loại thuốc" required min="1">

        <label>Nhà sản xuất:</label>
        <select name="mahangsx" required>
            <?php foreach ($manufacturers as $manufacturer): ?>
                <option value="<?= htmlspecialchars($manufacturer['mahangsx']) ?>">
                    <?= htmlspecialchars($manufacturer['tenhang']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Nhà cung cấp:</label>
        <select name="manhacungcap" required>
            <?php foreach ($suppliers as $supplier): ?>
                <option value="<?= htmlspecialchars($supplier['manhacungcap']) ?>">
                    <?= htmlspecialchars($supplier['tennhacungcap']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">✅ Thêm thuốc</button>
    </form>
</body>
</html>