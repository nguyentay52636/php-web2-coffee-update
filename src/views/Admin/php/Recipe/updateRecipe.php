<?php
include __DIR__ . "/../../../../controllers/RecipeController.php";
include __DIR__ . "/../../../../controllers/RecipeDetailController.php";

// Khởi tạo controller
$recipeController = new RecipeController();
$recipeDetailController = new RecipeDetailController();

// Lấy dữ liệu từ form
$recipeId = $_POST['recipe_id'] ?? null;
$recipeName = $_POST['recipe_name'] ?? null;
$ingredientIds = $_POST['ingredient_name'] ?? [];
$quantities = $_POST['ingredient_quantity'] ?? [];
$unitIds = $_POST['ingredient_unit'] ?? [];

$response = [];

if (!$recipeId || !$recipeName) {
    $response = [
        'success' => false,
        'message' => 'Thiếu thông tin công thức.'
    ];
    echo json_encode($response);
    exit;
}

// 1. Cập nhật tên công thức
$updateSuccess = $recipeController->updateRecipe($recipeId, $recipeName); // bạn cần tạo hàm này trong RecipeController

// 2. Xóa toàn bộ nguyên liệu cũ của công thức
$recipeDetailController->deleteRecipeDetail($recipeId); // bạn cần có hàm này trong RecipeDetailController

// 3. Lưu lại các nguyên liệu mới
$allInserted = true;
for ($i = 0; $i < count($ingredientIds); $i++) {
    // Lấy và chuẩn hóa dữ liệu cho từng nguyên liệu
    $ingName  = trim($ingredientIds[$i]);
    $quantity = floatval($quantities[$i]);
    $unit     = trim($unitIds[$i]);

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