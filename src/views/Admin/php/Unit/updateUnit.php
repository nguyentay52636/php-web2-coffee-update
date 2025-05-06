<?php
// updateUnit.php

// Thiết lập header trả về JSON
include __DIR__ ."/../../../../controllers/UnitController.php";
header('Content-Type: application/json');

// Chỉ cho phép phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức gửi không hợp lệ.'
    ]);
    exit;
}

// Lấy dữ liệu từ POST và loại bỏ khoảng trắng
$unitId = trim($_POST['unit_id'] ?? '');
$unitName = trim($_POST['unit_name'] ?? '');
$unitDescription = trim($_POST['unit_description'] ?? '');

// Kiểm tra dữ liệu bắt buộc
if (empty($unitId)) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu thông tin ID đơn vị cần cập nhật.'
    ]);
    exit;
}

if (empty($unitName)) {
    echo json_encode([
        'success' => false,
        'message' => 'Tên đơn vị không được để trống.'
    ]);
    exit;
}



// Thực hiện câu lệnh UPDATE
try {
    $unitController = new UnitController();
    $unitUpdated = $unitController->updateUnit($unitId, $unitName, $unitDescription);

    if (!$unitUpdated) {
        echo json_encode([
            'success' => false,
            'message' => 'Cập nhật đơn vị khoong thành.'
        ]);
        exit;
    }
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật đơn vị thành công.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()
    ]);
}