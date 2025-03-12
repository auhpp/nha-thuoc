<?php

namespace App\Controllers;

use App\Models\Bill;
use DateTime;
use Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class StatisticalController
{

    public function index()
    {
        // echo $revenue;
        $priceResult = [];
        $totalRevenue = 0;
        $medicineResult = [];
        $customerResult = [];
        require PAGES_DIR . "/statistical.php";
    }

    public function revenueByWeek()
    {
        $weekRequest = $_GET['week'];
        $year = substr($weekRequest, 0, 4);
        $week = substr($weekRequest, 6);

        $dateTime = new DateTime();
        $dateTime->setISODate($year, $week);
        $startDate = $dateTime->format('Y-m-d');
        $dateTime->modify('+6 days');
        $endDate = $dateTime->format('Y-m-d');

        global $PDO;
        $bill = new Bill($PDO);
        $priceResult = $bill->getRevenue(startDate: $startDate, endDate: $endDate);

        $medicineResult = $bill->getMedicalRevenue(startDate: $startDate, endDate: $endDate);

        $customerResult = $bill->getCustomerRevenue(startDate: $startDate, endDate: $endDate);
        $totalRevenue = $bill->getTotalMoney(startDate: $startDate, endDate: $endDate);
        require PAGES_DIR . "/statistical.php";
    }


=======
    public function revenueByDay()
    {
        $dateRequest = $_GET['day'];
        global $PDO;
        $bill = new Bill($PDO);
        $priceResult = $bill->getRevenue(date: $dateRequest);

        //Thuoc ban chay
        $medicineResult = $bill->getMedicalRevenue(date: $dateRequest);

        $customerResult = $bill->getCustomerRevenue(date: $dateRequest);
        $totalRevenue = $bill->getTotalMoney(date: $dateRequest);
        require PAGES_DIR . "/statistical.php";
    }


    public function revenueByMonth()
    {
        $monthRequest = $_GET['month'];
        $year = substr($monthRequest, 0, 4);
        $month = substr($monthRequest, 6);
        global $PDO;
        $bill = new Bill($PDO);
        $priceResult = $bill->getRevenue(month: $month, year: $year);
        $medicineResult = $bill->getMedicalRevenue(month: $month, year: $year);
        $customerResult = $bill->getCustomerRevenue(month: $month, year: $year);
        $totalRevenue = $bill->getTotalMoney(month: $month, year: $year);
        require PAGES_DIR . "/statistical.php";
    }

    // Xuất danh sách hoa don ra file Excel
    public function exportRevenueExcel()
    {
        try {
            global $PDO;
            $bill = new Bill($PDO);
            $dateRequest = $_GET['day'] ?? null;

            $weekRequest = $_GET['week'] ?? null;
            $startDate = null;
            $endDate = null;
            if ($weekRequest != null) {
                $year = substr($weekRequest, 0, 4);
                $week = substr($weekRequest, 6);
                $dateTime = new DateTime();
                $dateTime->setISODate($year, $week);
                $startDate = $dateTime->format('Y-m-d');
                $dateTime->modify('+6 days');
                $endDate = $dateTime->format('Y-m-d');
            }
            $year = null;
            $month = null;
            $monthRequest = $_GET['month'] ?? null;
            if ($monthRequest != null) {
                $year = substr($monthRequest, 0, 4);
                $month = substr($monthRequest, 6);
            }
            $revenue = $bill->getRevenue(date: $dateRequest, startDate: $startDate, endDate: $endDate, month: $month, year: $year);
            $totalRevenue = $bill->getTotalMoney(date: $dateRequest, startDate: $startDate, endDate: $endDate, month: $month, year: $year);

            // Khởi tạo Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Tiêu đề cột
            $headers = ['Mã hóa đơn', 'Tên khách hàng', 'số điện thoại', 'Ngày lập', 'Tổng tiền(VNĐ)'];
            $sheet->fromArray($headers, null, 'A1');

            // Định dạng tiêu đề
            $sheet->getStyle('A1:J1')->getFont()->setBold(true);
            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Thêm dữ liệu 
            $row = 2;
            date_default_timezone_set('UTC');
            foreach ($revenue as $it) {
                $sheet->setCellValue('A' . $row, $it->id);
                $sheet->setCellValue('B' . $row, $it->customerName);
                $sheet->setCellValue('C' . $row, $it->phoneNumber);

                $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($it->createdAt));
                $sheet->setCellValue('D' . $row, $dateValue);
                $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('DD/MM/YYYY');

                $sheet->setCellValue('E' . $row, $it->amount);

                $row++;
            }



            // Thêm tổng tiền
            $sheet->setCellValue('D' . $row, 'Tổng doanh thu:');
            $sheet->setCellValue('E' . $row, $totalRevenue);
            $sheet->getStyle('D' . $row . ':H' . $row)->getFont()->setBold(true);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');

            // Căn chỉnh cột tự động
            foreach (range('A', 'J') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Xuất file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if ($dateRequest != null) {
                header('Content-Disposition: attachment;filename="doanh_thu_dua_theo_hoa_don_theo_thang.xlsx"');
            } else if ($startDate != null && $endDate != null) {
                header('Content-Disposition: attachment;filename="doanh_thu_dua_theo_hoa_don_theo_tuan.xlsx"');
            } else
                header('Content-Disposition: attachment;filename="doanh_thu_dua_theo_hoa_don_theo_thang.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            header("Location: /statistical?status=error&message=" . urlencode("Lỗi khi xuất file Excel: " . $e->getMessage()));
            exit;
        }
    }
}
