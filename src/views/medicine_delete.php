<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../models/MedicineModel.php';

use App\Models\MedicineModel;

// Khởi tạo model
try {
    $model = new MedicineModel();
} catch (Exception $e) {
    header("Location: medicine.php?status=error&message=" . urlencode("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage()));
    exit;
}

// Xử lý yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra và lấy ID từ POST một cách an toàn
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        try {
            // Gọi phương thức xóa thuốc
            if ($model->deleteMedicine($id)) {
                header("Location: /medicine?status=success");
                exit;
            } else {
                header("Location: /medicine?status=error&message=" . urlencode("Không thể xóa thuốc."));
                exit;
            }
        } catch (Exception $e) {
            header("Location: /medicine?status=error&message=" . urlencode("Lỗi khi xóa thuốc: " . $e->getMessage()));
            exit;
        }
    } else {
        header("Location: /medicine?status=invalid_id&message=" . urlencode("ID không hợp lệ."));
        exit;
    }
} else {
    header("Location: /medicine?status=invalid_request&message=" . urlencode("Yêu cầu không hợp lệ."));
    exit;
}