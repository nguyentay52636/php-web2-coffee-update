<?php
include __DIR__ . "/../../../../controllers/OrderController.php";
include __DIR__ . "/../../../../controllers/UserController.php";
include __DIR__ . "/../../../../controllers/DiscountController.php";
$orderController = new OrderController();
$userController = new UserController();
$discountController = new DiscountController();
$orders;
$users;
$discounts;
?>
<div class="bg-white border-0 rounded-md font-sans h-screen" id="order_main">
    <div class="p-6">

        <header class="flex justify-between items-center mb-3">
            <div>
                <h2 class="text-2xl font-semibold">Orders</h2>
                <p class="text-xs text-gray-500">Home / Order </p>
            </div>
            <div class="flex items-center">
                <button class="text-gray-500 focus:outline-none mr-4">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="text-gray-500 focus:outline-none">
                    <i class="fas fa-bell"></i>
                </button>
            </div>
        </header>
        <div class="flex  gap-1">

            <!-- <div class="flex items-center "> -->
            <div class="">
                <select class="border p-2 rounded pr-8" id="select_search_status" onchange="searchOrder()">
                    <option value="all" selected>All Status</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Canceled</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="">
                <select class="border p-2 rounded  appearance-none pr-8" id="select_search_date"
                    onchange="searchDate(this)">
                    <option value="" selected disabled>Select Date</option>
                    <option value="today">Today</option>
                    <option value="7day">Last 7 Day</option>
                    <option value="30day">Last 30 Day</option>
                    <option value="thism">This Month</option>
                    <option value="lastm">Last Month</option>
                    <option value="custom">Custom Range</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="relative">
                <input type="date" placeholder="Start date" class="border p-2  rounded appearance-none"
                    id="input_start_date" onchange="searchOrder()" disabled value="1971-01-01">

            </div>

            <div class="relative">
                <input type="date" placeholder="End date" class="border p-2 rounded appearance-none" id="input_end_date"
                    onchange="searchOrder()" max="" disabled>

            </div>
            <script>
                function getCurDate(e) {
                    e.value = formatDate(new Date());
                }

                window.onload = function() {
                    const endDateInput = document.getElementById('input_end_date');
                    endDateInput.value = formatDate(new Date());
                };

                function formatDate(date) {
                    return date.toISOString().split('T')[0];
                }

                function getDaysInMonth(year, month) {
                    return new Date(year, month + 1, 0).getDate();
                }

                function disableDatePicker(start, end) {
                    start.disabled = true;
                    end.disabled = true;

                }

                function searchDate(e) {
                    let val = e.value;
                    let startInput = document.getElementById("input_start_date");
                    let endInput = document.getElementById("input_end_date");
                    startInput.max = formatDate(new Date());
                    endInput.max = formatDate(new Date());

                    if (val == "today") {
                        startInput.value = formatDate(new Date());
                        endInput.value = formatDate(new Date());
                        disableDatePicker(startInput, endInput);
                    } else if (val == "7day") {
                        let end = new Date();
                        let last7day = new Date(end);
                        last7day.setDate(end.getDate() - 7);
                        startInput.value = formatDate(last7day);
                        endInput.value = formatDate(end);
                        disableDatePicker(startInput, endInput);

                    } else if (val == "30day") {
                        let end = new Date();
                        let last30day = new Date(end);
                        last30day.setDate(end.getDate() - 30);
                        startInput.value = formatDate(last30day);
                        endInput.value = formatDate(end);
                        disableDatePicker(startInput, endInput);


                    } else if (val == "thism") {
                        let startMonth = new Date();
                        startMonth.setDate(1);
                        startInput.value = formatDate(startMonth);
                        endInput.value = formatDate(new Date());
                        disableDatePicker(startInput, endInput);

                    } else if (val == "lastm") {
                        let end = new Date();
                        end.setMonth(end.getMonth() - 1);
                        end.setDate(getDaysInMonth(end.getYear(), end.getMonth()));
                        let start = new Date(end);
                        start.setDate(1);
                        startInput.value = formatDate(start);
                        endInput.value = formatDate(end);
                        disableDatePicker(startInput, endInput);

                    } else {

                        startInput.disabled = false;
                        endInput.disabled = false;
                        startInput.value = formatDate(new Date());
                        endInput.value = formatDate(new Date());

                    }
                    searchOrder();
                }

                function searchOrder() {
                    // let search=document.getElementById("input_search");
                    let status = document.getElementById("select_search_status");
                    let searchFilter = document.getElementById("select_search_date");
                    let startDate = document.getElementById("input_start_date");
                    let endDate = document.getElementById("input_end_date");

                    if (startDate.value > endDate.value) {
                        alert("Ngày bắt đầu phải lớn hơn ngày kết thúc!");
                        return;
                    }
                    $.ajax({
                        url: "include/Order/SearchOrder.php",
                        method: "POST",
                        data: JSON.stringify({

                            "status": status.value,
                            "start": startDate.value,
                            "end": endDate.value,
                        }),
                        success: function(data) {
                            document.getElementById("table_order_body").innerHTML = data;
                        }
                    })

                }
            </script>
        </div>
        <div class="border-0 border-black rounded-md overflow-hidden mt-3">
            <div class=" overflow-y-auto text-[0.7rem]" style="height: calc(97vh - 150px);">
                <table class="table-auto w-full border-collapse text-center" id="table_order">
                    <thead class="bg-gray-100 sticky top-0 text-center ">
                        <tr class="text-center">
                            <th class=" p-2">Order Id</th>
                            <th class=" p-2">User</th>
                            <th class=" p-2">Date</th>
                            <th class=" p-2">Discount</th>
                            <th class=" p-2">Original</th>
                            <th class=" p-2">Final</th>
                            <th class=" p-2">Status</th>
                            <th class="p-2">View</th>
                            <th class="p-2">Edit</th>

                        </tr>
                    </thead>
                    <tbody id="table_order_body">
                        <?php
                        $i = 1;
                        $orders = $orderController->getAllOrder();
                        foreach ($orders as $ord) {
                            $rowColor = "bg-white";
                            $status = $ord->getOrderStatus();
                            $statusColor = "text-gray-500";

                            if (!($i & 1)) $rowColor = "bg-gray-200";
                            if ($status == "CANCELLED") $statusColor = "text-red-500";
                            else if ($status == "COMPLETED") $statusColor = "text-green-500";
                            $dc = $ord->getDiscountId();
                            if ($dc == null) $dc = "0%";
                            else $dc = $discountController->getDiscountById($ord->getDiscountId())->getDiscountPercent();
                            echo (
                                '<tr class="' . $rowColor . '">
                            <td class="p-3">' . $ord->getId() . '</td>
                            <td class="p-3">' . $ord->getUserId() . '</td>
                            <td class="p-3">' . $ord->getDateOfOrder() . '</td>
                            <td class="p-3">' .  $dc . '</td>
                            <td class="p-3">' . $ord->getPriceBeforeDiscount() . '</td>
                            <td class="p-3">' . $ord->getTotal() . '</td>
                            <td class="p-3 font-bold ' . $statusColor . '">' . $ord->getOrderStatus() . '</td>
                            <td class="p-3 font-bold" onclick="viewOrderDetail(' . $ord->getId() . ',' . $ord->getDateOfOrder() . ')"><i class="fa-solid fa-eye text-blue-500" data-id="' . $ord->getId() . '"></i></td>
                            <td class="p-3"> 
                            <select name="" id="" onchange="changeColor(this)" class="font-bold text-blue-500 bg-transparent" data-id="' . $ord->getId() . '">
                                <option value="" selected disabled class="font-bold text-blue-500 ">EDIT</option>
                                <option value="CANCELLED"  class="text-red-500 font-bold"  >CANCELLED</option>
                                <option value="COMPLETED" class="text-green-500 bont-bold">COMPLETED</option>
                                </select>
                            </td>

                            </tr>'

                            );
                            $i++;
                        }
                        ?>
                        <script>
                            function changeColor(e) {
                                let color = "text-blue-500";
                                e.classList.remove(e.classList[1]);
                                if (e.value == "CANCELLED") {
                                    e.classList.add("text-red-500");
                                } else if (e.value == "COMPLETED") {
                                    e.classList.add("text-green-500");
                                }
                                alert("Đổi trạng thái thành công");
                                $.ajax({
                                    url: "include/Order/ChangeOrderStatus.php",
                                    method: "POST",
                                    data: JSON.stringify({
                                        "id": e.getAttribute("data-id"),
                                        "status": e.value,
                                    }),
                                    success: function(response) {
                                        LoadOrder();
                                    }
                                });
                            }

                            function LoadOrder() {
                                console.log("asd");
                                $.ajax({
                                    url: "include/Order/LoadOrder.php",
                                    success: function(data) {
                                        // console.log(data);
                                        document.getElementById("table_order_body").innerHTML = data;
                                    }
                                })
                            }

                            function turnOffIngredientOverlay() {
                                document.getElementById("overlay_order").remove();
                                document.getElementById("div_order_detail").remove();
                            }

                            function viewOrderDetail(id, date) {
                                console.log(id);
                                $.ajax({
                                    url: "include/Order/ViewOrderDetail.php",
                                    data: JSON.stringify({
                                        "id": id
                                    }),
                                    method: "POST",
                                    success: function(data) {
                                        let orderMain = document.getElementById("order_main");
                                        orderMain.insertAdjacentHTML("beforeend",
                                            `<div class=" z-50 flex flex-col justify-center w-2/3 pb-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded-md shadow-lg" id="div_order_detail">
    <h1 class=" text-center font-bold text-md">Chi tiết đơn hàng </h1>

    <p class="text-sm">Mã đơn hàng: ${id}</p>
    <p class="text-sm">Ngày đặt: ${date}</p>
    <div class="border-0 border-black rounded-md overflow-hidden mt-3">
        <div class=" overflow-y-auto text-[0.7rem]" style="height: calc(97vh - 150px);">
            <table class="table-auto w-full border-collapse text-center" id="table_order">
                <thead class="bg-gray-100 sticky top-0 text-center ">
                    <tr class="text-center">
                        <th class=" p-2">Product ID</th>
                        <th class=" p-2">Name</th>
                        <th class=" p-2">Quantity</th>
                        <th class=" p-2">Price</th>
                        <th class=" p-2">Total</th>
                    </tr>
                </thead>
                <tbody id="table_detail_body">
                </tbody>   
            </table>
        </div>
    </div>
</div>
<div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40" id="overlay_order" onclick="turnOffIngredientOverlay()"></div>`);
                                        document.getElementById("table_detail_body").innerHTML = data;
                                    }
                                });

                            }
                        </script>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- <div class=" z-50 flex flex-col justify-center w-2/3 pb-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded-md shadow-lg" id="div_ingredient_add">
    <h1 class=" text-center font-bold text-md">Chi tiết đơn hàng </h1>

    <p class="text-sm">Mã đơn hàng: <span></span></p>
    <p class="text-sm">Ngày đặt: <span></span></p>
    <div class="border-0 border-black rounded-md overflow-hidden mt-3">
        <div class=" overflow-y-auto text-[0.7rem]" style="height: calc(97vh - 150px);">
            <table class="table-auto w-full border-collapse text-center" id="table_order">
                <thead class="bg-gray-100 sticky top-0 text-center ">
                    <tr class="text-center">
                        <th class=" p-2">Product ID</th>
                        <th class=" p-2">Name</th>
                        <th class=" p-2">Quantity</th>
                        <th class=" p-2">Price</th>
                        <th class=" p-2">Total</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40" id="overlay_ingredient" onclick="turnOffIngredientOverlay()"></div> -->