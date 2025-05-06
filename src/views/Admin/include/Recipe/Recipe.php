<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Nhúng Tailwind CSS từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet">
    <title>Quản Lý Công Thức Pha Chế & Đơn Vị Tính</title>
    <style>
        /* Ẩn nội dung các tab mặc định */
        .tab-content {
            display: none;
        }

        /* Hiển thị tab đang active */
        .tab-active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto bg-white rounded-md shadow-lg p-6">
        <!-- Tiêu đề trang -->
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Quản Lý Công Thức Pha Chế & Đơn Vị Tính</h1>

        <!-- Thanh điều hướng tab -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                <button id="tab-recipe"
                    class="tab-button pb-2 text-blue-600 border-b-2 border-blue-600 font-medium focus:outline-none"
                    onclick="switchTab('recipe')">
                    Công thức pha chế
                </button>
                <button id="tab-unit"
                    class="tab-button pb-2 text-gray-500 hover:text-blue-600 border-b-2 border-transparent font-medium focus:outline-none"
                    onclick="switchTab('unit')">
                    Đơn vị tính
                </button>
            </nav>
        </div>

        <!-- Nội dung tab: Công thức pha chế -->
        <div id="content-recipe" class="tab-content tab-active">
            <!-- Tìm kiếm & Bộ lọc -->
            <div class="flex flex-col sm:flex-row justify-between mb-4">
                <div class="relative w-full sm:w-1/2 mb-2 sm:mb-0">
                    <input type="text" id="search-recipe" placeholder="Tìm kiếm công thức"
                        class="w-full border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <span class="absolute right-3 top-2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2-2m3-3l5-5m-2.828 2.829a6.965
                   6.965 0 011.414 5.343c-.207 1.052-.763 2.023-1.606 2.866a7 
                   7 0 11-9.192-9.192 7 7 0 018.384-1.218z" />
                        </svg>
                    </span>
                </div>
                <!-- Nút thêm mới -->
                <a href="index.php?pages=addRecipe&check=0"
                    class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none">
                    Thêm công thức
                </a>
            </div>

            <!-- Bảng danh sách công thức -->
            <div class="overflow-x-auto h-[450px]">
                <table class="w-full text-left border-collapse">
                    <thead class="border-b border-gray-200">
                        <tr class="uppercase text-gray-600 text-sm">
                            <th class="py-3">Mã Công Thức</th>
                            <th class="py-3">Tên Công Thức</th>


                            <th class="py-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="recipe-table-body" class="divide-y divide-gray-100 text-gray-700 text-sm">
                        <!-- Ví dụ dòng 1 -->
                        <!-- <tr>
                            <td class="py-3">CT001</td>
                            <td class="py-3">Espresso</td>
                            <td class="py-3">Công thức cơ bản cho cà phê đậm đà</td>
                            <td class="py-3">
                                <span class="bg-green-50 text-green-600 px-2 py-1 rounded text-xs">Active</span>
                            </td>
                            <td class="py-3">
                                <button class="text-blue-500 hover:underline mr-5">Xem</button>
                                <p class="inline-block mr-5">|</p>
                                <button class="text-blue-500 hover:underline">Xóa</button>
                            </td>
                        </tr> -->
                        <?php
                        include_once __DIR__ . "/../../../../controllers/RecipeController.php";

                        $recipeController = new RecipeController();

                        $recipe = $recipeController->getAllRecipes();

                        foreach ($recipe as $recipeItem) {
                            echo '
                            <tr>
                            <td class="py-3">' . $recipeItem->getId() . '</td>
                            <td class="py-3">' . $recipeItem->getRecipeName() . '</td>
                        
                            
                            <td class="py-3">
                                <button class="text-blue-500 hover:underline mr-5">
                                <a href="index.php?pages=editRecipe&check=1&id=' . $recipeItem->getId() . '">Sửa</a>
                                </button>
   
                   
                            </td>
                        </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="flex items-center justify-between mt-6">
                    <span class="text-sm text-gray-600">
                        <span id="paginationInfo">1 - 10</span>
                    </span>
                    <div class="flex space-x-2">
                        <button id="prevPage"
                            class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Trang
                            trước</button>
                        <button id="nextPage"
                            class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Trang
                            sau</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nội dung tab: Đơn vị tính -->
        <div id="content-unit" class="tab-content ">
            <!-- Tìm kiếm & Nút thêm mới -->
            <div class="flex flex-col sm:flex-row justify-between mb-4">
                <div class="relative w-full sm:w-1/2 mb-2 sm:mb-0">
                    <input type="text" id="search-unit" placeholder="Tìm kiếm đơn vị"
                        class="w-full border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <span class="absolute right-3 top-2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2-2m3-3l5-5m-2.828 2.829a6.965
                   6.965 0 011.414 5.343c-.207 1.052-.763 2.023-1.606 2.866a7 
                   7 0 11-9.192-9.192 7 7 0 018.384-1.218z" />
                        </svg>
                    </span>
                </div>
                <a href="index.php?pages=addUnit"
                    class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none">
                    Thêm đơn vị
                </a>
            </div>

            <!-- Bảng danh sách đơn vị tính -->
            <div class="overflow-x-auto h-[450px]">
                <table class="w-full text-left border-collapse">
                    <thead class="border-b border-gray-200">
                        <tr class="uppercase text-gray-600 text-sm">
                            <th class="py-3">Mã Đơn Vị</th>
                            <th class="py-3">Tên Đơn Vị</th>
                            <th class="py-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="unit-table-body" class="divide-y divide-gray-100 text-gray-700 text-sm">


                        <?php
                        include __DIR__ . "/../../../../controllers/UnitController.php";

                        $unitController = new UnitController();
                        $units = $unitController->getAllUnits();
                        foreach ($units as $unitItem) {
                            echo '
                                <tr>
                            <td class="py-3">' . $unitItem->getId() . '</td>
                            <td class="py-3">' . $unitItem->getType() . '</td>
                            
                            <td class="py-3">
                                <button class="text-blue-500 hover:underline mr-5">
                                <a href="index.php?pages=editUnit&id=' . $unitItem->getId() . '">Sửa</a>
                                </button>
                                <p class="inline-block mr-5">|</p>
                                <button
                                onclick=deleteUnit(' . $unitItem->getId() . ')
                                class="text-blue-500 hover:underline">Xóa</button>
                            </td>
                        </tr>
                                ';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="flex items-center justify-between mt-6">
                    <span class="text-sm text-gray-600">
                        <span id="paginationInfoUnit">1 - 10</span>
                    </span>
                    <div class="flex space-x-2">
                        <button id="prevPageUnit"
                            class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Trang
                            trước</button>
                        <button id="nextPageUnit"
                            class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Trang
                            sau</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script chuyển đổi giữa các tab -->
    <script>
        function deleteUnit(unitId) {
            // Xóa đơn vị tại đây
            if (confirm("Bạn có chắc chắn muốn xóa đơn vị này?")) {
                alert(unitId);
                fetch('./php/Unit/deleteUnit.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: unitId
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
                        alert(data.message);
                        if (data.success) location.reload();
                    })
                    .catch(err => {
                        console.error("Lỗi khi xóa đơn vị:", err);
                    })

            }

        }

        function deleteRecipe(recipeId) {
            // Xóa công thức tại đây
            if (confirm("Bạn có chắc chắn muốn xóa công thức này?")) {
                fetch('./php/Recipe/deleteRecipe.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: recipeId
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
                        alert(data.message);
                        if (data.success) location.reload();
                    })
                    .catch(err => {
                        console.error("Lỗi:", err);
                        alert("Đã xảy ra lỗi khi gửi yêu cầu xóa.");
                    });
            }

        }

        function switchTab(tab) {
            // Xóa trạng thái active trên tất cả tab button
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-500', 'border-transparent');
            });

            // Ẩn toàn bộ nội dung tab
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('tab-active');
            });

            // Cập nhật trạng thái cho tab được chọn
            if (tab === 'recipe') {
                document.getElementById('tab-recipe').classList.add('text-blue-600', 'border-blue-600');
                document.getElementById('tab-unit').classList.remove('text-blue-600', 'border-blue-600');
                document.getElementById('content-recipe').classList.add('tab-active');
            } else {
                document.getElementById('tab-unit').classList.add('text-blue-600', 'border-blue-600');
                document.getElementById('tab-recipe').classList.remove('text-blue-600', 'border-blue-600');
                document.getElementById('content-unit').classList.add('tab-active');
            }
        }



        const rowsPerPageRecipe = 10;
        let currentPageRecipe = 1;

        const tableBodyRecipe = document.getElementById('recipe-table-body');
        const searchInputRecipe = document.getElementById('search-recipe');
        const paginationInfo = document.getElementById('paginationInfo');
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        let allRowsRecipe = Array.from(tableBodyRecipe.querySelectorAll('tr'));
        let filteredRowsRecipe = [...allRowsRecipe]; // Rows sau khi lọc

        function displayPage(page) {
            currentPageRecipe = page;
            const totalPages = Math.ceil(filteredRowsRecipe.length / rowsPerPageRecipe);
            if (currentPageRecipe > totalPages) currentPageRecipe = totalPages;

            const start = (currentPageRecipe - 1) * rowsPerPageRecipe;
            const end = start + rowsPerPageRecipe;

            // Ẩn tất cả
            allRowsRecipe.forEach(row => row.style.display = 'none');

            // Hiện filtered rows
            filteredRowsRecipe.slice(start, end).forEach(row => {
                row.style.display = '';
            });

            // Cập nhật chỉ số trang
            if (filteredRowsRecipe.length === 0) {
                paginationInfo.textContent = `0 - 0`;
            } else {
                paginationInfo.textContent = `${start + 1} - ${Math.min(end, filteredRowsRecipe.length)}`;
            }
        }

        // Lọc dữ liệu theo input tìm kiếm
        searchInputRecipe.addEventListener('input', () => {
            const keyword = searchInputRecipe.value.toLowerCase();
            filteredRowsRecipe = allRowsRecipe.filter(row => {
                const recipeName = row.children[1]?.textContent?.toLowerCase() || "";
                return recipeName.includes(keyword);
            });
            displayPage(1); // luôn quay về trang 1 khi tìm
        });

        // Nút chuyển trang
        prevBtn.addEventListener('click', () => {
            if (currentPageRecipe > 1) displayPage(currentPageRecipe - 1);
        });

        nextBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredRowsRecipe.length / rowsPerPageRecipe);
            if (currentPageRecipe < totalPages) displayPage(currentPageRecipe + 1);
        });

        // Khởi tạo trang đầu tiên
        displayPage(1);



        // Phân trang và tìm kiếm cho Unit 
        // Cấu hình cho phần "Đơn vị tính"
        const rowsPerPageRecipeUnit = 10;
        let currentPageRecipeUnit = 1;
        const unitTableBody = document.getElementById('unit-table-body');
        const unitSearchInput = document.getElementById('search-unit');
        const paginationInfoUnit = document.getElementById('paginationInfoUnit');
        const prevBtnUnit = document.getElementById('prevPageUnit');
        const nextBtnUnit = document.getElementById('nextPageUnit');

        // Lấy tất cả các dòng của bảng đơn vị tính
        let allRowsRecipeUnit = Array.from(unitTableBody.querySelectorAll('tr'));
        let filteredRowsRecipeUnit = [...allRowsRecipeUnit]; // Mảng này sẽ lưu các dòng sau khi lọc

        // Hàm hiển thị trang hiện tại cho đơn vị tính
        function displayUnitPage(page) {
            currentPageRecipeUnit = page;
            const totalPagesUnit = Math.ceil(filteredRowsRecipeUnit.length / rowsPerPageRecipeUnit);
            if (currentPageRecipeUnit > totalPagesUnit) currentPageRecipeUnit = totalPagesUnit;

            const start = (currentPageRecipeUnit - 1) * rowsPerPageRecipeUnit;
            const end = start + rowsPerPageRecipeUnit;

            // Ẩn tất cả các dòng
            allRowsRecipeUnit.forEach(row => row.style.display = 'none');

            // Hiển thị các dòng thuộc trang hiện tại (sau khi lọc)
            filteredRowsRecipeUnit.slice(start, end).forEach(row => {
                row.style.display = '';
            });

            // Cập nhật thông tin phân trang
            if (filteredRowsRecipeUnit.length === 0) {
                paginationInfoUnit.textContent = `0 - 0`;
            } else {
                paginationInfoUnit.textContent = `${start + 1} - ${Math.min(end, filteredRowsRecipeUnit.length)}`;
            }
        }

        // Sự kiện tìm kiếm cho đơn vị tính
        unitSearchInput.addEventListener('input', () => {
            const keyword = unitSearchInput.value.toLowerCase();
            filteredRowsRecipeUnit = allRowsRecipeUnit.filter(row => {
                // Giả sử cột "Tên Đơn Vị" là cột thứ 2 (chỉ số 1)
                const unitName = row.children[1]?.textContent?.toLowerCase() || "";
                return unitName.includes(keyword);
            });
            displayUnitPage(1); // luôn quay về trang 1 khi tìm kiếm
        });

        // Xử lý sự kiện chuyển trang
        prevBtnUnit.addEventListener('click', () => {
            if (currentPageRecipeUnit > 1) displayUnitPage(currentPageRecipeUnit - 1);
        });

        nextBtnUnit.addEventListener('click', () => {
            const totalPagesUnit = Math.ceil(filteredRowsRecipeUnit.length / rowsPerPageRecipeUnit);
            if (currentPageRecipeUnit < totalPagesUnit) displayUnitPage(currentPageRecipeUnit + 1);
        });

        // Khởi tạo hiển thị trang đầu tiên cho đơn vị tính
        displayUnitPage(1);
    </script>
</body>