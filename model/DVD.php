<?php

namespace model;

use Database;

class DVD extends Product
{
    private $size;

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function displayAdditionalInfo()
    {
        return 'Size: ' . $this->size . ' MB';
    }

    public function save($product)
    {
        $sku = $product['sku'];
        $name = $product['name'];
        $price = $product['price'];
        $type = $product['productType'];
        $size = $product['size'];

        return  "INSERT INTO products (sku, name, price, type, size) VALUES ('$sku', '$name', '$price', '$type', '$size')";
    }
}