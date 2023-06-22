<?php

namespace model;

use Database;

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function displayAdditionalInfo()
    {
        return 'Dimensions: ' . $this->height . 'x' . $this->width . 'x' . $this->length;
    }

    public function save($product)
    {
        $sku = $product['sku'];
        $name = $product['name'];
        $price = $product['price'];
        $type = $product['productType'];
        $height = $product['height'];
        $width = $product['width'];
        $length = $product['length'];

        return  "INSERT INTO products (sku, name, price, type, height, width, length) 
                VALUES ('$sku', '$name', '$price', '$type', '$height', '$width', '$length')";
    }
}