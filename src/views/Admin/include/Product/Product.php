<body class="bg-gray-50 min-h-screen p-4">
    <div class="mx-auto max-w-7xl bg-white p-6 rounded-md shadow-sm">
        <!-- Tiêu đề -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Sản phẩm</h1>
            <a href="index.php?pages=addProduct" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Thêm sản phẩm
            </a>
        </div>

        <!-- Search -->
        <div class="flex items-center justify-between mb-4">
            <div class="relative">
                <input id="searchProduct" type="text" placeholder="Tìm kiếm sản phẩm..."
                    class="w-72 border border-gray-300 rounded-md py-2 px-3 pr-10 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                <span class="absolute right-3 top-2 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>

        <!-- Bảng sản phẩm -->
        <div class="w-full h-[450px] overflow-x-auto">
            <table id="productTable" class="w-full min-w-max text-left border-collapse">
                <thead class="border-b border-gray-200 bg-gray-50 text-sm uppercase text-gray-600">
                    <tr>
                        <th class="py-3 font-medium">ID</th>
                        <th class="py-3 font-medium">Tên sản phẩm</th>
                        <th class="py-3 font-medium">Giá</th>
                        <th class="py-3 font-medium">Mã công thức</th>
                        <th class="py-3 font-medium">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php
                    include_once __DIR__ . '/../../../../controllers/ProductController.php';
                    $productController = new ProductController();
                    $productListItem = $productController->getAllProducts();
                    foreach ($productListItem as $product) {
                        echo '
                        <tr>
                            <td class="py-3">' . $product->getId() . '</td>
                            <td class="py-3 flex items-center">
                                <img src="' . $product->getLinkImage() . '" class="w-10 h-10 rounded mr-2" />
                                <span>' . $product->getProductName() . '</span>
                            </td>
                            <td class="py-3">' . $product->getPrice() . '</td>
                            <td class="py-3">' . $product->getRecipeId() . '</td>
                            <td class="py-3">
                                <button class="text-blue-500 hover:text-blue-700 font-medium">
                                <a  href="index.php?pages=editProduct&controller=product&action=detailProduct&id=' . $product->getId() . '">Sửa</a>                                
                                </button>
                                <span class="mx-1">|</span>
                                <button onclick="deleteProduct(' . $product->getId() . ')" class="text-red-500 hover:text-red-700 font-medium">Xoá</button>
                            </td>
                        </tr>
                        ';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="flex items-center justify-between mt-6">
            <span class="text-sm text-gray-600">
                <span id="paginationInfo">1 - 10</span>
            </span>
            <div class="flex space-x-2">
                <button id="prevPage"
                    class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Prev</button>
                <button id="nextPage"
                    class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Next</button>
            </div>
        </div>
    </div>

    <script>
    function editProduct(productId) {
        sessionStorage.setItem('productId', productId);
        switchSection('productsEdit');
    }
    const rowsPerPage = 10;
    let currentPage = 1;

    const tableBody = document.querySelector('#productTable tbody');
    const allRows = Array.from(tableBody.getElementsByTagName('tr'));
    const searchInput = document.getElementById('searchProduct');
    let filteredRows = allRows;

    function updatePaginationInfo() {
        const total = filteredRows.length;
        const start = (currentPage - 1) * rowsPerPage + 1;
        const end = Math.min(currentPage * rowsPerPage, total);
        document.getElementById('paginationInfo').textContent = `${start} - ${end} of ${total}`;
    }

    function displayRows() {
        allRows.forEach(row => row.style.display = 'none');
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => row.style.display = '');
        updatePaginationInfo();
    }

    function filterRows() {
        const keyword = searchInput.value.toLowerCase();
        filteredRows = allRows.filter(row => {
            const name = row.children[1]?.textContent.toLowerCase();
            return name.includes(keyword);
        });
        currentPage = 1;
        displayRows();
    }

    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayRows();
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayRows();
        }
    });

    searchInput.addEventListener('input', filterRows);

    // Initial
    filterRows();

    function deleteProduct(productId) {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
            fetch('./php/Product/deleteProduct.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) location.reload();
                })
                .catch(err => {
                    console.error("Lỗi:", err);
                    alert("Đã xảy ra lỗi khi gửi yêu cầu xóa.");
                });
        }
    }
    </script>
</body>

</html>