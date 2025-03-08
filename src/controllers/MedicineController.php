<?php
namespace App\Controllers;

use App\Models\MedicineModel;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once __DIR__ . '/../models/MedicineModel.php';

class MedicineController
{
    private $model;

    public function __construct()
    {
        $this->model = new MedicineModel();
    }

    // Hiển thị danh sách thuốc
    public function index()
    {
        $medicines = $this->model->getAllMedicines();
        include __DIR__ . '/../views/medicine.php';
    }

    // Trang thêm thuốc
    public function add()
    {
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
    public function edit($id = null)
    {
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
    public function delete()
    {
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
    public function exportExcel()
    {
        try {
            $medicines = $this->model->getAllMedicines();
            usort($medicines, function ($a, $b) {
                return $a['maloai'] <=> $b['maloai'];
            });
            $categories = $this->model->getAllCategories();
            $manufacturers = $this->model->getAllManufacturers();
            $suppliers = $this->model->getAllSuppliers();

            // Tạo mảng map cho các danh sách
            $categoryMap = array_column($categories, 'tenloai', 'maloai');
            $manufacturerMap = array_column($manufacturers, 'tenhang', 'mahangsx');
            $supplierMap = array_column($suppliers, 'tennhacungcap', 'manhacungcap');

            // Khởi tạo Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Tiêu đề cột
            $headers = ['ID', 'Tên thuốc', 'Công dụng', 'Đơn giá (VND)', 'Số lượng tồn', 'Hạn sử dụng', 'Loại thuốc', 'Nhà sản xuất', 'Nhà cung cấp', 'Tổng tiền (VND)'];
            $sheet->fromArray($headers, null, 'A1');

            // Định dạng tiêu đề
            $sheet->getStyle('A1:J1')->getFont()->setBold(true);
            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Thêm dữ liệu thuốc
            $row = 2;
            $totalQuantity = 0;
            $totalValue = 0;

            foreach ($medicines as $medicine) {
                $totalPrice = $medicine['dongia'] * $medicine['soluongton'];

                $sheet->setCellValue('A' . $row, $medicine['mathuoc']);
                $sheet->setCellValue('B' . $row, $medicine['tenthuoc']);
                $sheet->setCellValue('C' . $row, $medicine['congdung']);
                $sheet->setCellValue('D' . $row, $medicine['dongia']);
                $sheet->setCellValue('E' . $row, $medicine['soluongton']);

                
                $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($medicine['hansudung']));
                $sheet->setCellValue('F' . $row, $dateValue);
                $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('DD/MM/YYYY');

                
                $sheet->setCellValue('G' . $row, $categoryMap[$medicine['maloai']] ?? 'Không xác định');
                $sheet->setCellValue('H' . $row, $manufacturerMap[$medicine['mahangsx']] ?? 'Không xác định');
                $sheet->setCellValue('I' . $row, $supplierMap[$medicine['manhacungcap']] ?? 'Không xác định');

                // Tổng tiền
                $sheet->setCellValue('J' . $row, $totalPrice);
                $sheet->getStyle('D' . $row . ':J' . $row)->getNumberFormat()->setFormatCode('#,##0');

                $totalQuantity += $medicine['soluongton'];
                $totalValue += $totalPrice;
                $row++;
            }

            // Tính tổng số loại thuốc
            $uniqueCategories = array_unique(array_column($medicines, 'maloai'));
            $totalMedicinesCount = count($uniqueCategories);
            

            // Thêm dòng tổng số loại thuốc
            $sheet->setCellValue('G' . $row, 'Tổng số loại thuốc:');
            $sheet->setCellValue('H' . $row, $totalMedicinesCount);
            $sheet->getStyle('G' . $row . ':H' . $row)->getFont()->setBold(true);

            $row++;

            // Thêm tổng số lượng thuốc
            $sheet->setCellValue('G' . $row, 'Tổng số lượng thuốc:');
            $sheet->setCellValue('H' . $row, $totalQuantity);
            $sheet->getStyle('G' . $row . ':H' . $row)->getFont()->setBold(true);

            $row++;

            // Thêm tổng tiền
            $sheet->setCellValue('G' . $row, 'Tổng tiền tất cả:');
            $sheet->setCellValue('H' . $row, $totalValue);
            $sheet->getStyle('G' . $row . ':H' . $row)->getFont()->setBold(true);
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');

            // Căn chỉnh cột tự động
            foreach (range('A', 'J') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Xuất file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="danh_sach_thuoc.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            header("Location: /medicine?status=error&message=" . urlencode("Lỗi khi xuất file Excel: " . $e->getMessage()));
            exit;
        }
    }

}