<body class="bg-gray-50 min-h-screen p-4 ">
    <!-- Phần container chính -->
    <div class="mx-auto max-w-7xl bg-white p-6 rounded-md shadow-sm">

        <!-- Tiêu đề trang -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Khách hàng</h1>


            <!-- <div class="flex items-center space-x-3">

                
                <div>
                    <select
                        class="bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option>Last Week</option>
                        <option>This Week</option>
                        <option>Last Month</option>
                        <option>This Month</option>
                    </select>
                </div>

                
                <div>
                    <input type="text" placeholder="10 Apr - 30 Apr"
                        class="w-40 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>

                
                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Export
                </button>
            </div> -->
        </div>

        <!-- Ô tìm kiếm -->
        <div class="flex items-center justify-between mb-4">
            <!-- Trường search -->
            <div class="relative">
                <input id="searchAccount" type="text" placeholder="Search ..."
                    class="w-72 border border-gray-300 rounded-md py-2 px-3 pr-10 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                <span class="absolute right-3 top-2 text-gray-400">
                    <!-- Icon search (tạm thời dùng text) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2-2m3-3l5-5m-2.828 2.829a6.965 
                     6.965 0 011.414 5.343c-.207 1.052-.763 2.023-1.606 2.866a7 
                     7 0 11-9.192-9.192 7 7 0 018.384-1.218z" />
                    </svg>
                </span>
            </div>
        </div>

        <!-- Bảng hiển thị danh sách khách hàng -->
        <div class="w-full h-[450px] overflow-x-auto">
            <table id="accountTable" class="w-full min-w-max text-left border-collapse">
                <thead class="border-b border-gray-200">
                    <tr class="text-gray-600 uppercase text-sm">
                        <th class="py-3 font-medium">Mã khách hàng</th>
                        <th class="py-3 font-medium">Tên khách hàng</th>
                        <th class="py-3 font-medium">Số điện thoại</th>
                        <th class="py-3 font-medium">Email</th>

                        <th class="py-3 font-medium">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <!-- Hàng 1 -->
                    <!-- <tr>
                        <td class="py-3">1</td>
                        <td class="py-3">Jhon Santos</td>
                        <td class="py-3">+1 (555) 0112</td>
                        <td class="py-3">$1029.00</td>
                        <td class="py-3">2 min ago</td>
                        <td class="py-3">
                            <button class="text-blue-500 hover:text-blue-700 font-medium">View</button>
                        </td>
                    </tr> -->
                    <?php
                        include __DIR__ ."/../../../../controllers/UserController.php";

                        $userController = new UserController();

                        $users = $userController->getAllUsers();

                        
                    foreach($users as $user) {
                        echo '
                        <tr>
                        <td class="py-3">'.$user->getAccountId().'</td>
                        <td class="py-3">'.$user->getFullName().'</td>
                        <td class="py-3">'.$user->getPhone().'</td></td>
                        <td class="py-3">'.$user->getEmail().'</td></td>
                        <td class="py-3">
                            <button class="text-blue-500 hover:text-blue-700 font-medium">
                            <a href="index.php?pages=detailAccount&controller=account&action=detailAccount&id='.$user->getId().'">Chi tiết</a>
                            </button>
                            <p class="inline-block mx-2">|</p>
                            <button onclick="deleteAccount('.$user->getId().')" class="text-blue-500
                    hover:text-blue-700 font-medium">Xóa</button>
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
            <!-- <div class="flex items-center space-x-2">
                <span class="text-gray-600 text-sm">Rows per page:</span>
                <select
                    class="border border-gray-300 rounded-md py-1 px-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option>10</option>
                    <option>20</option>
                    <option>30</option>
                </select>
            </div> -->

            <div class="flex items-center space-x-1 text-sm text-gray-600">
                <!-- Giả sử đang ở trang 1 trên tổng 3 trang -->
                <span>
                    <?php
                        echo '
                        <p id="paginationInfo"> 1 - ' . ceil(count($users)/10) . '</p>
                        ';
                        ?>
                </span>
                <div class="flex space-x-2 ml-4">
                    <button id="prevPage"
                        class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Prev</button>
                    <button id="nextPage"
                        class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const rowsPerPageAccount = 10;
    let currentPageAccount = 1;
    const tableBodyAccount = document.getElementById('accountTable').getElementsByTagName('tbody')[0];
    const searchInputAccount = document.getElementById('searchAccount');
    let allRowsAccount = Array.from(tableBodyAccount.getElementsByTagName('tr'));
    let filteredRowsAccount = allRowsAccount;

    function displayRows() {
        // Ẩn tất cả hàng
        allRowsAccount.forEach(row => row.style.display = 'none');

        // Tính toán vị trí hiển thị
        const start = (currentPageAccount - 1) * rowsPerPageAccount;
        const end = start + rowsPerPageAccount;

        const rowsToShow = filteredRowsAccount.slice(start, end);

        rowsToShow.forEach(row => row.style.display = '');

        updatePaginationInfo();
    }

    function updatePaginationInfo() {
        const totalFiltered = filteredRowsAccount.length;
        const startRow = (currentPageAccount - 1) * rowsPerPageAccount + 1;
        const endRow = Math.min(currentPageAccount * rowsPerPageAccount, totalFiltered);
        document.getElementById('paginationInfo').innerText = `${startRow} - ${endRow} of ${totalFiltered}`;
    }

    function filterRows() {
        const keyword = searchInputAccount.value.trim().toUpperCase();

        filteredRowsAccount = allRowsAccount.filter(row => {
            const tds = row.getElementsByTagName('td');
            const name = tds[1]?.textContent.toUpperCase() || '';
            const phone = tds[2]?.textContent.toUpperCase() || '';
            const email = tds[3]?.textContent.toUpperCase() || '';

            return name.includes(keyword) || phone.includes(keyword) || email.includes(keyword);
        });

        currentPageAccount = 1; // reset to first page
        displayRows();
    }

    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPageAccount > 1) {
            currentPageAccount--;
            displayRows();
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(filteredRowsAccount.length / rowsPerPageAccount);
        if (currentPageAccount < totalPages) {
            currentPageAccount++;
            displayRows();
        }
    });

    searchInputAccount.addEventListener('input', filterRows);

    // Initial load
    filterRows();


    function deleteAccount(accountId) {
        if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
            fetch('./php/Account/deleteAccount.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: accountId
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
                    if (data.success) {
                        location.reload(); // Reload nếu xóa thành công
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Đã xảy ra lỗi khi gửi yêu cầu xóa.");
                });
        }
    }
    </script>


</body>