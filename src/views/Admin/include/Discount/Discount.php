<body id="discount" class="bg-gray-50 min-h-screen ">
    <!-- Phần container chính -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Tiêu đề & nút tạo discount mới -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-4 md:mb-0">Sản phẩm khuyến mãi</h1>
            <a href="index.php?pages=addDiscount"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tạo khuyến mãi
            </a>
        </div>

        <!-- Thanh tìm kiếm (nếu cần) -->
        <div class="mb-6">
            <div class="relative max-w-sm">
                <input type="text" id="searchInputDiscount"
                    class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search discount..." />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute top-2 left-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </div>
        </div>

        <!-- Bảng danh sách discount -->
        <div class="bg-white shadow-md rounded-md h-[500px] overflow-y-scroll">
            <table id="discountTable" class="min-w-full text-left ">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 font-medium text-gray-700">Mã giãm giá</th>
                        <th class="py-3 px-4 font-medium text-gray-700">Tên chương trình</th>
                        <th class="py-3 px-4 font-medium text-gray-700">Thời gian hoạt động</th>
                        <th class="py-3 px-4 font-medium text-gray-700">Trạng thái</th>
                        <th class="py-3 px-4 font-medium text-gray-700 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php
                    include __DIR__ . "/../../../../controllers/DiscountController.php";

                    $discountsControllers = new DiscountController();

                    $discounts = $discountsControllers->getAllDiscounts();

                    $today = date('Y-m-d');

                    foreach ($discounts as $discount) {
                        $startDate = $discount->getStartDate();

                        $endDate   = $discount->getEndDate();

                        $today = date('Y-m-d');

                        if ($today >= $startDate && $today <= $endDate) {
                            $DivActive = '<span class="text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm font-medium">
                                Hoạt động
                                </span>';
                        } else {
                            $DivActive = '<span class="text-red-700 bg-red-100 px-3 py-1 rounded-full text-sm font-medium">
                                Không hoạt động
                            </span>';
                        }


                        echo '
                        <tr>
                        <td class="py-3 px-4">' . $discount->getId() . '</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">

                                <div>
                                    <div class="text-gray-800 font-semibold">' . $discount->getDiscountName() . '</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600">
                            <div>' . $discount->getStartDate() . '</div>
                            <div class="text-gray-400">→ ' . $discount->getEndDate() . '</div>
                        </td>
                        <td class="py-3 px-4">
                            ' . $DivActive . '
                        </td>
                        <td class="py-3 px-4 text-right">
                        
                        
                        <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium bg-gray-100 px-3 py-1 rounded-full">
                            <a href="index.php?pages=editDiscount&controller=discount&action=editDiscount&id=' . $discount->getId() . '">Sửa</a>
                        </button>

                        <button type="submit" 
                        onclick="deleteDiscount(' . $discount->getId() . ')"
                        class="text-red-600 hover:text-red-800 font-medium bg-gray-100 px-3 py-1 rounded-full">
                            Xóa
                        </button>
                        
                        </td>
                    </tr>
                        ';
                    }
                    ?>

                </tbody>
            </table>
            <!-- Phân trang -->
            <div class="flex items-center justify-between mt-6">
                <span class="text-sm text-gray-600">
                    <span id="paginationInfoDiscount">1 - 10</span>
                </span>
                <div class="flex space-x-2">
                    <button id="prevPageDiscount"
                        class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Prev</button>
                    <button id="nextPageDiscount"
                        class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteDiscount(discountId) {
            alert(discountId);
            if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {

                fetch('./php/Discount/deleteDiscount.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: discountId
                        })
                    })
                    .then(response => response.text())
                    .then(text => {
                        console.log("Dữ liệu nhận được:", text);
                        try {
                            // Xóa bỏ khoảng trắng đầu/cuối nếu có
                            const jsonData = JSON.parse(text.trim());
                            return jsonData;
                            console.log("Parsed JSON:", jsonData);
                        } catch (error) {
                            console.error("Lỗi khi parse JSON:", error);
                        }
                    })
                    .then(data => {
                        if (data.success) {



                        }
                    })
                    .catch(error => {
                        console.error("Lỗi:", error);
                        alert("Đã xảy ra lỗi khi gửi yêu cầu xóa.");
                    });
            }
        }


        const discountAllRows = Array.from(document.querySelectorAll("#discountTable tbody tr"));
        const discountSearchInput = document.getElementById("searchInputDiscount");
        const discountPaginationInfo = document.getElementById("paginationInfoDiscount");
        const discountPrevPageBtn = document.getElementById("prevPageDiscount");
        const discountNextPageBtn = document.getElementById("nextPageDiscount");

        let discountCurrentPage = 1;
        const discountRowsPerPage = 10;
        let discountFilteredRows = [...discountAllRows];

        // Hiển thị bảng theo trang
        function renderDiscountPage(page) {
            const start = (page - 1) * discountRowsPerPage;
            const end = start + discountRowsPerPage;

            // Ẩn toàn bộ rows trước
            discountAllRows.forEach(row => row.style.display = "none");

            // Hiển thị những dòng phù hợp sau tìm kiếm + phân trang
            discountFilteredRows.slice(start, end).forEach(row => {
                row.style.display = "table-row";
            });

            const total = discountFilteredRows.length;
            const showingStart = total > 0 ? start + 1 : 0;
            const showingEnd = Math.min(end, total);
            discountPaginationInfo.textContent = `${showingStart} - ${showingEnd} of ${total}`;

            discountPrevPageBtn.disabled = page <= 1;
            discountNextPageBtn.disabled = end >= total;
        }

        // Tìm kiếm
        function filterDiscountTable() {
            const keyword = discountSearchInput.value.toLowerCase();
            discountFilteredRows = discountAllRows.filter(row =>
                row.textContent.toLowerCase().includes(keyword)
            );
            discountCurrentPage = 1;
            renderDiscountPage(discountCurrentPage);
        }

        // Điều khiển Prev / Next
        discountPrevPageBtn.addEventListener("click", () => {
            if (discountCurrentPage > 1) {
                discountCurrentPage--;
                renderDiscountPage(discountCurrentPage);
            }
        });

        discountNextPageBtn.addEventListener("click", () => {
            const totalPages = Math.ceil(discountFilteredRows.length / discountRowsPerPage);
            if (discountCurrentPage < totalPages) {
                discountCurrentPage++;
                renderDiscountPage(discountCurrentPage);
            }
        });

        discountSearchInput.addEventListener("input", filterDiscountTable);

        // Hiển thị lần đầu tiên
        renderDiscountPage(discountCurrentPage);
    </script>

</body>