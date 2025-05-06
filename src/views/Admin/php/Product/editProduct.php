<?php
include __DIR__ . "/../../../../controllers/ProductController.php";

$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId     = $_POST['product_id'] ?? null;
    $productName   = $_POST['product_name'] ?? '';
    $recipeId      = $_POST['recipe'] ?? '';
    $unitId        = $_POST['unit'] ?? '';
    $finalPrice    = $_POST['final_price'] ?? '';
    $oldImagePath  = $_POST['old_image'] ?? ''; // Đường dẫn ảnh cũ

    // Validate dữ liệu bắt buộc
    if (!$productId || !$productName || !$recipeId || !$unitId || !$finalPrice || floatval($finalPrice) <= 0) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ và hợp lệ các thông tin.']);
        exit;
    }

    // Xử lý ảnh
    $imagePath = $oldImagePath; // Mặc định là ảnh cũ
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        try {
            $fileTmpPath  = $_FILES['product_image']['tmp_name'];
            $fileName     = $_FILES['product_image']['name'];
            $fileSize     = $_FILES['product_image']['size'];
            $fileType     = $_FILES['product_image']['type'];

            // Lấy phần mở rộng
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedfileExtensions = ['jpg', 'jpeg', 'png'];

            if (!in_array($fileExtension, $allowedfileExtensions)) {
                throw new Exception("Chỉ cho phép upload file .jpg, .jpeg, .png!");
            }

            // Tạo tên file an toàn từ tên sản phẩm
            $safeProductName = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($productName));
            $newFileName = uniqid($safeProductName . '_') . '.' . $fileExtension;

            // Đường dẫn lưu file
            $targetFolder = __DIR__ . '/../../assets/img/';
            if (!is_dir($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }

            $destPath = $targetFolder . $newFileName;

            // Di chuyển file
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                throw new Exception("Không thể lưu file được upload!");
            }

            // Gán đường dẫn tương đối để lưu vào DB
            $imagePath = 'assets/img/' . $newFileName;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi ảnh: ' . $e->getMessage()]);
            exit;
        }
    }

    // Cập nhật sản phẩm
    $result = $productController->updateProduct($recipeId, $productName, $finalPrice, $imagePath, $unitId, 1, $productId);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được cập nhật.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm.']);
    }
}
