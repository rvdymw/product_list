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

    public function saveProduct($product,array $data)
    {
        $type = new $product;
        $this->sanitize($data);

        if ($this->ifProductExist($data['sku'])) {
            $sql = $type->save($data);
            return $this->executeQuery($sql);
        } else {
            return false;
        }
    }

    public function deleteProducts($ids) {
        $idsList = implode("', '", $ids);
        $sql = "DELETE FROM products WHERE id IN ('$idsList')";

        if ($this->connection->query($sql) === true) {
            return true;
        } else {
            return false;
        }
    }

    private function ifProductExist($sku) {
        $sql = "SELECT COUNT(*) as count FROM products WHERE sku = '$sku'";
        $result = $this->connection->query($sql);

        if ($result) {
            $count = $result->fetch_assoc()['count'];

            if ($count > 0 ) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
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
        foreach ($data as $row) {
            return $this->connection->real_escape_string($row);
        }
    }

    public function __destruct() {
        $this->connection->close();
    }
}

