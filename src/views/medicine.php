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

// Xử lý thông báo trạng thái từ URL
$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thuốc</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            background-color: blue;
            border-radius: 5px;
            margin-right: 5px;
        }
        .btn-delete {
            background-color: red;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h2>Danh sách thuốc</h2>
    <?php if (!empty($status)): ?>
        <div class="message <?php echo $status === 'success' ? 'success' : 'error'; ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    <a href="/medicine/add" class="btn">➕ Thêm thuốc</a>

    <table>
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
                        <!-- Nút sửa -->
                        <a href="/medicine/edit/<?= $medicine['mathuoc'] ?>" class="btn">✏️ Sửa</a>

                        <!-- Nút xóa -->
                        <form action="/medicine/delete" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $medicine['mathuoc'] ?>">
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10">Không có thuốc nào trong danh sách.</td></tr>
        <?php endif; ?>
    </table>
    <!-- Trong views/medicine.php, thêm sau tiêu đề hoặc nút "Thêm thuốc" -->
<a href="/medicine/export" class="btn">📥 Xuất Excel</a>
</body>
</html>