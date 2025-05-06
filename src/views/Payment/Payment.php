<?php
session_start();
require_once __DIR__ . '/../../config/DatabaseConnection.php';
require_once __DIR__ . '/../../controllers/CartController.php';
require_once __DIR__ . '/../../controllers/CartDetailController.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '../../Auth/CartProcessor.php';
require_once __DIR__ . '/../config/head.php';

$userId = $_SESSION['user_id'];
$cartProcessor = new CartProcessor(new CartController(), new CartDetailController(), new ProductController());
$products = $cartProcessor->getProductsInCart($userId);
$totalBeforeDiscount = $cartProcessor->calculateTotalPrice($userId);
?>
<?php include_once __DIR__ . '/../layout/includes/Header.php'; ?>

<div class="container" style="margin-top: 200px">
    <h3 class="text-center mb-4">Xác nhận đơn hàng</h3>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $entry):
                    $item = $entry['product'];
                    $quantity = $entry['quantity'];
                    $subtotal = $item->getPrice() * $quantity;
                ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars("http://localhost/Web_Advanced_Project/src/views/Admin/" . $item->getLinkImage()) ?>"
                                alt="<?= htmlspecialchars($item->getProductName()) ?>" style="width: 60px;"
                                class="img-fluid rounded">
                        </td>
                        <td><?= htmlspecialchars($item->getProductName()) ?></td>
                        <td><?= number_format($item->getPrice(), 0, ',', '.') ?>₫</td>
                        <td><?= $quantity ?></td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-4">
        <!-- Hộp chứa 2 phần, sử dụng flex để hiển thị ngang -->
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <!-- Discount Section -->
            <div style="flex: 1; min-width: 300px;">
                <div class="card h-100 p-4 shadow-sm">
                    <h5 class="mb-3">Áp dụng mã giảm giá</h5>
                    <div class="mb-3">
                        <label for="discountCode" class="form-label">Mã giảm giá</label>
                        <input type="text" id="discountCode" class="form-control" placeholder="Nhập mã...">
                    </div>
                    <button class="btn btn-success w-100" id="applyDiscount">Áp dụng</button>
                    <div id="discountMessage" class="text-danger mt-2"></div>
                </div>
            </div>

            <!-- Total Summary -->
            <div style="flex: 1; min-width: 300px;">
                <div class="card h-100 p-4 shadow-sm bg-light d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="mb-3 text-dark">Tóm tắt đơn hàng</h5>
                        <p class="mb-1 text-dark">Tổng trước giảm:
                            <strong class="text-dark"
                                id="totalBefore"><?= number_format($totalBeforeDiscount, 0, ',', '.') ?>₫</strong>
                        </p>
                        <p class="mb-1 text-dark">Phần trăm giảm:
                            <strong class="text-dark" id="discountPercent">0%</strong>
                        </p>
                        <p class="mb-3 text-dark">Tổng thanh toán:
                            <strong class="text-dark"
                                id="totalFinal"><?= number_format($totalBeforeDiscount, 0, ',', '.') ?>₫</strong>
                        </p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" id="confirmOrder">Xác nhận thanh toán</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../layout/includes/Footer.php'; ?>

<script>
    let totalBefore = <?= $totalBeforeDiscount ?>;
    let appliedDiscountId = null;
    let discountPercent = 0;

    document.getElementById('applyDiscount').addEventListener('click', function() {
        const code = document.getElementById('discountCode').value;

        fetch('http://localhost/Web_Advanced_Project/src/views/Payment/applyDiscount.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'code=' + encodeURIComponent(code)
            })
            .then(res => res.json())
            .then(data => {
                const messageDiv = document.getElementById('discountMessage');
                if (data.success) {
                    discountPercent = data.discountPercent;
                    appliedDiscountId = data.discountId;

                    const discountAmount = totalBefore * discountPercent / 100;
                    const totalAfter = totalBefore - discountAmount;

                    document.getElementById('discountPercent').innerText = discountPercent + '%';
                    document.getElementById('totalFinal').innerText = new Intl.NumberFormat('vi-VN').format(
                        totalAfter) + '₫';
                    messageDiv.innerText = '';
                } else {
                    messageDiv.innerText = data.message || 'Mã giảm giá không hợp lệ.';
                }
            })
            .catch(error => {
                console.error("Lỗi áp mã:", error);
                document.getElementById('discountMessage').innerText = 'Đã xảy ra lỗi.';
            });
    });

    document.getElementById('confirmOrder').addEventListener('click', function() {
        fetch('http://localhost/Web_Advanced_Project/src/views/Payment/createOrder.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `discountPercent=${discountPercent}&discountId=${appliedDiscountId ?? 0}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Đặt hàng thành công!');
                    window.location.href = '../Pages/Home.php';
                } else {
                    alert('Đặt hàng thất bại: ' + (data.message || 'Đã có lỗi xảy ra.'));
                }
            })
            .catch(error => {
                console.error("Lỗi đặt hàng:", error);
                alert('Lỗi không xác định.');
            });
    });
</script>