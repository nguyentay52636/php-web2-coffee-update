<?php
// Include controller cần thiết (đảm bảo đường dẫn chính xác theo cấu trúc dự án của bạn)
include __DIR__ . "/../../../../controllers/ProductController.php";

// Thiết lập header trả về JSON
header('Content-Type: application/json; charset=utf-8');

$response = [
    'success' => false,
    'message' => '',
];

try {
    // Lấy dữ liệu từ POST
    $productName = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $recipe      = isset($_POST['recipe'])       ? trim($_POST['recipe'])       : '';
    $unit        = isset($_POST['unit'])         ? trim($_POST['unit'])         : '';
    $finalPrice  = isset($_POST['final_price'])  ? trim($_POST['final_price'])  : '';

    // Validate các trường cơ bản (bạn có thể bổ sung các điều kiện khác nếu cần)
    if (empty($productName) || empty($recipe) || empty($unit) || empty($finalPrice)) {
        throw new Exception("Các trường không được để trống!");
    }
    if (!is_numeric($finalPrice) || floatval($finalPrice) <= 0) {
        throw new Exception("Final Price không hợp lệ!");
    }

    // --- Xử lý upload file ảnh ---
    // Đặt đường dẫn tới thư mục lưu ảnh (lưu ý: đây là đường dẫn vật lý trên server)
    $targetFolder = __DIR__ . '/../../public/images/'; // Thay đổi nếu cần
    if (!file_exists($targetFolder)) {
        if (!mkdir($targetFolder, 0777, true)) {
            throw new Exception("Không thể tạo thư mục: " . $targetFolder);
        }
    }

    $uploadedFileName = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath  = $_FILES['product_image']['tmp_name'];
        $fileName     = $_FILES['product_image']['name'];
        $fileSize     = $_FILES['product_image']['size'];
        $fileType     = $_FILES['product_image']['type'];

        // Lấy phần mở rộng (extension)
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Các định dạng ảnh cho phép
        $allowedfileExtensions = ['jpg', 'jpeg', 'png'];
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            throw new Exception("Chỉ cho phép upload file .jpg, .jpeg, .png!");
        }

        // Tạo tên file an toàn và duy nhất dựa vào tên sản phẩm
        $safeProductName = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($productName));
        $newFileName = uniqid($safeProductName . '_') . '.' . $fileExtension;

        // Đường dẫn đích để lưu file
        $destPath = $targetFolder . $newFileName;

        // Debug: ghi log đường dẫn (có thể dùng error_log để kiểm tra)
        error_log("File tạm: $fileTmpPath");
        error_log("Đường dẫn đích: $destPath");

        // Di chuyển file từ thư mục tạm vào thư mục đích
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            throw new Exception("Không thể lưu file được upload!");
        }

        // Lưu tên file (hoặc đường dẫn tương đối dùng để hiển thị ảnh) để lưu vào DB
        $uploadedFileName = 'public/images/' . $newFileName;
    }

    // --- Lưu sản phẩm vào Database ---
    // Giả sử ProductController có phương thức createProduct($name, $recipe, $price, $image, $unit)
    $productController = new ProductController();
    $product = $productController->createProduct($productName, $recipe, $finalPrice, $uploadedFileName, $unit,1);

    if (!$product) {
        $response['success'] = false;
        $response['message'] = 'Không thành công khi lưu sản phẩm vào DB!';
    } else {
        $response['success'] = true;
        $response['message'] = 'Thêm sản phẩm thành công!';
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Xuất dữ liệu JSON cho client
echo json_encode($response);
exit;