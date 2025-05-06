<style>
    /* Danh mục (category buttons) */
    .category-filter {
        padding: 0.3rem 0.9rem;
        font-size: 0.5rem;
        border-radius: 10px;
        border: 1.5px solid #6c757d;
        background-color: #fff;
        color: #343a40;
        transition: all 0.3s ease;
        margin: 4px;
        font-weight: 500;
    }

    .category-filter:hover,
    .category-filter.active {
        background-color: #343a40;
        color: #fff;
        border-color: #343a40;
    }

    /* Phân trang */
    .pagination .page-item .page-link {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        margin: 0 5px;
        line-height: 38px;
        text-align: center;
        color: #343a40;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease-in-out;
    }

    .pagination .page-item .page-link:hover {
        background-color: #343a40;
        color: #fff;
    }

    .pagination .page-item.active .page-link {
        background-color: #343a40;
        color: #fff;
        border-color: #343a40;
    }
</style>
<!-- Coffee house merchandise -->
<div id="san-pham" class="spacing">
    <div class="container text-dark text-center">
        <!-- Header -->
        <div class="text-center">
            <h1 class="menu-div-h1 fs-1 mb-3">MENU HÔM NAY</h1>
            <h5 class="menu-div-h5 fs-4 mb-4 fw-bold text-dark">Xem món hôm nay</h5>
        </div>

        <!-- Search Box -->
        <div class="search-container mb-3">
            <input type="text" class="search-input" id="search-input" placeholder="Tìm kiếm sản phẩm">
            <i class="fas fa-search search-icon"></i>
        </div>

        <!-- Category Filter Buttons -->
        <div class="btn-phantrang d-lg-flex justify-content-center m-4 gap-2 flex-wrap">
            <button class="btn btn-outline-dark category-filter" data-category="">Tất cả</button>
            <button class="btn btn-outline-dark category-filter" data-category="1">Cafe</button>
            <button class="btn btn-outline-dark category-filter" data-category="2">Trà</button>
            <button class="btn btn-outline-dark category-filter" data-category="3">Khác</button>
        </div>

        <!-- Product List Container -->
        <div id="product-list"
            class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <!-- Products will be injected via JS -->
        </div>

        <!-- Pagination Container -->
        <div class="pagination-div mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center" id="pagination">
                    <!-- Page numbers will be injected via JS -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    let searchKeyword = "";
    let categoryId = "";

    function loadProducts(page = 1) {
        const url =
            `http://localhost/Web_Advanced_Project/src/views/Components/Products/fetch_products.php?page=${page}&search=${encodeURIComponent(searchKeyword)}&category=${categoryId}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                renderProducts(data.products);
                renderPagination(data.totalPages, page);
            });
    }


    function renderProducts(products) {
        const productList = document.getElementById("product-list");
        productList.innerHTML = "";

        if (products.length === 0) {
            productList.innerHTML = "<p>Không tìm thấy sản phẩm.</p>";
            return;
        }

        // Tạo HTML cho từng sản phẩm và thêm vào giao diện
        products.forEach(p => {
            const baseImagePath = '/Web_Advanced_Project/src/views/Admin/';
            productList.innerHTML += `
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card__image">
                        <img src="${window.location.origin + baseImagePath + p.linkImage}" />
                        <div class="card__addtocard text-white" onclick="handleAddToCart(${p.id})">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <h1>ADD TO CART</h1>
                        </div>
                    </div>
                    <div class="card__content">
                        <h1>${p.productName}</h1>
                        <div class="card__content__line"></div>
                        <h1>${Number(p.price).toLocaleString()}đ</h1>
                    </div>
                    <div class="text-center">
                        <a href="/Web_Advanced_Project/src/views/Components/Products/ProductDetails.php?id=${p.id}" class="card__details-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        `;
        });
    }

    function renderPagination(totalPages, currentPage) {
        const pagination = document.getElementById("pagination");
        const paginationWrapper = document.querySelector(".pagination-div");

        pagination.innerHTML = "";

        if (totalPages <= 1) {
            paginationWrapper.style.display = "none";
            return;
        } else {
            paginationWrapper.style.display = "block";
        }

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === currentPage ? "active" : ""}`;

            const a = document.createElement("a");
            a.className = "page-link";
            a.href = "#";
            a.textContent = i;

            // Ngăn cuộn lên đầu và gọi chuyển trang
            a.addEventListener("click", function(event) {
                event.preventDefault(); // Ngăn cuộn lên đầu
                changePage(i);
            });

            li.appendChild(a);
            pagination.appendChild(li);
        }
    }


    function changePage(page) {
        currentPage = page;
        loadProducts(page);
    }

    // Lắng nghe sự kiện nhập liệu trên ô tìm kiếm
    document.getElementById("search-input").addEventListener("input", function() {
        searchKeyword = this.value;
        loadProducts(1); // Tải lại sản phẩm khi tìm kiếm thay đổi
    });

    // Lắng nghe sự kiện chọn bộ lọc theo danh mục
    document.querySelectorAll(".category-filter").forEach(btn => {
        btn.addEventListener("click", function() {
            categoryId = this.dataset.category;
            loadProducts(1); // Tải lại sản phẩm khi chọn bộ lọc
        });
    });

    // Tải sản phẩm lần đầu tiên khi trang được tải
    loadProducts(1);

    //
    function loadCategories() {
        fetch("http://localhost/Web_Advanced_Project/src/views/Components/Products/fetch_categories.php")
            .then(res => res.json())
            .then(categories => {
                const container = document.querySelector(".btn-phantrang");
                container.innerHTML = ""; // Xóa các nút cũ

                // Nút "Tất cả"
                const allBtn = document.createElement("button");
                allBtn.className = "btn btn-outline-dark category-filter";
                allBtn.dataset.category = "";
                allBtn.textContent = "Tất cả";
                container.appendChild(allBtn);

                // Các nút danh mục từ DB
                categories.forEach(cat => {
                    const btn = document.createElement("button");
                    btn.className = "btn btn-outline-dark category-filter";
                    btn.dataset.category = cat.id;
                    btn.textContent = cat.name;
                    container.appendChild(btn);
                });

                // Gắn lại sự kiện sau khi tạo nút
                addCategoryFilterEvents();
            });
    }

    function addCategoryFilterEvents() {
        document.querySelectorAll(".category-filter").forEach(btn => {
            btn.addEventListener("click", function() {
                categoryId = this.dataset.category;
                currentPage = 1;
                loadProducts(currentPage);

                // Highlight nút đang chọn
                document.querySelectorAll(".category-filter").forEach(b => b.classList.remove("active"));
                this.classList.add("active");
            });
        });
    }

    loadCategories();



    function handleAddToCart(productId) {
        fetch('/Web_Advanced_Project/src/views/Components/Products/add_to_cart_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productId: productId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'not_logged_in') {
                    window.location.href = '/Web_Advanced_Project/src/views/Auth/LoginAndSignUp.php';
                } else if (data.status === 'success') {
                    alert('Đã thêm vào giỏ hàng!');
                    updateCartQuantityInHeader();
                } else {
                    alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
                }
            });
    }
</script>