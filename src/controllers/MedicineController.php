<?php
namespace App\Controllers;

use App\Models\MedicineModel;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once __DIR__ . '/../models/MedicineModel.php';

class MedicineController {
    private $model;

    public function __construct() {
        $this->model = new MedicineModel();
    }

    // Hiển thị danh sách thuốc
    public function index() {
        $medicines = $this->model->getAllMedicines();
        include __DIR__ . '/../views/medicine.php';
    }

    // Trang thêm thuốc
    public function add() {
        $error = "";
        $model = $this->model;
    
        $manufacturers = $model->getAllManufacturers();
        $suppliers = $model->getAllSuppliers();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenthuoc = $_POST['tenthuoc'] ?? '';
            $congdung = $_POST['congdung'] ?? '';
            $dongia = $_POST['dongia'] ?? '';
            $soluongton = $_POST['soluongton'] ?? '';
            $hansudung = $_POST['hansudung'] ?? '';
            $maloai = $_POST['maloai'] ?? '';
            $mahangsx = $_POST['mahangsx'] ?? '';
            $manhacungcap = $_POST['manhacungcap'] ?? '';
            $tenhang = $_POST['tenhang'] ?? '';
            if (!empty($tenthuoc) && !empty($dongia) && !empty($soluongton)) { // Kiểm tra thêm soluongton
                $data = [
                    'tenthuoc' => $tenthuoc,
                    'congdung' => $congdung,
                    'dongia' => floatval($dongia), // Chuyển thành số thực
                    'soluongton' => intval($soluongton), // Chuyển thành số nguyên
                    'hansudung' => $hansudung,
                    'maloai' => $maloai,
                    'mahangsx' => $mahangsx,
                    'manhacungcap' => $manhacungcap,
                    'tenhang' => $tenhang,
                ];
                try {
                    if ($model->addMedicine($data)) {
                        header('Location: /medicine?status=success&message=' . urlencode("Thêm thuốc thành công."));
                        exit;
                    } else {
                        $error = "Lỗi: Không thể thêm thuốc.";
                    }
                } catch (Exception $e) {
                    $error = "Lỗi: " . $e->getMessage();
                }
            } else {
                $error = "Lỗi: Vui lòng nhập đầy đủ thông tin bắt buộc (tên thuốc, đơn giá, số lượng tồn).";
            }
        }
    
