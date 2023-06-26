<?php

require 'model\Product.php';
require 'model\DVD.php';
require 'model\Book.php';
require 'model\Furniture.php';
require 'Database.php';

$database = new Database();

file_put_contents('post_request.log', print_r($_POST, true), FILE_APPEND);

// Get all products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $products = $database->getAllProducts();
    echo json_encode($products);
}

// Add or delete products
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data) && isset($data['action'])) {
        $action = $data['action'];

        if ($action === 'addProduct') {
            if (!empty($data) && isset($data['productType'])) {
                $productType = $data['productType'];
                $path = 'model\\'. $productType;

                if (class_exists($path)) {
                    $product = new $path();
                    $result = $database->saveProduct($product, $data);

                    if ($result) {
                        echo json_encode(array('success' => true, 'message' => 'Product added successfully'));
                    } else {
                        echo json_encode(array('success' => false, 'message' => 'Failed to add product'));
                    }
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Invalid product type: ' . $path));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Invalid product data'));
            }
        } elseif ($action === 'deleteProducts') {
            if (!empty($data) && isset($data['products'])) {
                $ids = $data['products'];
                $result = $database->deleteProducts($ids);

                if ($result) {
                    echo json_encode(array('success' => true));
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Failed to delete products'));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Invalid product data'));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Invalid action'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid request data'));
    }
}
