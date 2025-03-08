<?php

namespace App\Models;
use PDO;
use PDOException;
use Exception;

require_once __DIR__ . '/../../bootstrap.php';
class MedicineModel {
    private PDO $pdo;
    private int $id;
    public string $medicineName;
    public string $medicineEffect;
    public float $medicinePrice;
    public int $medicineInventory;
    public string $medicineExpiry;

    public function __construct() {
        global $PDO;
        $this->pdo = $PDO;;
    }


    private function fillFromDbRow(array $row): MedicineModel {
        $medicine = new MedicineModel();
        $medicine->id = $row['mathuoc'] ?? -1;
        $medicine->medicineName = $row['tenthuoc'] ?? '';
        $medicine->medicineEffect = $row['congdung'] ?? '';
        $medicine->medicinePrice = $row['dongia'] ?? 0;
        $medicine->medicineInventory = $row['soluongton'] ?? 0;
        $medicine->medicineExpiry = $row['hansudung'] ?? '';
        return $medicine;
    }
    // Lấy tất cả các thuốc có loại thuốc là $categoryName
    public function getMedicinesByCategory($categoryName) {
        $medicines = [];
        $statemant = $this->pdo->prepare(
            'Call GetMedicinesByCategory(:category_name)'
        );
        $statemant->execute([
            'category_name' => $categoryName
        ]);

        while($row = $statemant->fetch()) {
            $medicine = $this->fillFromDbRow($row);
            $medicines[] = $medicine;
        }

        return $medicines;
    }
    // Lấy tất cả các thuốc có loại thuốc là $hsx
    public function getMedicinesByHSX($hsx) {
        $mediciens = [];
        $statement = $this->pdo->prepare(
            'Call GetMedicinesByHSX(:hsx)'
        );
        $statement->execute([
            'hsx' => $hsx
        ]);

        while($row = $statement->fetch()) {
            $medicien = $this->fillFromDbRow($row);
            $mediciens[] = $medicien;
        }

        return $mediciens;
    }

    // Lấy tất cả các thuốc có loại thuốc là $ncc

    public function getMedicinesByNCC($ncc) {
        $mediciens = [];
        $statement = $this->pdo->prepare(
            'Call GetMedicinesByNCC(:ncc)'
        );
        $statement->execute([
            'ncc' => $ncc
        ]);

        while($row = $statement->fetch()) {
            $medicien = $this->fillFromDbRow($row);
            $mediciens[] = $medicien;
        }

        return $mediciens;
    }
}