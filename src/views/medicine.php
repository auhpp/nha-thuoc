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

// Lấy danh sách thuốc, nhà sản xuất, và nhà cung cấp
$medicines = $model->getAllMedicines();
$manufacturers = $model->getAllManufacturers();
$suppliers = $model->getAllSuppliers();

 if (isset($_GET['status']) && isset($_GET['message'])): ?>
    <div id="message" class="alert alert-success" role="alert">
        <?= htmlspecialchars($_GET['message']) ?>
    </div>
    <script>
        setTimeout(function() {
            var message = document.getElementById('message');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000); // 5000 ms = 5 seconds
    </script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thuốc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center mb-4">Danh sách thuốc</h2>
    
    <?php if (!empty($status)): ?>
        <div class="alert <?= $status === 'success' ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <a href="/medicine/add" class="btn btn-primary">➕ Thêm thuốc</a>
        <a href="/medicine/export" class="btn btn-success">📥 Xuất Excel</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên thuốc</th>
                    <th>Công dụng</th>
                    <th>Đơn giá</th>
                    <th>Số lượng tồn</th>
                    <th>Hạn sử dụng</th>
                    <th>Loại</th>
                    <th>Nhà sản xuất</th>
                    <th>Nhà cung cấp</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($medicines)): ?>
                    <?php foreach ($medicines as $medicine): ?>
                        <tr>
                            <td><?= htmlspecialchars($medicine['mathuoc']) ?></td>
                            <td><?= htmlspecialchars($medicine['tenthuoc']) ?></td>
                            <td><?= htmlspecialchars($medicine['congdung']) ?></td>
                            <td><?= number_format($medicine['dongia'], 0, ',', '.') ?> VND</td>
                            <td><?= htmlspecialchars($medicine['soluongton']) ?></td>
                            <td><?= htmlspecialchars($medicine['hansudung']) ?></td>
                            <td><?= htmlspecialchars($medicine['maloai']) ?></td>
                            <td>
                                <?php
                                $manufacturer = array_filter($manufacturers, fn($m) => $m['mahangsx'] == $medicine['mahangsx']);
                                echo htmlspecialchars(!empty($manufacturer) ? reset($manufacturer)['tenhang'] : $medicine['mahangsx']);
                                ?>
                            </td>
                            <td>
                                <?php
                                $supplier = array_filter($suppliers, fn($s) => $s['manhacungcap'] == $medicine['manhacungcap']);
                                echo htmlspecialchars(!empty($supplier) ? reset($supplier)['tennhacungcap'] : $medicine['manhacungcap']);
                                ?>
                            </td>
                            <td>
                                <a href="/medicine/edit/<?= $medicine['mathuoc'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                                <form action="/medicine/delete" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $medicine['mathuoc'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10" class="text-center">Không có thuốc nào trong danh sách.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
