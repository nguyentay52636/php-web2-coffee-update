<?php
session_start();
header('Content-Type: application/json');
// Định nghĩa BASE_PATH là thư mục gốc của dự án (đi lên 3 cấp từ applyDiscount.php)
define('BASE_PATH', dirname(__DIR__, 3));

// Kết nối database
require_once(__DIR__ . '/../../config/DatabaseConnection.php');

// Import các controller và processor
require_once(__DIR__ . '/../../controllers/CartController.php');
require_once(__DIR__ . '/../../controllers/CartDetailController.php');
require_once(__DIR__ . '/../../controllers/ProductController.php');
require_once(__DIR__ . '/../../views/Auth/CartProcessor.php'); 

if (!isset($_POST['code'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Bạn chưa nhập tên mã giảm giá.'
    ]);
    exit;
}

$discountName = trim($_POST['code']);
$db = new DatabaseConnection();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM DISCOUNTS WHERE DISCOUNTNAME = ? LIMIT 1");
$stmt->bind_param("s", $discountName);
$stmt->execute();
$result = $stmt->get_result();
$discount = $result->fetch_assoc();

if (!$discount) {
    echo json_encode([
        'success' => false,
        'message' => 'Không tìm thấy mã giảm giá.'
    ]);
    exit;
}

// Kiểm tra ngày hợp lệ
$today = date('Y-m-d');
if ($today < $discount['STARTDATE'] || $today > $discount['ENDDATE']) {
    echo json_encode([
        'success' => false,
        'message' => 'Mã giảm giá đã hết hạn hoặc chưa được áp dụng.'
    ]);
    exit;
}

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode([
        'success' => false,
        'message' => 'Chưa đăng nhập.'
    ]);
    exit;
}

$cartProcessor = new CartProcessor(new CartController(), new CartDetailController(), new ProductController());
$total = $cartProcessor->calculateTotalPrice($userId);

if ($total < $discount['REQUIREMENT']) {
    echo json_encode([
        'success' => false,
        'message' => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã.'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'discountPercent' => $discount['DISCOUNTPERCENT'],
    'discountId' => $discount['ID']
]);