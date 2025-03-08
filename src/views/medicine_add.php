<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../models/MedicineModel.php';

use App\Models\MedicineModel;

// Khởi tạo model
$model = new MedicineModel();
$manufacturers = $model->getAllManufacturers();
$suppliers = $model->getAllSuppliers();
$categories = $model->getAllCategories(); // Lấy danh sách loại thuốc

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
        .btn-submit {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .btn-block {
            font-size: 1.1em;
            padding: 12px 30px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">➕ Thêm thuốc mới</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"> <?= $error ?> </div>
        <?php endif; ?>

        <div class="form-container">
            <form action="/medicine/add" method="POST">
                <div class="mb-3">
                    <label for="tenthuoc" class="form-label">Tên thuốc</label>
                    <input type="text" class="form-control" id="tenthuoc" name="tenthuoc" required>
                </div>

                <div class="mb-3">
                    <label for="congdung" class="form-label">Công dụng</label>
                    <input type="text" class="form-control" id="congdung" name="congdung" required>
                </div>

                <div class="mb-3">
                    <label for="dongia" class="form-label">Đơn giá (VND)</label>
                    <input type="number" class="form-control" id="dongia" name="dongia" step="0.01" required min="0">
                </div>

                <div class="mb-3">
                    <label for="soluongton" class="form-label">Số lượng tồn</label>
                    <input type="number" class="form-control" id="soluongton" name="soluongton" required min="0">
                </div>

                <div class="mb-3">
                    <label for="hansudung" class="form-label">Hạn sử dụng</label>
                    <input type="date" class="form-control" id="hansudung" name="hansudung" required>
                </div>

                <div class="mb-3">
                    <label for="maloai" class="form-label">Loại thuốc</label>
                    <select class="form-select" id="maloai" name="maloai" required>
                        <option value="" disabled selected>Vui lòng chọn loại thuốc</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['maloai']) ?>">
                                <?= htmlspecialchars($category['tenloai']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mahangsx" class="form-label">Nhà sản xuất</label>
                    <select class="form-select" id="mahangsx" name="mahangsx" required>
                        <option value="" disabled selected>Vui lòng chọn nhà sản xuất</option>
                        <?php foreach ($manufacturers as $manufacturer): ?>
                            <option value="<?= htmlspecialchars($manufacturer['mahangsx']) ?>">
                                <?= htmlspecialchars($manufacturer['tenhang']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="manhacungcap" class="form-label">Nhà cung cấp</label>
                    <select class="form-select" id="manhacungcap" name="manhacungcap" required>
                        <option value="" disabled selected>Vui lòng chọn nhà cung cấp</option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= htmlspecialchars($supplier['manhacungcap']) ?>">
                                <?= htmlspecialchars($supplier['tennhacungcap']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="btn-submit">
                    <button type="submit" class="btn btn-primary btn-block">✅ Thêm thuốc</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>