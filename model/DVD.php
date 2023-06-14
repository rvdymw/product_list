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

    public function save()
    {
        $database = new Database();
        $database->saveDVD($this->sku, $this->name, $this->price, $this->size);
    }
}