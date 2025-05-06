<?php
session_start();
require_once __DIR__ . '/../config/head.php';
require_once __DIR__ . '/../../config/DatabaseConnection.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Bạn chưa đăng nhập",
                text: "Vui lòng đăng nhập để xem hóa đơn.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../Auth/LoginAndSignUp.php";
                }
            });
        </script>
    </body>
    </html>';
    exit;
}

$db = (new DatabaseConnection())->getConnection();

// Lấy danh sách đơn hàng
$sql = "SELECT * FROM ORDERS WHERE USERID = ? ORDER BY DATEOFORDER DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<?php include __DIR__ . '/../layout/includes/Header.php'; ?>

<div class="container mt-10" style="margin-top:200px;">
    <h3 class="mb-4 text-center">Lịch sử đơn hàng của bạn</h3>

    <?php if (empty($orders)): ?>
    <div class="alert alert-info text-center">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
    <?php foreach ($orders as $order):?>
    <div class="card mb-4 shadow-sm order-card">
        <div class="card-header bg-primary text-white">
            <strong>Đơn hàng #<?= $order['ID'] ?></strong> - <?= $order['DATEOFORDER'] ?> -
            <span
                class="badge bg-<?= $order['ORDERSTATUS'] === 'COMPLETED' ? 'success' : ($order['ORDERSTATUS'] === 'CANCELLED' ? 'danger' : 'warning') ?>">
                <?= $order['ORDERSTATUS'] ?>
            </span>
        </div>
        <div class="card-body">
            <?php
                $stmtDetails = $db->prepare("SELECT od.*, p.PRODUCTNAME, p.LINKIMAGE FROM ORDERDETAILS od JOIN PRODUCTS p ON od.PRODUCTID = p.ID WHERE od.ORDERID = ?");
                $stmtDetails->bind_param("i", $order['ID']);
                $stmtDetails->execute();
                $details = $stmtDetails->get_result()->fetch_all(MYSQLI_ASSOC);
            ?>
            <div class="order-details table-responsive">
                <table class="table table-bordered text-center align-middle">
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
                        <?php foreach ($details as $item): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars("http://localhost/Web_Advanced_Project/src/views/Admin/" . $item['LINKIMAGE']) ?>"
                                    style="width: 60px;" class="img-fluid rounded"></td>
                            <td><?= htmlspecialchars($item['PRODUCTNAME']) ?></td>
                            <td><?= number_format($item['PRICE'], 0, ',', '.') ?>₫</td>
                            <td><?= $item['QUANTITY'] ?></td>
                            <td><?= number_format($item['TOTAL'], 0, ',', '.') ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <p class="mb-1">Tổng trước giảm:
                    <strong><?= number_format($order['PRICEBEFOREDISCOUNT'], 0, ',', '.') ?>₫</strong>
                </p>
                <p class="mb-1">Đã giảm giá:
                    <strong><?= number_format($order['PRICEBEFOREDISCOUNT'] - $order['TOTAL'], 0, ',', '.') ?>₫</strong>
                </p>
                <p class="mb-0">Tổng thanh toán: <strong
                        class="text-primary"><?= number_format($order['TOTAL'], 0, ',', '.') ?>₫</strong></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const orders = document.querySelectorAll('.order-card');

    orders.forEach(order => {
        order.addEventListener('click', function() {
            const details = this.querySelector('.order-details');
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        });
    });
});
</script>
<style>
.order-details {
    display: none;
}
</style>


<?php include __DIR__ . '/../layout/includes/Footer.php'; ?>