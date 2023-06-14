<?php

require 'Database.php';

$database = new Database();
$DVD = new \model\DVD();
// Get all products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $products = $database->getAllProducts();
    echo json_encode($products);
}

// Add a product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data) && $data['productType'] === 'DVD') {
        $result = $database->saveDVD($data);

        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to add product'));
        }
    } else if (!empty($data) && $data['productType'] === 'Book') {
        $result = $database->saveBook($data);

        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to add product'));
        }
    } else if (!empty($data) && $data['productType'] === 'Furniture') {
        $result = $database->saveFurniture($data);

        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to add product'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid product data'));
    }
}

// Delete products
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

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
}

