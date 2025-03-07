<?php

namespace App\Controllers;

use App\Models\Bill;
use DateTime;

class StatisticalController
{

    public function index()
    {
        // echo $revenue;
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
        $result = $bill->getRevenue(startDate: $startDate, endDate: $endDate);
        print_r($result);
        $medicineResult = $bill->getMedicalRevenue(startDate: $startDate, endDate: $endDate);
        print_r($medicineResult);  
        $customerResult = $bill->getCustomerRevenue(startDate: $startDate, endDate: $endDate);
        print_r($customerResult);   
        $this->index();
    }

    public function revenueByDay()
    {
        $dateRequest = $_GET['day'];
        global $PDO;
        $bill = new Bill($PDO);
        $result = $bill->getRevenue(date: $dateRequest);
        print_r($result) . "<br>";

        //Thuoc ban chay

        $medicineResult = $bill->getMedicalRevenue(date: $dateRequest);
        print_r($medicineResult);

        $customerResult = $bill->getCustomerRevenue(date: $dateRequest);
        print_r($customerResult);
        $this->index();
    }


    public function revenueByMonth()
    {
        $monthRequest = $_GET['month'];
        $year = substr($monthRequest, 0, 4);
        $month = substr($monthRequest, 6);
        global $PDO;
        $bill = new Bill($PDO);
        $result = $bill->getRevenue(month: $month,year: $year);
        print_r($result) . "<br>";
        $medicineResult = $bill->getMedicalRevenue(month: $month, year: $year);
        print_r($medicineResult);
        $customerResult = $bill->getCustomerRevenue(month: $month, year: $year);
        print_r($customerResult);
        $this->index();
    }
}
