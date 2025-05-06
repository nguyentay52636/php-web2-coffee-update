<?php
// Đảm bảo đúng namespace hoặc include autoload nếu cần
include_once __DIR__ ."/../../../../controllers/UnitController.php";

// Lấy dữ liệu JSON từ frontend
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu ID công thức."
    ]);
    exit;
}

$unitId = $data['id'];

$unitController = new UnitController();
$success = $unitController->deleteUnit($unitId);

if(!$success) {
    echo json_encode([
        "success" => false,
        "message" => "Không thể xóa công thức."
    ]);
    exit;
}


echo json_encode([
    "success" => $success,
    "message" => $success ? "Đã xóa công thức thành công." : "Không thể xóa công thức."
]);