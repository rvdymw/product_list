<?php

namespace model;

use Database;

class Book extends Product
{
    private $weight;

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function displayAdditionalInfo()
    {
        return 'Weight: ' . $this->weight . ' Kg';
    }

    public function save($product)
    {
        $sku = $product['sku'];
        $name = $product['name'];
        $price = $product['price'];
        $type = $product['productType'];
        $weight = $product['weight'];

        return "INSERT INTO products (sku, name, price, type, weight) VALUES ('$sku', '$name', '$price', '$type', '$weight')";
    }
}