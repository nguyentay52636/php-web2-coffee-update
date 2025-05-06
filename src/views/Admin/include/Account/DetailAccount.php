<?php

include __DIR__ ."/../../../../controllers/UserController.php";

$userController = new UserController();

$userId = $_GET['id'];

$user = $userController->getUserById($userId);

$ordersUsers= $userController->getOrderByAccountId($userId);


?>

<body class="bg-gray-50 min-h-screen p-4">
    <div class="max-w-7xl mx-auto bg-white rounded-md shadow-sm p-6">
        <!-- Thanh điều hướng breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <ol class="list-reset flex">
                <li><a href="#" class="text-blue-500 hover:underline">Trang chủ</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="#" class="text-blue-500 hover:underline">Khách hàng</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700 font-semibold">Chi tiết</li>
            </ol>
        </nav>

        <!-- Tiêu đề chính -->
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Chi tiết khách hàng</h1>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Cột bên trái: Thông tin khách hàng -->
            <div class="w-full md:w-1/3 bg-white rounded-md">
                <div class="border border-gray-100 rounded-md p-4 shadow-sm">
                    <!-- Ảnh đại diện -->
                    <div class="flex items-center mb-4">

                        <p class="rounded-full w-20 h-20 object-cover mr-4 border border-gray-200 bg-blue-50"></p>
                        <div>
                            <h2 class="text-lg font-medium text-gray-700"><?php echo $user->getFullName() ?></h2>
                            <p class="text-sm text-gray-500"><?php echo $user->getEmail() ?></p>
                            <p class="text-sm text-gray-500"><?php echo $user->getPhone() ?></p>
                        </div>
                    </div>

                    <!-- Địa chỉ chính -->
                    <div class="mb-4">
                        <h3 class="text-gray-600 font-semibold mb-1">Address</h3>
                        <p class="text-sm text-gray-700"><?php echo $user->getAddress() ?></p>

                    </div>

                    <!-- Địa chỉ khác -->
                    <!-- <div>
                        <a href="#" class="text-blue-500 text-sm hover:underline">
                            Other Address (2)
                        </a>
                    </div> -->
                </div>
            </div>

            <!-- Cột bên phải: Order History -->
            <div class="w-full md:w-2/3 bg-white rounded-md">
                <div>
                    <!-- Tiêu đề “Order History” -->
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Lịch sử đặt hàng</h2>

                    <!-- Thanh search + filter -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                        <!-- Ô tìm kiếm -->
                        <div class="relative w-full sm:w-1/2">
                            <input id="searchOrder" type="text" placeholder="Tìm kiếm"
                                class="w-full border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm" />
                            <!-- Icon search -->
                            <span class="absolute right-3 top-2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2-2m3-3l5-5m-2.828 2.829a6.965 
                      6.965 0 011.414 5.343c-.207 1.052-.763 2.023-1.606 2.866
                      a7 7 0 11-9.192-9.192 7 7 0 018.384-1.218z" />
                                </svg>
                            </span>
                        </div>

                        <!-- Bộ lọc Status -->
                        <div class="relative w-full sm:w-1/2">
                            <select id="filterStatus"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                                <option>Filter status</option>

                                <option>Pending</option>
                                <option>Completed</option>
                                <option>Canceled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bảng hiển thị Order History -->
                    <div class="h-[400px] overflow-x-auto">
                        <table id="orderTable" class="w-full min-w-max text-left border-collapse text-sm">
                            <thead class="border-b border-gray-200 text-gray-600 uppercase">
                                <tr>
                                    <th class="py-3 font-medium">Mã đặt hàng</th>
                                    <th class="py-3 font-medium">Ngày đặt</th>
                                    <th class="py-3 font-medium">Giá</th>
                                    <th class="py-3 font-medium">Trạng thái</th>
                                    <!-- <th class="py-3 font-medium">Chi tiết</th> -->
                                </tr>
                            </thead>
                            <tbdy class="divide-y divide-gray-100 text-gray-700">

                                <?php
                                foreach ($ordersUsers as $order) {
                                    $orderStat = $order->getOrderStatus();
                                    if ($orderStat == "PENDING") {
                                        $bg="bg-yellow-50 text-yellow-600";
                                    } elseif ($orderStat == "COMPLETED") {
                                        $bg="bg-green-50 text-green-600";
                                    } else {
                                        $bg="bg-red-50 text-red-600";
                                    }
                                    echo '
                                    <tr>
                                        <td class="py-3">'.$order->getId().'</td>
                                        <td class="py-3">'.$order->getDateOfOrder().'</td>
                                        <td class="py-3">$'.$order->getTotal().'</td></td>
                                        <td class="py-3">

            
                                            <span class="'.$bg.' px-2 py-1 rounded text-xs">
                                                '.$orderStat.'
                                            </span>
                                        </td>
                                        
                                    </tr>
                                    ';
                                }
                                ?>

                            </tbdy>
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
                            <!-- Giả sử đang ở trang 1 trên tổng 1 trang -->
                            <span id="paginationInfo">1 - 5 of 5</span>
                            <div class="flex space-x-2 ml-4">
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
            </div><!-- end cột phải -->
        </div>
    </div>

    <script>
    const rowsPerPageAccount = 10;
    let currentPage = 1;
    const tableBody = document.getElementById('orderTable').getElementsByTagName('tbody')[0];
    const allRows = Array.from(tableBody.getElementsByTagName('tr'));
    let filteredRows = [...allRows];

    const searchInput = document.getElementById('searchOrder');
    const statusFilter = document.getElementById('filterStatus');

    function displayRows() {
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPageAccount);

        // Ẩn tất cả các dòng
        allRows.forEach(row => row.style.display = 'none');

        // Hiển thị các dòng sau khi phân trang
        const start = (currentPage - 1) * rowsPerPageAccount;
        const end = Math.min(start + rowsPerPageAccount, totalRows);
        for (let i = start; i < end; i++) {
            filteredRows[i].style.display = '';
        }

        updatePaginationInfo(start + 1, end, totalRows);
        updateButtons(totalPages);
    }

    function updatePaginationInfo(start, end, total) {
        document.getElementById('paginationInfo').innerText = `${start} - ${end} of ${total}`;
    }

    function updateButtons(totalPages) {
        document.getElementById('prevPage').disabled = currentPage <= 1;
        document.getElementById('nextPage').disabled = currentPage >= totalPages;
    }

    function applyFilters() {
        const keyword = searchInput.value.toLowerCase();
        const selectedStatus = statusFilter.value;

        filteredRows = allRows.filter(row => {
            const textMatch = row.innerText.toLowerCase().includes(keyword);
            const statusText = row.getElementsByTagName('td')[3].innerText.trim();

            if (selectedStatus === 'Filter status') {
                return textMatch; // không lọc theo status
            } else {
                return textMatch && statusText.toLowerCase() === selectedStatus.toLowerCase();
            }
        });

        currentPage = 1;
        displayRows();
    }

    // Bắt sự kiện tìm kiếm
    searchInput.addEventListener('input', applyFilters);

    // Bắt sự kiện thay đổi bộ lọc trạng thái
    statusFilter.addEventListener('change', applyFilters);

    // Phân trang
    document.getElementById('prevPage').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            displayRows();
        }
    });

    document.getElementById('nextPage').addEventListener('click', function() {
        const totalPages = Math.ceil(filteredRows.length / rowsPerPageAccount);
        if (currentPage < totalPages) {
            currentPage++;
            displayRows();
        }
    });

    // Hiển thị lần đầu
    displayRows();
    </script>


</body>

</html>