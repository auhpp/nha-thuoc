<?php

namespace App\Models;

use App\Models\Response\CustomerResponse;
use App\Models\Response\MedicineResponse;
use PDO;

class Bill
{
    private PDO $db;

    private int $id = -1;
    private string $customerName;
    private string $createdAt;
    private string $amount;


    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    private function fillFromDbRow(array $row): Bill
    {
        [
            'mahoadon' => $this->id,
            'tenkhachhang' => $this->customerName,
            'ngaylap' => $this->createdAt,
            'tongtien' => $this->amount
        ] = $row;
        return $this;
    }


    //Thong ke theo ngay
    public function getRevenue($date = null, $startDate = null, $endDate = null, $month = null, $year = null)
    {

        $query = "SELECT hd.mahoadon, kh.tenkhachhang, kh.sodienthoai, hd.ngaylap, hd.tongtien 
                FROM hoadon hd INNER JOIN khachhang kh 
                ON hd.makhachhang = kh.makhachhang
        ";
        $where = " WHERE 1 = 1";
        if ($date != null) {
            $where .= " AND hd.ngaylap = :ngayLap ";
        } else if ($startDate != null && $endDate != null) {
            $where .= " AND hd.ngaylap BETWEEN :startDate AND :endDate ";
        } else if ($month != null && $year != null) {
            $where .= " AND MONTH(hd.ngayLap) = :monthRe  AND YEAR(hd.ngayLap) = :yearRe";
        }
        $query .= $where;
        echo $query;
        $statement = $this->db->prepare($query);
        if ($date != null) {
            $statement->execute([
                "ngayLap" => $date
            ]);
        } else if ($startDate != null && $endDate != null) {
            $statement->execute([
                "startDate" => $startDate,
                "endDate" => $endDate
            ]);
        } else {
            $statement->execute([
                "monthRe" => $month,
                "yearRe" => $year
            ]);
        }
        $bills = [];
        while ($row = $statement->fetch()) {
            $bill = new Bill($this->db);
            $bill->fillFromDbRow($row);
            $bills[] = $bill;
        }

        return $bills;
    }



    //Thong ke theo thuoc ban chay
    public function getMedicalRevenue($date = null, $startDate = null, $endDate = null, $month = null, $year = null)
    {

        $query = "SELECT t.tenthuoc, SUM(cthd.soluongban) AS soluongban, lt.donvitinh, SUM(cthd.soluongban * cthd.giaban) AS doanhthu
                    from chitiethoadon cthd INNER JOIN thuoc t ON cthd.mathuoc = t.mathuoc 
                    INNER JOIN loaithuoc lt ON t.maloai = lt.maloai
                    INNER JOIN hoadon hd ON hd.mahoadon = cthd.mahoadon 
        ";
        $where = " WHERE 1 = 1";
        if ($date != null) {
            $where .= " AND hd.ngaylap = :ngayLap ";
        } else if ($startDate != null && $endDate != null) {
            $where .= " AND hd.ngaylap BETWEEN :startDate AND :endDate ";
        } else if ($month != null && $year != null) {
            $where .= " AND MONTH(hd.ngayLap) = :monthRe  AND YEAR(hd.ngayLap) = :yearRe";
        }
        $where .= " GROUP BY t.mathuoc
                    ORDER BY SUM(cthd.soluongban) desc";
        $query .= $where;
        $statement = $this->db->prepare($query);
        if ($date != null) {
            $statement->execute([
                "ngayLap" => $date
            ]);
        } else if ($startDate != null && $endDate != null) {
            $statement->execute([
                "startDate" => $startDate,
                "endDate" => $endDate
            ]);
        } else {
            $statement->execute([
                "monthRe" => $month,
                "yearRe" => $year
            ]);
        }

        $medicineResponses = [];
        while ($row = $statement->fetch()) {
            $response = new MedicineResponse();
            [
                'tenthuoc' => $response->medicineName,
                'soluongban' => $response->sold,
                'donvitinh' => $response->unit,
                'doanhthu' => $response->amount
            ] = $row;
            $medicineResponses[] = $response;
        }

        return $medicineResponses;
    }

    //Thong ke theo khach hang mua nhieu
    public function getCustomerRevenue($date = null, $startDate = null, $endDate = null, $month = null, $year = null)
    {

        $query = "SELECT kh.makhachhang, kh.tenkhachhang, kh.sodienthoai, SUM(hd.tongtien) AS sotien
                    from hoadon hd INNER JOIN khachhang kh ON hd.makhachhang = kh.makhachhang 
        ";
        $where = " WHERE 1 = 1 ";    
        if ($date != null) {
            $where .= " AND hd.ngaylap = :ngayLap ";
        } else if ($startDate != null && $endDate != null) {
            $where .= " AND hd.ngaylap BETWEEN :startDate AND :endDate ";
        } else if ($month != null && $year != null) {
            $where .= " AND MONTH(hd.ngayLap) = :monthRe  AND YEAR(hd.ngayLap) = :yearRe";
        }
        $where .= " GROUP BY kh.makhachhang
                    ORDER BY SUM(hd.tongtien) desc";
        $query .= $where;
        $statement = $this->db->prepare($query);
        if ($date != null) {
            $statement->execute([
                "ngayLap" => $date
            ]);
        } else if ($startDate != null && $endDate != null) {
            $statement->execute([
                "startDate" => $startDate,
                "endDate" => $endDate
            ]);
        } else {
            $statement->execute([
                "monthRe" => $month,
                "yearRe" => $year
            ]);
        }

        $customerResponses = [];
        while ($row = $statement->fetch()) {
            $response = new CustomerResponse();
            [
                'makhachhang' => $response->customerId,
                'tenkhachhang' => $response->customerName,
                'sodienthoai' => $response->phoneNumber,
                'sotien' => $response->amount
            ] = $row;
            $customerResponses[] = $response;
        }

        return $customerResponses;
    }
}
