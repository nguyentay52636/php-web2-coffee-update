<?php
// update_discount.php
include __DIR__ . "/../../../../controllers/DiscountController.php";

// Lấy dữ liệu từ form
$discountId     = $_POST['discountId'] ;
$voucherName    = isset($_POST['voucherName']) ? trim($_POST['voucherName']) : '';
$percent        = isset($_POST['percent']) ? trim($_POST['percent']) : '';
$requiredAmount = isset($_POST['requiredAmount']) ? trim($_POST['requiredAmount']) : '';
$startTime      = isset($_POST['startTime']) ? trim($_POST['startTime']) : '';
$endTime        = isset($_POST['endTime']) ? trim($_POST['endTime']) : '';

// Kiểm tra dữ liệu hợp lệ (bạn có thể bổ sung thêm validate)
if(  $voucherName !== '' && $percent !== '' && $requiredAmount !== '' && $startTime !== '' && $endTime !== '') {
    // Chuyển đổi định dạng ngày (nếu cần)
    $startTimeFormatted = date('Y-m-d', strtotime($startTime));
    $endTimeFormatted = date('Y-m-d', strtotime($endTime));

    $discountController = new DiscountController();
    
    $result = $discountController->updateDiscount($voucherName ,$percent,$requiredAmount,$startTime,$endTime,$discountId);

    if($result){
        echo json_encode(['success' => true, 'message' => 'Cập nhật thành côngggg','id'=>$discountId,'voucherName'=>$voucherName,'percent'=>$percent,'requiredAmount'=>$requiredAmount,'startTime'=>$startTime,'endTime'=>$endTime]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
}
?>