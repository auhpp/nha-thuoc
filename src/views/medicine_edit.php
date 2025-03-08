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

// Lấy ID từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id && isset($_SERVER['REQUEST_URI'])) {
    $parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $id = intval(end($parts));
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
$categories = $model->getAllCategories();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center">✏️ Chỉnh sửa thuốc: <?= htmlspecialchars($medicine['tenthuoc']) ?></h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <div class="card p-4 shadow-sm mx-auto" style="max-width: 500px;">
        <form action="/medicine/edit/<?= $medicine['mathuoc'] ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Tên thuốc</label>
                <input type="text" name="tenthuoc" value="<?= htmlspecialchars($medicine['tenthuoc']) ?>" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Công dụng</label>
                <input type="text" name="congdung" value="<?= htmlspecialchars($medicine['congdung']) ?>" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Đơn giá (VND)</label>
                <input type="number" name="dongia" value="<?= htmlspecialchars($medicine['dongia']) ?>" class="form-control" step="0.01" required min="0">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Số lượng tồn</label>
                <input type="number" name="soluongton" value="<?= htmlspecialchars($medicine['soluongton']) ?>" class="form-control" required min="0">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Hạn sử dụng</label>
                <input type="date" name="hansudung" value="<?= htmlspecialchars($medicine['hansudung']) ?>" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Loại thuốc</label>
                <select class="form-select" id="maloai" name="maloai" required>
                    <option value="" disabled selected>Vui lòng chọn loại thuốc</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['maloai']) ?>" <?= ($medicine['maloai'] == $category['maloai']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['tenloai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nhà sản xuất</label>
                <select name="mahangsx" class="form-select" required>
                    <option value="" disabled selected>Vui lòng chọn nhà sản xuất</option>
                    <?php foreach ($manufacturers as $manufacturer): ?>
                        <option value="<?= htmlspecialchars($manufacturer['mahangsx']) ?>" <?= ($medicine['mahangsx'] == $manufacturer['mahangsx']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($manufacturer['tenhang']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nhà cung cấp</label>
                <select name="manhacungcap" class="form-select" required>
                    <option value="" disabled selected>Vui lòng chọn nhà cung cấp</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?= htmlspecialchars($supplier['manhacungcap']) ?>" <?= ($medicine['manhacungcap'] == $supplier['manhacungcap']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($supplier['tennhacungcap']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
        </form>
    </div>
    
    <div class="text-center mt-3">
        <a href="/medicine" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>