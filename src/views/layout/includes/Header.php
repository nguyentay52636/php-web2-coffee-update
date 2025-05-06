<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: ../../../../src/views/Auth/LoginAndSignUp.php?logout=success");
    exit();
}
?>
<header class="z-index-100">
    <div class="container-header">
        <div class="header-top">
            <div class="header-left">
                <span>Chào mừng bạn đến với Coffee SGU</span>
                <div class="social-icons">
                    <a href="https://github.com/" class="social"><i class="fab fa-github"></i></a>
                    <a href="https://www.facebook.com/" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/" class="social"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <div class="header-right">
                <?php if (isset($_SESSION['user'])): ?>
                <!-- Khi đăng nhập thành công -->
                <div class="my-2 mx-2 d-flex justify-content-center align-items-center position-relative">
                    <div class="mx-2">
                        <span class="title-login">Xin chào
                            <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                    </div>
                    <div class="dropdown">
                        <div class="dropdown-toggle border-spacing-2 " data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://static-00.iconduck.com/assets.00/user-icon-1024x1024-dtzturco.png"
                                class="rounded-5" alt="Avatar" width="45px" height="45px">
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="../../../../Web_Advanced_Project/src/views/Auth/Profile.php">Xem
                                    thông tin cá
                                    nhân</a></li>
                            <li><a class="dropdown-item"
                                    href="../../../../Web_Advanced_Project/src/views/Auth/logout.php">Đăng
                                    xuất</a></li>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                <!-- Khi chưa đăng nhập -->
                <div class="my-2 mx-2 d-flex justify-content-center">
                    <a href="../../../../Web_Advanced_Project/src/views/Auth/LoginAndSignUp.php">
                        <span class="title-login">Đăng nhập</span>
                        <button class="btn btn-login my-2 my-sm-0 mx-2" type="button">
                            <i class="fa-solid fa-user"></i>
                        </button>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg  bg-dark position-relative rounded rounded-pill p-2">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex  justify-content-around" id="navbarSupportedContent">
                    <div class="list-item-left">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
                            <li class="nav-item">
                                <a class="nav-link active text-white"
                                    href="/Web_Advanced_Project/src/views/Pages/Home.php">Trang
                                    chủ</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link" href="/Web_Advanced_Project/src/views/Pages/Home.php#san-pham">Sản
                                    phẩm</a>
                            </li>

                        </ul>
                    </div>
                    <div id="trang-chu" class="logo d-flex justify-content-center align-items-center mx-3">
                        <img src="https://spencil.vn/wp-content/uploads/2024/06/mau-thiet-ke-logo-thuong-hieu-cafe-SPencil-Agency-5.webp"
                            alt="Logo" style="height: 70px; width: auto; object-fit: contain; border-radius: 50%;">
                    </div>
                    <div class=" list-item-right">
                        <ul class="navbar-nav  mb-2 mb-lg-0 ml-2">
                            <li class="nav-item">
                                <a class="nav-link" href="/Web_Advanced_Project/src/views/Pages/Home.php#danh-gia"
                                    aria-disabled="true">Đánh giá</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/Web_Advanced_Project/src/views/Pages/Home.php#lien-he"
                                    aria-disabled="true">Liên hệ</a>
                            </li>

                        </ul>
                    </div>
                    <div class="search-cart d-flex justify-content-center align-items-center">
                        <a href="/Web_Advanced_Project/src/views/Payment/Orders.php" class="btn-search me-2"><i
                                class="fa-solid fa-receipt"></i></a>
                        <a href="#" class="btn-cart position-relative" id="shopping-cart-btn">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p class="quantity-cart position-absolute" id="quantityCart-text"></p>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

    </div>
</header>
<?php
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Đăng xuất thành công!',
                text: 'Bạn đã đăng xuất khỏi hệ thống.',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

?>