<?php

namespace App\Controllers;
use App\Models\MedicineModel;
class MedicineController {
    public function index()
    {
        require PAGES_DIR . "/medicine_search.php";
    }

    public function getMedicinesByCategory($catagory) {
        $medicine = new MedicineModel();

        $medicines = $medicine->getMedicinesByCategory($catagory);
        require PAGES_DIR . "/medicine_search.php";
    }

    public function getMedicinesByHSX($hsx) {
        $medicine = new MedicineModel();

        $medicines = $medicine->getMedicinesByHSX($hsx);
        require PAGES_DIR . "/medicine_search.php";
    }

    public function getMedicinesByNCC($ncc) {
        $medicine = new MedicineModel();

        $medicines = $medicine->getMedicinesByNCC($ncc);
        require PAGES_DIR . "/medicine_search.php";
    }
}