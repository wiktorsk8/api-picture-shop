<?php

namespace App\DTO;

class OrderDTO{

    public function __construct(
        private readonly int $product_id,
        private readonly int $customer_id,
        private readonly string $city,
        private readonly string $postal_code,
        private readonly string $street_name,
        private readonly int $street_number,
        private readonly ?int $flat_number,
    ){}

    public function getProductId(){
        return $this->product_id;
    }

    public function getCustomerId(){
        return $this->customer_id;
    }

    public function getCity(){
        return $this->city;
    }

    public function getPostalCode(){
        return $this->postal_code;
    }

    public function getStreetName(){
        return $this->street_name;
    }

    public function getStreetNumber(){
        return $this->street_number;
    }

    public function getFlatNumber(){
        return $this->flat_number;
    }



}
