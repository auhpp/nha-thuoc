<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../models/MedicineModel.php';

use App\Models\MedicineModel;

// Khởi tạo model
try {
    $model = new MedicineModel();
} catch (Exception $e) {
    die("Lỗi: Không thể kết nối cơ sở dữ liệu - " . $e->getMessage());
}

// Lấy ID từ URL (Pretty URL hoặc Query String)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id && isset($_SERVER['REQUEST_URI'])) {
    $parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $id = intval(end($parts)); // Lấy ID cuối cùng trong URL
}

// Kiểm tra ID hợp lệ
if ($id <= 0) {
    header("Location: /medicine?status=invalid_id&message=" . urlencode("ID không hợp lệ."));
    exit;
}

$medicine = $model->getMedicineById($id);
if (!$medicine) {
    header("Location: /medicine?status=not_found&message=" . urlencode("Không tìm thấy thuốc."));
    exit;
}

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
    <title>Chỉnh sửa thuốc</title>
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
    <h2>✏️ Chỉnh sửa thuốc: <?= htmlspecialchars($medicine['tenthuoc']) ?></h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form action="/medicine/edit/<?= $medicine['mathuoc'] ?>" method="POST">
        <input type="text" name="tenthuoc" value="<?= htmlspecialchars($medicine['tenthuoc']) ?>" placeholder="Tên thuốc" required>
        <input type="text" name="congdung" value="<?= htmlspecialchars($medicine['congdung']) ?>" placeholder="Công dụng" required>
        <input type="number" name="dongia" value="<?= htmlspecialchars($medicine['dongia']) ?>" placeholder="Đơn giá (VND)" step="0.01" required min="0">
        <input type="number" name="soluongton" value="<?= htmlspecialchars($medicine['soluongton']) ?>" placeholder="Số lượng tồn" required min="0">
        <input type="date" name="hansudung" value="<?= htmlspecialchars($medicine['hansudung']) ?>" required>

        <label>Loại thuốc:</label>
        <input type="number" name="maloai" value="<?= htmlspecialchars($medicine['maloai']) ?>" placeholder="Mã loại thuốc" required min="1">

        <label>Nhà sản xuất:</label>
        <select name="mahangsx" required>
            <?php foreach ($manufacturers as $manufacturer): ?>
                <option value="<?= htmlspecialchars($manufacturer['mahangsx']) ?>" <?= ($medicine['mahangsx'] == $manufacturer['mahangsx']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($manufacturer['tenhang']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Nhà cung cấp:</label>
        <select name="manhacungcap" required>
            <?php foreach ($suppliers as $supplier): ?>
                <option value="<?= htmlspecialchars($supplier['manhacungcap']) ?>" <?= ($medicine['manhacungcap'] == $supplier['manhacungcap']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($supplier['tennhacungcap']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Lưu thay đổi</button>
    </form>
    <a href="/medicine">Quay lại danh sách</a>
</body>
</html>