        include __DIR__ . '/../views/medicine_add.php';
    }

    // Trang chỉnh sửa thuốc
    public function edit($id = null) {
        if ($id === null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        } else {
            $id = intval($id);
        }

        // Kiểm tra ID hợp lệ
        if ($id <= 0) {
            header("Location: /medicine?status=invalid_id&message=" . urlencode("ID không hợp lệ."));
            exit;
        }

        // Lấy thông tin thuốc
        try {
            $medicine = $this->model->getMedicineById($id);
            if (!$medicine) {
                header("Location: /medicine?status=not_found&message=" . urlencode("Không tìm thấy thuốc."));
                exit;
            }
        } catch (Exception $e) {
            header("Location: /medicine?status=error&message=" . urlencode("Lỗi khi tải thông tin thuốc: " . $e->getMessage()));
            exit;
        }

        $error = ""; // Khởi tạo biến lỗi
        $manufacturers = $this->model->getAllManufacturers();
        $suppliers = $this->model->getAllSuppliers();

        // Kiểm tra nếu là POST request để xử lý cập nhật thuốc
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ $_POST một cách an toàn
            $tenthuoc = $_POST['tenthuoc'] ?? '';
            $congdung = $_POST['congdung'] ?? '';
            $dongia = $_POST['dongia'] ?? '';
            $soluongton = $_POST['soluongton'] ?? '';
            $hansudung = $_POST['hansudung'] ?? '';
            $maloai = $_POST['maloai'] ?? '';
            $mahangsx = $_POST['mahangsx'] ?? '';
            $manhacungcap = $_POST['manhacungcap'] ?? '';
            
            if (!empty($tenthuoc) && !empty($dongia) && !empty($soluongton)) { // Kiểm tra thêm soluongton
                $data = [
                    'mathuoc' => $id,
                    'tenthuoc' => $tenthuoc,
                    'congdung' => $congdung,
                    'dongia' => floatval($dongia), // Chuyển thành số thực
                    'soluongton' => intval($soluongton), // Chuyển thành số nguyên
                    'hansudung' => $hansudung,
                    'maloai' => $maloai,
                    'mahangsx' => $mahangsx,
                    'manhacungcap' => $manhacungcap
                ];
                try {
                    if ($this->model->updateMedicine($data)) {
                        header('Location: /medicine?status=success&message=' . urlencode("Cập nhật thuốc thành công."));
                        exit;
                    } else {
                        $error = "Lỗi: Không thể cập nhật thuốc.";
                    }
                } catch (Exception $e) {
                    $error = "Lỗi: " . $e->getMessage();
                }
            } else {
                $error = "Lỗi: Vui lòng nhập đầy đủ thông tin bắt buộc (tên thuốc, đơn giá, số lượng tồn).";
            }
        }

        // Hiển thị form chỉnh sửa thuốc
        include __DIR__ . '/../views/medicine_edit.php';
    }

    // Xóa thuốc
    public function delete() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if (!$id) {
            header("Location: /medicine?status=invalid_id&message=" . urlencode("ID không hợp lệ."));
            exit;
        }

        try {
            if ($this->model->deleteMedicine($id)) {
                header('Location: /medicine?status=success&message=' . urlencode("Xóa thuốc thành công."));
                exit;
            } else {
                header("Location: /medicine?status=error&message=" . urlencode("Không thể xóa thuốc."));
                exit;
            }
        } catch (Exception $e) {
            header("Location: /medicine?status=error&message=" . urlencode("Lỗi khi xóa thuốc: " . $e->getMessage()));
            exit;
        }
    }

    // Xuất danh sách thuốc ra file Excel
    public function exportExcel() {
        try {
            $medicines = $this->model->getAllMedicines();
            $categories = $this->model->getAllCategories();
            $manufacturers = $this->model->getAllManufacturers();
            $suppliers = $this->model->getAllSuppliers();
    
            // Tạo mapping để lấy tên loại thuốc, nhà sản xuất, nhà cung cấp từ mã
            $categoryMap = [];
            foreach ($categories as $category) {
                $categoryMap[$category['maloai']] = $category['tenloai'];
            }
    
            $manufacturerMap = [];
            foreach ($manufacturers as $manufacturer) {
                $manufacturerMap[$manufacturer['mahangsx']] = $manufacturer['tenhang'];
            }
    
            $supplierMap = [];
            foreach ($suppliers as $supplier) {
                $supplierMap[$supplier['manhacungcap']] = $supplier['tennhacungcap'];
            }
    
            // Tạo mới một spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            // Đặt tiêu đề cột
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Tên thuốc');
            $sheet->setCellValue('C1', 'Công dụng');
            $sheet->setCellValue('D1', 'Đơn giá (VND)');
            $sheet->setCellValue('E1', 'Số lượng tồn');
            $sheet->setCellValue('F1', 'Hạn sử dụng');
            $sheet->setCellValue('G1', 'Loại thuốc');
            $sheet->setCellValue('H1', 'Nhà sản xuất');
            $sheet->setCellValue('I1', 'Nhà cung cấp');
    
            // Điền dữ liệu
            $row = 2;
            foreach ($medicines as $medicine) {
                $sheet->setCellValue('A' . $row, $medicine['mathuoc']);
                $sheet->setCellValue('B' . $row, $medicine['tenthuoc']);
                $sheet->setCellValue('C' . $row, $medicine['congdung']);
                $sheet->setCellValue('D' . $row, $medicine['dongia']);
                $sheet->setCellValue('E' . $row, $medicine['soluongton']);
                
                // Định dạng ngày tháng năm
                $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($medicine['hansudung']));
                $sheet->setCellValue('F' . $row, $dateValue);
                $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                
                $sheet->setCellValue('G' . $row, $categoryMap[$medicine['maloai']] ?? 'Không xác định');
                $sheet->setCellValue('H' . $row, $manufacturerMap[$medicine['mahangsx']] ?? 'Không xác định');
                $sheet->setCellValue('I' . $row, $supplierMap[$medicine['manhacungcap']] ?? 'Không xác định');
                $row++;
            }
    
            // Định dạng cột đơn giá thành số tiền
            $sheet->getStyle('D2:D' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');
    
            // Tạo writer để xuất file Excel
            $writer = new Xlsx($spreadsheet);
    
            // Đặt header để trình duyệt tải file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="danh_sach_thuoc.xlsx"');
            header('Cache-Control: max-age=0');
    
            // Xuất file
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            header("Location: /medicine?status=error&message=" . urlencode("Lỗi khi xuất file Excel: " . $e->getMessage()));
            exit;
        }
    }
    
    
}