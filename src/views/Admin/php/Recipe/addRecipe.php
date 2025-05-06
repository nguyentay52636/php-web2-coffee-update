<?php
// addRecipe.php
header('Content-Type: application/json');

// Include controllers
include __DIR__ . "/../../../../controllers/RecipeController.php";
include __DIR__ . "/../../../../controllers/RecipeDetailController.php";

// Lấy dữ liệu từ POST và trim để loại bỏ khoảng trắng thừa
$recipeName         = isset($_POST['recipe_name']) ? trim($_POST['recipe_name']) : '';
// $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
$ingredientNames    = $_POST['ingredient_name'] ?? [];
$ingredientQuantities = $_POST['ingredient_quantity'] ?? [];
$ingredientUnits    = $_POST['ingredient_unit'] ?? [];

// Kiểm tra dữ liệu nhập vào
if (
    empty($recipeName) ||
    empty($ingredientNames) ||
    count($ingredientNames) !== count($ingredientQuantities) ||
    count($ingredientNames) !== count($ingredientUnits)
) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ hoặc thiếu thông tin nguyên liệu'
    ]);
    exit;
}

// Tạo công thức mới qua RecipeController
$recipeController = new RecipeController();
$recipeId = $recipeController->createRecipe($recipeName);

if (!$recipeId) {
    echo json_encode([
        'success' => false,
        'message' => 'Không thể tạo công thức'
    ]);
    exit;
}

// Khởi tạo RecipeDetailController
$recipeDetailController = new RecipeDetailController();

// Duyệt qua mảng nguyên liệu và thêm vào bảng chi tiết công thức
$allInserted = true;
for ($i = 0; $i < count($ingredientNames); $i++) {
    // Lấy và chuẩn hóa dữ liệu cho từng nguyên liệu
    $ingName  = trim($ingredientNames[$i]);
    $quantity = floatval($ingredientQuantities[$i]);
    $unit     = trim($ingredientUnits[$i]);

    // Gọi hàm tạo dòng chi tiết công thức
    $result = $recipeDetailController->createRecipeDetail($recipeId, $ingName, $quantity, $unit);

    // Nếu có lỗi thì đánh dấu và thoát vòng lặp
    if (!$result) {
        $allInserted = false;
        break;
    }
}

if ($allInserted) {
    echo json_encode([
        'success' => true,
        'message' => 'Lưu công thức thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Không thể lưu đầy đủ chi tiết công thức'
    ]);
}
?>