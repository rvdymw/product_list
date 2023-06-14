<?php

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'product_management';
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die('Database connection failed: ' . $this->connection->connect_error);
        }
    }

    public function getAllProducts() {
        $sql = 'SELECT * FROM products';
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $products = array();

            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            return array("product" => $products); // Return an associative array with the key "product"
        } else {
            return array("product" => array()); // Return an empty array under the "product" key
        }
    }

    public function deleteProducts($ids) {
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));

        $sql = "DELETE FROM products WHERE id IN ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        if ($stmt) {
            $stmt->execute($ids);
            return true;
        } else {
            return false;
        }
    }

    public function saveDVD($product)
    {
        $sku = $this->sanitize($product['sku']);
        $name = $this->sanitize($product['name']);
        $price = $this->sanitize($product['price']);
        $type = $this->sanitize($product['productType']);
        $size = $this->sanitize($product['size']);

        $sql = "INSERT INTO products (sku, name, price, type, size) VALUES ('$sku', '$name', '$price', '$type', '$size')";
        return $this->executeQuery($sql);
    }

    public function saveBook($product)
    {
        $sku = $this->sanitize($product['sku']);
        $name = $this->sanitize($product['name']);
        $price = $this->sanitize($product['price']);
        $type = $this->sanitize($product['productType']);
        $weight = $this->sanitize($product['weight']);

        $sql = "INSERT INTO products (sku, name, price, type, weight) VALUES ('$sku', '$name', '$price', '$type', '$weight')";
        return $this->executeQuery($sql);
    }

    public function saveFurniture($product)
    {
        $sku = $this->sanitize($product['sku']);
        $name = $this->sanitize($product['name']);
        $price = $this->sanitize($product['price']);
        $type = $this->sanitize($product['productType']);
        $height = $this->sanitize($product['height']);
        $width = $this->sanitize($product['width']);
        $length = $this->sanitize($product['length']);

        $sql = "INSERT INTO products (sku, name, price, type, height, width, length) 
                VALUES ('$sku', '$name', '$price', '$type', '$height', '$width', '$length')";
        return $this->executeQuery($sql);
    }

    private function executeQuery($sql)
    {
        if ($this->connection->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
            return false;
        }
    }

    private function sanitize($data) {
        return $this->connection->real_escape_string($data);
    }

    public function __destruct() {
        $this->connection->close();
    }
}

