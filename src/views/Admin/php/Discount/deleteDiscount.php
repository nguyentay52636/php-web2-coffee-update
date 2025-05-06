<?php
header('Content-Type: application/json');
    include __DIR__."/../../../../controllers/DiscountController.php";
    $data = json_decode(file_get_contents("php://input"), true);
    $discountController = new DiscountController();

    if (isset($data['id'])) {
        $id = intval($data['id']);
        
    
        $result = $discountController->deleteDiscount($id);
    
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Xóa mã giảm giá thành công!'
            ]);
            
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xóa mã giảm hoặc mã giảm giá không tồn tại.'
            ]);
            
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu mã giảm giá.'
        ]);
    }


?>