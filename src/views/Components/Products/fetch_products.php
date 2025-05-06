<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . '/Web_Advanced/src/config/DatabaseConnection.php');
// require_once($_SERVER['DOCUMENT_ROOT'] . '/Web_Advanced/src/models/Product.php');
// require_once($_SERVER['DOCUMENT_ROOT'] . '/Web_Advanced/src/controllers/ProductController.php');

require_once __DIR__. "/../../../config/DatabaseConnection.php";
require_once __DIR__. "/../../../models/Product.php";
require_once __DIR__. "/../../../controllers/ProductController.php";


header('Content-Type: application/json');

$limit = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Lấy tham số tìm kiếm và category nếu có
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryId = isset($_GET['category']) ? trim($_GET['category']) : '';

// Khởi tạo controller
$controller = new ProductController();
// Lấy danh sách danh mục
$categories = $controller->getAllCategories();

// Lấy danh sách sản phẩm theo trang, có tìm kiếm và lọc
$products = $controller->getPaginatedProducts($offset, $limit, $search, $categoryId);
$totalPages = $controller->getTotalPages($limit, $search, $categoryId);

// Chuẩn bị dữ liệu JSON
$response = [
    'products' => [],
    'totalPages' => $totalPages,
    'currentPage' => $page
];

// Format dữ liệu sản phẩm
foreach ($products as $product) {
    $response['products'][] = [
        'id' => $product->getId(),
        'recipeId' => $product->getRecipeId(),
        'productName' => $product->getProductName(),
        'price' => $product->getPrice(),
        'linkImage' => $product->getLinkImage(),
        'unitId' => $product->getUnitId(),
        'categoryId' => $product->getCategoryId()
    ];
}

echo json_encode($response);
exit;