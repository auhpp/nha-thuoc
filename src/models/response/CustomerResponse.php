<?php

namespace App\Models\Response;

class CustomerResponse
{
    private string $customerId;
    private string $customerName;
    private string $phoneNumber;
    private int $amount;
    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }
}
