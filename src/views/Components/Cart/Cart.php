<?php
session_start();
require_once __DIR__ . '/../../../config/DatabaseConnection.php';
require_once __DIR__ . '/../../../controllers/CartController.php';
require_once __DIR__ . '/../../../controllers/CartDetailController.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once __DIR__ . '../../../Auth/CartProcessor.php';
require_once __DIR__ . '/../../config/head.php';

$userId = $_SESSION['user_id'];
$cartController = new CartController();
$cartDetailController = new CartDetailController();
$productController = new ProductController();
$cartProcessor = new CartProcessor($cartController, $cartDetailController, $productController);
$cart = $cartProcessor->getCart($userId);
$products = $cartProcessor->getProductsInCart($userId);
$totalPrice = $cartProcessor->calculateTotalPrice($userId);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<style>
    /* Additional Customization */
    .cart-container {
        margin-top: 50px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .product-image {
        max-width: 100px;
        border-radius: 5px;
    }

    .btn-continue-shopping {
        border-radius: 20px;
        font-size: 14px;
        background-color: rgb(133, 132, 129);
        color: black;
    }

    .btn-continue-shopping:hover {
        background-color: #353534;
        color: white;
        text-decoration: none;
    }

    .btn-payment {
        border-radius: 20px;
        font-size: 14px;
        background-color: rgb(231, 179, 68);
        color: black;
    }

    .btn-payment:hover {
        background-color: #b88b6f;
        color: #fff;
        text-decoration: none;
    }

    .price-text {
        font-size: 16px;
    }

    .total-price-text {
        font-size: 20px;
        font-weight: bold;
        color: rgb(231, 179, 68);
    }

    .table-bordered tbody tr td {
        border: none;
    }

    .col-quantity {
        width: 10%;
        /* Đặt cột số lượng ngắn lại */
    }

    .col-price {
        width: 20%;
        /* Đặt cột đơn giá dài hơn */
    }

    .quantity-box {
        border: 1px solid #ddd;
        /* Viền nhẹ */
        border-radius: 15px;
        /* Bo tròn góc */
        padding: 5px 10px;
        /* Khoảng cách bên trong */
        text-align: center;
        /* Căn giữa nội dung */
        width: 100%;
        background-color: #ffffff;
        /* Nền nhẹ */
    }
</style>
<?php include_once __DIR__ . '/../../layout/includes/Header.php'; ?>
<div class="container cart-container">
    <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>Hình ảnh</th>
                <th>Thông tin sản phẩm</th>
                <th class="col-price">Đơn giá</th>
                <th class="col-quantity">Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if ($products != null) {
                foreach ($products as $entry):
                    $item = $entry['product'];
                    $total = $entry['quantity'] * $item->getPrice();
            ?>
                    <tr class="text-center" id="item-<?= $item->getId(); ?>">
                        <td>
                            <img src="<?= htmlspecialchars('http://localhost/Web_Advanced_Project/src/views/Admin/' . $item->getLinkImage()); ?>"
                                alt="<?= htmlspecialchars($item->getProductName()); ?>" class="product-image">
                        </td>
                        <td>
                            <div>
                                <span class="cart-product-name"><?= htmlspecialchars($item->getProductName()); ?></span>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-delete-item" data-product-id="<?= $item->getId(); ?>">Xóa</button>
                            </div>
                        </td>
                        <td class="price-text"><?= number_format($item->getPrice(), 1, ',', '.'); ?>₫</td>
                        <td>
                            <div class="cart-quantity-box">
                                <?= $entry['quantity']; ?>
                            </div>
                        </td>
                        <td class="price-text"><?= number_format($total, 1, ',', '.'); ?>₫</td>
                    </tr>
                <?php endforeach;
            } else {
                ?>
                <tr>
                    <td colspan="5" class="text-center " style="height: 100px;">
                        Chưa có sản phẩm nào trong giỏ hàng
                    </td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button class="btn btn-primary btn-continue-shopping">Tiếp tục mua hàng</button>
        <div class="d-flex align-items-center">
            <span class="me-2 cart-product-name">Tổng tiền thanh toán:</span>
            <span class="total-price-text me-3" id="totalPrice"><?= number_format($totalPrice, 1, ',', '.'); ?>₫</span>
            <button class="btn btn-payment">Tiến hành thanh toán</button>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../../layout/includes/Footer.php'; ?>
<script>
    // Tiếp tục mua hàng
    document.querySelector('.btn-continue-shopping').addEventListener('click', function() {
        window.location.href = '../Pages/home.php';
    });

    // Tiến hành thanh toán
    document.querySelector('.btn-payment').addEventListener('click', function() {
        window.location.href = '/Web_Advanced_Project/src/views/Payment/Payment.php';
    });

    // Xóa sản phẩm khỏi giỏ
    document.querySelectorAll('.btn-delete-item').forEach(function(button) {
        button.addEventListener('click', function() {
            const itemRow = this.closest('tr');
            const productId = this.getAttribute('data-product-id');
            fetch('http://localhost/Web_Advanced_Project/src/views/api/deleteCartDetail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `productId=${productId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (itemRow) itemRow.remove();
                        if (data.isEmpty) {
                            const emptyRow = document.createElement('tr');
                            emptyRow.innerHTML =
                                `<td colspan="5" class="text-center" style="height: 100px;">Chưa có sản phẩm nào trong giỏ hàng</td>`;
                            document.querySelector('.cart-container table tbody').appendChild(emptyRow);
                        }
                        updateCartQuantityInHeader();

                        // ✅ Cập nhật lại tổng tiền nếu có
                        document.querySelector('#totalPrice').innerText = `${data.totalPrice}₫`;
                    }
                });
        });
    });
</script>