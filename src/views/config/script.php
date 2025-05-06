<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        if ($('.slick-features').length) {
            console.log("Tìm thấy class .slick-features trên DOM");
            $('.slick-features').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                dots: true,
                arrows: true
            });
        } else {
            console.error("Không tìm thấy class .slick-features trên DOM");
        }
    });
</script>

</body>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện click vào nút shopping
        $('#shopping-cart-btn').on('click', function() {
            // Gửi yêu cầu AJAX đến server để kiểm tra session
            fetch("../config/checkSession.php", {
                    method: "POST"
                })
                .then(response => response.json())
                .then(data => {
                    if (data.isLoggedIn) {
                        // Người dùng đã đăng nhập -> Chuyển hướng đến cart.php
                        updateCartQuantityInHeader();
                        $('.main-content').load('../Components/Cart/Cart.php', function(response,
                            status, xhr) {
                            if (status === "error") {
                                console.error("Không thể tải nội dung: " + xhr.status + " " +
                                    xhr.statusText);
                            }
                        });
                    } else {
                        // Người dùng chưa đăng nhập -> Hiển thị cảnh báo
                        Swal.fire({
                            title: "<?php echo 'Bạn chưa đằng nhập'; ?>",
                            text: "<?php echo addslashes('Vui lòng đăng nhập'); ?>",
                            icon: "<?php echo 'error'; ?>",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "../Auth/LoginAndSignUp.php";
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error("Có lỗi xảy ra:", error);
                });
        });
    });
</script>
<script>
    function updateCartQuantityInHeader() {
        // Lưu ý: đường dẫn từ file home.php đến updatecart.php là "../api/updatecart.php"
        fetch('http://localhost/Web_Advanced_Project/src/views/api/updateCart.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('quantityCart-text').textContent = data.totalQuantity;
                } else {
                    document.getElementById('quantityCart-text').textContent = 0;
                }
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật số lượng giỏ hàng:', error);
            });
    }

    // Gọi khi DOM sẵn sàng
    document.addEventListener("DOMContentLoaded", function() {
        updateCartQuantityInHeader();
    });
</script>

<script>
    // Tab functionality
    document.querySelectorAll('.tabSip').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tabSip').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    // Coffee type button functionality
    document.querySelectorAll('.flavorTwist').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.flavorTwist').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // Quantity selector functionality
    const quantityInput = document.querySelector('.cupCounter input');
    if (quantityInput) {
        document.querySelectorAll('.cupCounter button').forEach(btn => {
            btn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (btn.textContent === '+') {
                    quantityInput.value = value + 1;
                } else if (btn.textContent === '-' && value > 1) {
                    quantityInput.value = value - 1;
                }
            });
        });
    }
</script>
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (!empty($message)) : ?>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "<?php echo $success ? 'Thành công!' : 'Lỗi!'; ?>",
                text: "<?php echo addslashes($message); ?>",
                icon: "<?php echo $success ? 'success' : 'error'; ?>",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    <?php if ($success && $action === 'register') : ?>
                        location.reload();
                    <?php elseif ($success && $action === 'login') : ?>
                        window.location.href = "../Pages/Home.php";
                    <?php endif; ?>
                }
            });
        });
    <?php endif; ?>
</script>

<script>
    const mithSignupButton = document.getElementById('mith-signup-btn');
    const lythLoginButton = document.getElementById('lyth-login-btn');
    const qwixBox = document.getElementById('qwix-box');

    mithSignupButton.addEventListener('click', () => {
        qwixBox.classList.add("vorn-right-active");
    });

    lythLoginButton.addEventListener('click', () => {
        qwixBox.classList.remove("vorn-right-active");
    });

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(eye => {
        eye.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>
<script>

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>