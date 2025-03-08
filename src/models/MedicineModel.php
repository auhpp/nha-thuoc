<?php
namespace App\Models;

use PDO;
use PDOException;
use Exception;

require_once __DIR__ . '/../../bootstrap.php';

class MedicineModel {
    private $pdo;

    public function __construct() {
        global $PDO;
        if (!$PDO) {
            die("Lỗi kết nối CSDL.");
        }
        $this->pdo = $PDO;
    }

    // Lấy tất cả các nhà sản xuất
    public function getAllManufacturers() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM hangsanxuat");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn nhà sản xuất: " . $e->getMessage());
        }
    }

    // Lấy tất cả các nhà cung cấp
    public function getAllSuppliers() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM nhacungcap");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn nhà cung cấp: " . $e->getMessage());
        }
    }
    // Lấy tất cả các loại thuốc
public function getAllCategories() {
    try {
        $stmt = $this->pdo->query("SELECT maloai, tenloai FROM loaithuoc");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Lỗi truy vấn loại thuốc: " . $e->getMessage());
    }
}

    // Lấy tất cả các loại thuốc
    public function getAllMedicines() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM thuoc");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn thuốc: " . $e->getMessage());
        }
    }

    // Lấy thuốc theo ID
    public function getMedicineById($id) {
        if (!$id) return null; // Tránh lỗi ID null
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM thuoc WHERE mathuoc = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn thuốc: " . $e->getMessage());
        }
    }
    
    // Thêm thuốc mới
    public function addMedicine($data) {
        try {
       
            if (empty($data['tenthuoc']) || empty($data['dongia']) || empty($data['soluongton'])) {
                throw new Exception("Tên thuốc, đơn giá, và số lượng tồn không được để trống.");
            }

           
            $tenthuoc = htmlspecialchars($data['tenthuoc'] ?? '');
            $congdung = htmlspecialchars($data['congdung'] ?? '');
            $dongia = floatval($data['dongia'] ?? 0);
            $soluongton = intval($data['soluongton'] ?? 0); 
            $hansudung = $data['hansudung'] ?? date('Y-m-d', strtotime('+1 year')); 
            $maloai = $data['maloai'] ?? null; 
            $mahangsx = $data['mahangsx'] ?? null; 
            $manhacungcap = $data['manhacungcap'] ?? null; 

            // Chuẩn bị và thực thi câu lệnh INSERT
            $stmt = $this->pdo->prepare("INSERT INTO thuoc (tenthuoc, congdung, dongia, soluongton, hansudung, maloai, mahangsx, manhacungcap) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $tenthuoc,
                $congdung,
                $dongia,
                $soluongton,
                $hansudung,
                $maloai,
                $mahangsx,
                $manhacungcap
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Lỗi thêm thuốc: " . $e->getMessage());
        }
    }

    // Cập nhật thuốc
    public function updateMedicine($data) {
        try {
            // Kiểm tra ID hợp lệ
            if (empty($data['mathuoc'])) {
                throw new Exception("ID không hợp lệ.");
            }

            // Validate the data
            if (empty($data['tenthuoc']) || empty($data['dongia']) || empty($data['soluongton'])) {
                throw new Exception("Tên thuốc, đơn giá, và số lượng tồn không được để trống.");
            }

            // Lấy dữ liệu với giá trị mặc định nếu không tồn tại
            $mathuoc = $data['mathuoc'];
            $tenthuoc = htmlspecialchars($data['tenthuoc'] ?? '');
            $congdung = htmlspecialchars($data['congdung'] ?? '');
            $dongia = floatval($data['dongia'] ?? 0);
            $soluongton = intval($data['soluongton'] ?? 0);
            $hansudung = $data['hansudung'] ?? date('Y-m-d', strtotime('+1 year'));
            $maloai = $data['maloai'] ?? null;
            $mahangsx = $data['mahangsx'] ?? null;
            $manhacungcap = $data['manhacungcap'] ?? null;

            $stmt = $this->pdo->prepare("UPDATE thuoc SET tenthuoc=?, congdung=?, dongia=?, soluongton=?, hansudung=?, maloai=?, mahangsx=?, manhacungcap=? WHERE mathuoc=?");
            $stmt->execute([
                $tenthuoc,
                $congdung,
                $dongia,
                $soluongton,
                $hansudung,
                $maloai,
                $mahangsx,
                $manhacungcap,
                $mathuoc
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Lỗi cập nhật thuốc: " . $e->getMessage());
        }
    }
// Tìm kiếm thuốc theo tên, ID hoặc công dụng
public function searchMedicines($keyword) {
    try {
        $keyword = "%{$keyword}%"; // Thêm ký tự % để tìm kiếm một phần
        $stmt = $this->pdo->prepare("SELECT * FROM thuoc WHERE mathuoc LIKE ? OR tenthuoc LIKE ? OR congdung LIKE ?");
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Lỗi tìm kiếm thuốc: " . $e->getMessage());
    }
}

    // Xóa thuốc
    public function deleteMedicine($id) {
        try {
            if (!$id) {
                throw new Exception("ID không hợp lệ.");
            }

            $stmt = $this->pdo->prepare("DELETE FROM thuoc WHERE mathuoc=?");
            $stmt->execute([$id]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Lỗi xóa thuốc: " . $e->getMessage());
        }
    }
       // Tính tổng giá trị của một loại thuốc (số lượng * đơn giá)
       public function getTotalValue($medicineId)
       {
           $stmt = $this->pdo->prepare("SELECT dongia, soluongton FROM thuoc WHERE mathuoc = ?");
           $stmt->execute([$medicineId]);
           $medicine = $stmt->fetch(PDO::FETCH_ASSOC);
   
           if ($medicine) {
               return $medicine['dongia'] * $medicine['soluongton'];
           }
   
           return 0;
       }
   
       // Tính tổng số loại thuốc
       public function getTotalMedicineTypes()
       {
           $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM thuoc");
           return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
       }
   
       // Tính tổng số lượng tất cả thuốc
       public function getTotalMedicineQuantity()
       {
           $stmt = $this->pdo->query("SELECT SUM(soluongton) AS total FROM thuoc");
           return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
       }
   
       // Tính tổng giá trị của tất cả thuốc trong kho
       public function getTotalMedicineValue()
       {
           $stmt = $this->pdo->query("SELECT SUM(dongia * soluongton) AS total FROM thuoc");
           return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
       }
    
}
