<?php
header('Content-Type: application/json');
include __DIR__ . "/../../../../controllers/UserController.php";

// Lấy dữ liệu JSON từ request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = intval($data['id']);
    $userController = new UserController();

    $result = $userController->deleteUser($id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Xóa tài khoản thành công!'
        ]);
        // echo 'Xóa tài khoản thanh cong!';
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Không thể xóa tài khoản hoặc tài khoản không tồn tại.'
        ]);
        // echo 'Không thể xóa tài khoản hoặc tài khoản không tồn tại.';
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu ID người dùng.'
    ]);
}
?>