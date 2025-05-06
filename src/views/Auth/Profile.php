<?php
session_start();
require_once __DIR__ . '/../config/head.php';
require_once __DIR__ . '/../../config/DatabaseConnection.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: ../Auth/LoginAndSignUp.php");
    exit;
}

$db = (new DatabaseConnection())->getConnection();

// Lấy thông tin user nếu đã tồn tại
$stmt = $db->prepare("SELECT * FROM USERS WHERE ACCOUNTID = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$fullname = $user['FULLNAME'] ?? '';
$address = $user['ADDRESS'] ?? '';
$phone = $user['PHONE'] ?? '';
$email = $user['EMAIL'] ?? '';
$dob = $user['DATEOFBIRTH'] ?? '';
$hasUserInfo = $user !== null;

$success = false; // Để xác định có hiển thị SweetAlert không

// Nếu form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];

    if ($hasUserInfo) {
        $stmt = $db->prepare("UPDATE USERS SET FULLNAME=?, ADDRESS=?, PHONE=?, EMAIL=?, DATEOFBIRTH=? WHERE ACCOUNTID=?");
        $stmt->bind_param("sssssi", $fullname, $address, $phone, $email, $dob, $userId);
    } else {
        $stmt = $db->prepare("INSERT INTO USERS (ACCOUNTID, FULLNAME, ADDRESS, PHONE, EMAIL, DATEOFBIRTH) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $userId, $fullname, $address, $phone, $email, $dob);
    }

    if ($stmt->execute()) {
        $success = true;
    } else {
        $message = "Cập nhật thất bại: " . $stmt->error;
    }
}
?>

<?php include '../layout/includes/Header.php'; ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100" style="margin-top: 200px;">
    <div class="w-100" style="max-width: 700px;">
        <h2 class="mb-4 text-center text-dark">Thông tin cá nhân</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-danger text-center text-dark"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4 shadow bg-light text-dark">
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label text-dark">Họ tên</label>
                    <input type="text" name="fullname" class="form-control text-dark"
                        value="<?= htmlspecialchars($fullname) ?>" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label text-dark">Địa chỉ</label>
                    <input type="text" name="address" class="form-control text-dark"
                        value="<?= htmlspecialchars($address) ?>" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label text-dark">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control text-dark"
                        value="<?= htmlspecialchars($phone) ?>" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label text-dark">Email</label>
                    <input type="email" name="email" class="form-control text-dark"
                        value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label text-dark">Ngày sinh</label>
                    <input type="date" name="dob" class="form-control text-dark" value="<?= htmlspecialchars($dob) ?>"
                        required>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
            </div>
        </form>
    </div>
</div>



<?php include '../layout/includes/Footer.php'; ?>
<?php if ($success): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: 'Thông tin đã được cập nhật.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../Pages/Home.php';
            }
        });
    </script>
<?php endif; ?>