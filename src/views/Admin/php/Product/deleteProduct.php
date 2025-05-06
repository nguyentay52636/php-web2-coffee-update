<?php
header('Content-Type: application/json');
    include __DIR__."/../../../../controllers/ProductController.php";
    $data = json_decode(file_get_contents("php://input"), true);
    $productController = new ProductController();

    if (isset($data['id'])) {
        $id = intval($data['id']);
        
        $result = $productController->deleteProduct($id);
    
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Xóa san phẩm thành công!'
            ]);
            // echo 'Xóa tài khoản thanh cong!';
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể xóa san phẩm hoặc san phẩm không tồn tại.'
            ]);
            // echo 'Không thể xóa tài khoản hoặc tài khoản không tồn tại.';
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu mã san phẩm.'
        ]);
    }


?>