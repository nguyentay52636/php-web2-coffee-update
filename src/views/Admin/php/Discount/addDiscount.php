<?php
// update_discount.php
header('Content-Type: application/json'); // Đảm bảo trả về JSON
include __DIR__ . "/../../../../controllers/DiscountController.php";

// Lấy dữ liệu từ form
$voucherName    = isset($_POST['voucherName']) ? trim($_POST['voucherName']) : '';
$percent        = isset($_POST['percent']) ? trim($_POST['percent']) : '';
$requiredAmount = isset($_POST['requiredAmount']) ? trim($_POST['requiredAmount']) : '';
$startTime      = isset($_POST['startTime']) ? trim($_POST['startTime']) : '';
$endTime        = isset($_POST['endTime']) ? trim($_POST['endTime']) : '';

// Kiểm tra ID của discount (nếu có)
$discountId = isset($_POST['discountId']) ? trim($_POST['discountId']) : 1;

if (!$discountId) {
    echo json_encode(['success' => false, 'message' => 'Thiếu ID mã giảm giá']);
    exit;
}

// Kiểm tra dữ liệu hợp lệ
if ($voucherName !== '' && $percent !== '' && $requiredAmount !== '' && $startTime !== '' && $endTime !== '') {
    // Chuyển đổi định dạng ngày (nếu cần)
    $startTimeFormatted = date('Y-m-d', strtotime($startTime));
    $endTimeFormatted = date('Y-m-d', strtotime($endTime));

    // Tạo đối tượng discount và set dữ liệu
    $discount = new Discount();
    $discount->setId($discountId);
    $discount->setDiscountName($voucherName);
    $discount->setDiscountPercent($percent);
    $discount->setRequirement($requiredAmount);
    $discount->setStartDate($startTimeFormatted);
    $discount->setEndDate($endTimeFormatted);

    $discountController = new DiscountController();
    $result = $discountController->createDiscount($discount); // Đổi từ `createDiscount` -> `updateDiscount`
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Thêm thành công']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Thêm thất bại']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
}