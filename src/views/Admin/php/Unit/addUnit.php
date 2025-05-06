<?php
// Thiết lập header trả về JSON
include __DIR__ ."/../../../../controllers/UnitController.php";
header('Content-Type: application/json');

$unitController = new UnitController();


// Kiểm tra phương thức gửi form có phải POST không
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức gửi không hợp lệ.'
    ]);
    exit;
}

// Lấy dữ liệu từ POST và loại bỏ khoảng trắng thừa
$unitName = trim($_POST['unit_name'] ?? '');
$unitDescription = trim($_POST['unit_description'] ?? '');

// Kiểm tra dữ liệu bắt buộc
if (empty($unitName)) {
    echo json_encode([
        'success' => false,
        'message' => 'Tên đơn vị không được để trống.'
    ]);
    exit;
}


try {
    $unitController->createUnit($unitName, $unitDescription);

    echo json_encode([
        'success' => true,
        'message' => 'Thêm đơn vị thành công.'
    ]);
} catch (PDOException $e) {
    // Nếu có lỗi xảy ra khi thực hiện truy vấn
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()
    ]);
}