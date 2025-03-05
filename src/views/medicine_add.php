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
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2 class="text-center mb-4">➕ Thêm thuốc mới</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form action="/medicine/add" method="POST">
            <div class="form-group">
                <label for="tenthuoc">Tên thuốc</label>
                <input type="text" class="form-control" id="tenthuoc" name="tenthuoc" placeholder="Tên thuốc" required>
            </div>

            <div class="form-group">
                <label for="congdung">Công dụng</label>
                <input type="text" class="form-control" id="congdung" name="congdung" placeholder="Công dụng" required>
            </div>

            <div class="form-group">
                <label for="dongia">Đơn giá (VND)</label>
                <input type="number" class="form-control" id="dongia" name="dongia" placeholder="Đơn giá" step="0.01" required min="0">
            </div>

            <div class="form-group">
                <label for="soluongton">Số lượng tồn</label>
                <input type="number" class="form-control" id="soluongton" name="soluongton" placeholder="Số lượng tồn" required min="0">
            </div>

            <div class="form-group">
                <label for="hansudung">Hạn sử dụng</label>
                <input type="date" class="form-control" id="hansudung" name="hansudung" required>
            </div>

            <div class="form-group">
                <label for="maloai">Mã loại thuốc</label>
                <input type="number" class="form-control" id="maloai" name="maloai" placeholder="Mã loại thuốc" required min="1">
            </div>

            <div class="form-group">
                <label for="mahangsx">Nhà sản xuất</label>
                <select class="form-control" id="mahangsx" name="mahangsx" required>
                    <?php foreach ($manufacturers as $manufacturer): ?>
                        <option value="<?= htmlspecialchars($manufacturer['mahangsx']) ?>">
                            <?= htmlspecialchars($manufacturer['tenhang']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="manhacungcap">Nhà cung cấp</label>
                <select class="form-control" id="manhacungcap" name="manhacungcap" required>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?= htmlspecialchars($supplier['manhacungcap']) ?>">
                            <?= htmlspecialchars($supplier['tennhacungcap']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">✅ Thêm thuốc</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
