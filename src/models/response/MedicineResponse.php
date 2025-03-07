<?php

namespace App\Models\Response;

class MedicineResponse
{

    private string $medicineName;
    private int $sold;
    private string $unit;
    private string $amount;
    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }
}
