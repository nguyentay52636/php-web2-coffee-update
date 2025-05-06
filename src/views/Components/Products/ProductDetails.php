<?php
session_start();
require_once(__DIR__ . '/../../../controllers/ProductController.php');
$controller = new ProductController();

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $controller->getProductById($productId);

if (!$product) {
    echo "<div class='text-center mt-5'>Không tìm thấy sản phẩm.</div>";
    return;
} else {
    $reviews = $controller->getReviewsByProductId($productId);
    $averageRating = $controller->getAverageRating($productId);
}

// Xử lý thêm sản phẩm vào giỏ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Bạn cần đăng nhập để thêm vào giỏ hàng'); window.location.href='/Web_Advanced_Project/src/views/Auth/LoginAndSignUp.php';</script>";
        exit;
    }

    $productId = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $userId = $_SESSION['user_id'];

    $controller->addToCart($productId, $quantity, $userId);
    echo "<script>
        alert('Đã thêm vào giỏ hàng!');
        history.go(-1);
    </script>";
}
?>
<!-- Bootstrap CSS v5.3.2 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .product-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 50px;
    }

    .product-image {
        max-width: 100%;
        height: auto;
    }

    .product-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .rating {
        color: #f1c40f;
    }

    .coffee-type-btn {
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 15px;
        margin-right: 10px;
        background-color: #fff;
        color: #333;
        transition: all 0.3s ease;
    }

    .coffee-type-btn.active,
    .coffee-type-btn:hover {
        background-color: #333;
        color: #fff;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: fit-content;
    }

    .quantity-selector button {
        border: none;
        background-color: #f5f5f5;
        padding: 5px 15px;
        font-size: 18px;
    }

    .quantity-selector input {
        width: 40px;
        text-align: center;
        border: none;
        background-color: #f5f5f5;
    }

    .tabs {
        display: flex;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
        font-weight: bold;
        color: #666;
    }

    .tab.active {
        color: #333;
        border-bottom: 2px solid #333;
    }

    .price {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .old-price {
        font-size: 18px;
        color: #999;
        text-decoration: line-through;
        margin-right: 10px;
    }

    .add-to-cart {
        background-color: #333;
        color: #fff;
        border-radius: 5px;
        padding: 10px 20px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #555;
    }

    .wishlist {
        border: 1px solid #ddd;
        border-radius: 50%;
        padding: 10px;
        font-size: 18px;
        color: #333;
    }

    .wishlist:hover {
        color: #e74c3c;
    }

    .shipping-info {
        color: #666;
        font-size: 14px;
    }
</style>
<?php
require_once __DIR__ . '/../../config/head.php';
include_once __DIR__ . '/../../layout/includes/Header.php';
?>
<div class="container product-container">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 text-center">
            <img src="<?= htmlspecialchars("http://localhost/Web_Advanced_Project/src/views/Admin/" . $product->getLinkImage()) ?>"
                alt="<?= htmlspecialchars($product->getProductName()) ?>" class="product-image">
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="product-title"><?= htmlspecialchars($product->getProductName()) ?></h1>

            <!-- Rating -->
            <div class="rating mb-3">
                <?php
                $fullStars = floor($averageRating);
                $halfStar = ($averageRating - $fullStars >= 0.5) ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;

                for ($i = 0; $i < $fullStars; $i++) echo '<i class="fas fa-star"></i>';
                if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                for ($i = 0; $i < $emptyStars; $i++) echo '<i class="far fa-star"></i>';
                ?>
                <span class="ms-2"><?= count($reviews) ?> Đánh giá</span>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <span class="old-price">$<?= number_format($product->getPrice() * 1.2, 2) ?></span>
                <span class="price">$<?= number_format($product->getPrice(), 2) ?></span>
            </div>

            <!-- Buttons -->
            <div class="mb-3">
                <form method="POST" action="">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <div class="mb-3">
                        <span class="fw-bold">Số lượng</span><br>
                        <div class="quantity-selector mt-2">
                            <button type="button" id="decreaseBtn">-</button>
                            <input type="text" name="quantity" value="1" id="quantityInput" readonly>
                            <button type="button" id="increaseBtn">+</button>
                        </div>
                    </div>
                    <button type="submit" name="add_to_cart" class="add-to-cart me-3">
                        <i class="fas fa-plus me-2"></i>Thêm vào giỏ hàng
                    </button>
                </form>
            </div>

            <!-- Shipping -->
            <div class="shipping-info">
                <i class="fas fa-truck me-2"></i> Giao hàng trong vòng 2 ngày
            </div>
        </div>
    </div>
</div>
<?php
include_once __DIR__ . '/../../layout/includes/Footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
<script>
    // Tab functionality
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    // Coffee type button functionality
    document.querySelectorAll('.coffee-type-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('active');
        });
    });

    // Quantity selector functionality
    const quantityInput = document.getElementById('quantityInput');
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');

    decreaseBtn.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value > 1) quantityInput.value = value - 1;
    });

    increaseBtn.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        quantityInput.value = value + 1;
    });
</script>