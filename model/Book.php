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

    public function save()
    {
        $database = new Database();
        $database->saveBook($this->sku, $this->name, $this->price, $this->weight);
    }
}