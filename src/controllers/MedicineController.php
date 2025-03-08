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

        $error = ""; 
        $manufacturers = $this->model->getAllManufacturers();
        $suppliers = $this->model->getAllSuppliers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
            $tenthuoc = $_POST['tenthuoc'] ?? '';
            $congdung = $_POST['congdung'] ?? '';
            $dongia = $_POST['dongia'] ?? '';
            $soluongton = $_POST['soluongton'] ?? '';
            $hansudung = $_POST['hansudung'] ?? '';
            $maloai = $_POST['maloai'] ?? '';
            $mahangsx = $_POST['mahangsx'] ?? '';
            $manhacungcap = $_POST['manhacungcap'] ?? '';
            
            if (!empty($tenthuoc) && !empty($dongia) && !empty($soluongton)) { 
                $data = [
                    'mathuoc' => $id,
                    'tenthuoc' => $tenthuoc,
                    'congdung' => $congdung,
                    'dongia' => floatval($dongia), 
                    'soluongton' => intval($soluongton), 
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
            // Lấy dữ liệu thuốc từ model
            $medicines = $this->model->getAllMedicines();
            $categories = $this->model->getAllCategories();
            $manufacturers = $this->model->getAllManufacturers();
            $suppliers = $this->model->getAllSuppliers();
    
            // Tạo bảng ánh xạ ID với tên danh mục, nhà sản xuất, nhà cung cấp
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
    
            // Khởi tạo file Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            // Tiêu đề cột
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Tên thuốc');
            $sheet->setCellValue('C1', 'Công dụng');
            $sheet->setCellValue('D1', 'Đơn giá (VND)');
            $sheet->setCellValue('E1', 'Số lượng tồn');
            $sheet->setCellValue('F1', 'Hạn sử dụng');
            $sheet->setCellValue('G1', 'Loại thuốc');
            $sheet->setCellValue('H1', 'Nhà sản xuất');
            $sheet->setCellValue('I1', 'Nhà cung cấp');
            $sheet->setCellValue('J1', 'Tổng tiền (VND)');
    
            // Định dạng tiêu đề
            $sheet->getStyle('A1:J1')->getFont()->setBold(true);
    
            // Khởi tạo biến tổng
            $totalAllMedicines = 0; // Tổng tiền tất cả thuốc
            $totalQuantity = 0; // Tổng số lượng thuốc
            $totalMedicinesCount = count($medicines); // Tổng số loại thuốc
    
            // Duyệt danh sách thuốc và điền dữ liệu
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
    
                // Tính tổng tiền cho từng loại thuốc
                $totalPrice = $medicine['dongia'] * $medicine['soluongton'];
                $sheet->setCellValue('J' . $row, $totalPrice);
    
                // Định dạng số tiền
                $sheet->getStyle('D' . $row . ':J' . $row)->getNumberFormat()->setFormatCode('#,##0');
    
                // Cộng dồn tổng số lượng và tổng tiền
                $totalQuantity += $medicine['soluongton'];
                $totalAllMedicines += $totalPrice;
    
                $row++;
            }
    
            // Thêm dòng tổng vào cuối bảng
            $row++;
    
            $sheet->setCellValue('G' . $row, 'Tổng số loại thuốc:');
            $sheet->setCellValue('H' . $row, $totalMedicinesCount);
            $sheet->getStyle('G' . $row)->getFont()->setBold(true);
            $sheet->getStyle('H' . $row)->getFont()->setBold(true);
    
            $row++;
    
            $sheet->setCellValue('G' . $row, 'Tổng số lượng thuốc:');
            $sheet->setCellValue('H' . $row, $totalQuantity);
            $sheet->getStyle('G' . $row)->getFont()->setBold(true);
            $sheet->getStyle('H' . $row)->getFont()->setBold(true);
    
            $row++;
    
            $sheet->setCellValue('G' . $row, 'Tổng tiền tất cả:');
            $sheet->setCellValue('H' . $row, $totalAllMedicines);
            $sheet->getStyle('G' . $row)->getFont()->setBold(true);
            $sheet->getStyle('H' . $row)->getFont()->setBold(true);
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
    
            // Xuất file Excel
            $writer = new Xlsx($spreadsheet);
    

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