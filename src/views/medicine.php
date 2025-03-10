<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../models/MedicineModel.php';
use App\Models\MedicineModel;
try {
    $model = new MedicineModel();
} catch (Exception $e) {
    die("Lỗi: Không thể kết nối cơ sở dữ liệu - " . $e->getMessage());
}
$searchKeyword = $_GET['search'] ?? '';
if (!empty($searchKeyword)) {
    $medicines = $model->searchMedicines($searchKeyword);
} else {
    $medicines = $model->getAllMedicines();
}

$manufacturers = $model->getAllManufacturers();
$suppliers = $model->getAllSuppliers();
$categories = $model->getAllCategories();

$categoryMap = [];
foreach ($categories as $category) {
    $categoryMap[$category['maloai']] = $category['tenloai'];
}
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$totalMedicines = count($medicines);
$totalPages = ceil($totalMedicines / $limit);
$medicines = array_slice($medicines, $offset, $limit);

$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thuốc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\assets\css\style.css">
    <style>
        .container {
            max-width: 1200px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .btn {
            min-width: 80px;
        }

        .alert {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1050;
        }

        .table thead {
            background-color: #009B49 !important;
            color: white;
        }

        .total-summary {
            background-color: #009B49;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .total-summary div {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .total-summary i {
            font-size: 22px;
        }
    </style>
</head>

<body class="container mt-4">
    <h2 class="text-center mb-4 header-title">📋 Danh sách thuốc</h2>

    <?php if (!empty($status) && !empty($message)): ?>
        <div id="alert-message"
            class="alert <?= $status === 'success' ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show"
            role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
        <script>
            setTimeout(function () {
                var alertMessage = document.getElementById("alert-message");
                if (alertMessage) {
                    alertMessage.style.display = "none";
                }
            }, 5000);
        </script>
    <?php endif; ?>

    <div class="d-flex justify-content-start gap-2 mb-3">
        <a href="/medicine/add" class="btn btn-primary">✚ Thêm thuốc</a>
        <a href="/medicine/export" class="btn btn-success">📥 Xuất Excel</a>
    </div>


    <!-- Thanh tìm kiếm -->
    <form method="GET" class="mb-3 d-flex">
        <input style="height: 36px;" type="text" name="search" class="form-control me-2"
            placeholder="🔍 Tìm kiếm theo tên, ID hoặc công dụng..." value="<?= htmlspecialchars($searchKeyword) ?>">
        <button style="height: 36px;" type="submit" class="btn btn-outline-primary">Tìm 🔍</button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên thuốc</th>
                    <th>Công dụng</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Hạn sử dụng</th>
                    <th>Loại</th>
                    <th>Nhà sản xuất</th>
                    <th>Nhà cung cấp</th>
                    <th>Tổng giá trị</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicines as $medicine): ?>
                    <tr>
                        <td><?= htmlspecialchars($medicine['mathuoc']) ?></td>
                        <td><?= htmlspecialchars($medicine['tenthuoc']) ?></td>
                        <td><?= htmlspecialchars($medicine['congdung']) ?></td>
                        <td><?= number_format($medicine['dongia'], 0, ',', '.') ?> VND</td>
                        <td><?= htmlspecialchars($medicine['soluongton']) ?></td>
                        <td><?= date('d/m/Y', strtotime($medicine['hansudung'])) ?></td>
                        <td><?= htmlspecialchars($categoryMap[$medicine['maloai']] ?? 'Không xác định') ?></td>
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
                        <td><?= number_format($model->getTotalValue($medicine['mathuoc']), 0, ',', '.') ?> VND</td>
                        <!-- Gọi function -->
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/medicine/edit/<?= $medicine['mathuoc'] ?>" class="btn btn-warning btn-sm">✏️
                                    Sửa</a>
                                <form action="/medicine/delete" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $medicine['mathuoc'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
    <?php
    // Tính tổng tiền của tất cả thuốc trong cơ sở dữ liệu
    $allMedicines = $model->getAllMedicines(); // Lấy toàn bộ danh sách thuốc
    $totalAllMedicines = array_sum(array_map(fn($m) => $m['dongia'] * $m['soluongton'], $allMedicines));
    ?>

    <?php
    $totalMedicinesCount = $model->getTotalMedicineTypes(); // Tổng số loại thuốc
    $totalQuantity = $model->getTotalMedicineQuantity(); // Tổng số lượng thuốc
    $totalAllMedicines = $model->getTotalMedicineValue(); // Tổng giá trị tất cả thuốc
    ?>



    <div class="total-summary">
        <div>
            <i class="fas fa-pills"></i>
            <span>📝 Tổng số loại thuốc: <strong><?= $totalMedicinesCount ?></strong></span>
        </div>
        <div>
            <i class="fas fa-box"></i>
            <span>📦 Tổng số lượng thuốc: <strong><?= $totalQuantity ?></strong></span>
        </div>
        <div>
            <i class="fas fa-money-bill-wave"></i>
            <span>💰 Tổng tiền tất cả thuốc: <strong><?= number_format($totalAllMedicines, 0, ',', '.') ?>
                    VND</strong></span>
        </div>
    </div>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($searchKeyword) ?>"> <?= $i ?> </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>