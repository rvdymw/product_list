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

    public function save()
    {
        $database = new Database();
        $database->saveFurniture($this->sku, $this->name, $this->price, $this->height, $this->width, $this->length);
    }
}