<?php
session_start();
require_once(__DIR__ . '/../../../controllers/ProductController.php');

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'not_logged_in']);
    exit;
}

// Lấy dữ liệu từ fetch
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['productId'])) {
    echo json_encode(['status' => 'invalid_data']);
    exit;
}

$productId = (int)$data['productId'];
$userId = $_SESSION['user_id'];
$quantity = 1;

$controller = new ProductController();
$controller->addToCart($productId, $quantity, $userId);

echo json_encode(['status' => 'success']);