<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/DatabaseConnection.php';
require_once __DIR__ . '/../../controllers/CartController.php';
require_once __DIR__ . '/../../controllers/CartDetailController.php';
require_once __DIR__ . '/../../controllers/UserController.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../views/Auth/CartProcessor.php';

$user_id = $_SESSION['user_id'] ?? null;
$productId = $_POST['productId'] ?? null;

// Kiểm tra nếu thiếu dữ liệu
if (!$user_id || !$productId) {
    echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
    exit;
}

try {
    // Tạo các đối tượng cần thiết
    $cartController = new CartController();
    $cartDetailController = new CartDetailController();
    $productController = new ProductController();
    $cartProcessor = new CartProcessor($cartController, $cartDetailController, $productController);

    // Xóa sản phẩm khỏi giỏ hàng
    $cartDetailController->removeItem($cartProcessor->getCart($user_id)->getId(), $productId);

    // Tính toán lại tổng giá trị giỏ hàng
    $totalPrice = $cartProcessor->calculateTotalPrice($user_id);

    // Trả về kết quả JSON hợp lệ

    if ($cartProcessor->getProductsInCart($user_id) == null) {
        echo json_encode([
            'success' => true,
            'totalPrice' => $totalPrice,
            'isEmpty' => true
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'totalPrice' => $totalPrice,
            'isEmpty' => false
        ]);
    }
} catch (Exception $e) {
    // Xử lý lỗi trong trường hợp có ngoại lệ
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
