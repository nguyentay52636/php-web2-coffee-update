<?php
include_once __DIR__ . "/../../../../controllers/OrderDetailController.php";
include_once __DIR__ . "/../../../../controllers/UserController.php";
include_once __DIR__ . "/../../../../controllers/OrderController.php";
$orderController = new OrderController();
$orders;
?>
<div id="statistic" class="flex  h-[100vh] w-full">
    <div class="grid grid-rows-[6fr_4fr] gap-2 w-full">
        <div class="flex w-full">
            <div class="grid grid-cols-[6fr_3fr] gap-2 w-full  h-full">
                <div class="border-0 bg-white rounded-md">
                    <canvas id="lineChart" class=" h-full w-full" role="image">Hi </canvas>
                    <script>
                        $(function() {
                            let lineChartInstance = null;

                            function fetchTwoYears(year1, year2) {
                                // fire off two AJAX calls in parallel
                                const req1 = $.ajax({
                                    url: "include/Statistic/GetChartDataStatistic.php",
                                    method: "POST",
                                    contentType: "application/json",
                                    dataType: "json",
                                    data: JSON.stringify({
                                        year: year1
                                    })
                                });
                                const req2 = $.ajax({
                                    url: "include/Statistic/GetChartDataStatistic.php",
                                    method: "POST",
                                    contentType: "application/json",
                                    dataType: "json",
                                    data: JSON.stringify({
                                        year: year2
                                    })
                                });

                                $.when(req1, req2).done(function(res1, res2) {

                                    const data1 = res1[0];
                                    const data2 = res2[0];

                                    const sumRevenue = (revenueArray) => {
                                        return revenueArray.reduce((sum, value) => sum + (isNaN(value) ? 0 : value), 0);
                                    }

                                    // Sum the revenues of both years
                                    const totalRevenueYear1 = sumRevenue(data1.revenue); // Summing the array for year 1
                                    const totalRevenueYear2 = sumRevenue(data2.revenue);
                                    document.getElementById('revenueYear1').innerText = `${Math.round(totalRevenueYear1).toLocaleString()} VND`;
                                    document.getElementById('revenueYear2').innerText = `${Math.round(totalRevenueYear2).toLocaleString()} VND`;
                                    // Tính toán tỷ lệ tăng trưởng
                                    let growth = ((totalRevenueYear1 - totalRevenueYear2) / totalRevenueYear1) * 100; // Chuyển công thức để giảm so với năm 1

                                    // Cập nhật giá trị tăng trưởng
                                    const growthElement = document.querySelector("#growth_p");

                                    // Xóa các lớp cũ trước khi thêm lớp mới
                                    growthElement.classList.remove("text-[#32ff7e]", "text-red-500", "text-white");


                                    // Tính toán sự tăng trưởng
                                    if (growth > 0) {
                                        // Tăng trưởng dương (doanh thu năm 2 lớn hơn năm 1)
                                        growthElement.innerText = `+${growth.toFixed(2)}%`;
                                        growthElement.classList.add("text-[#32ff7e]"); // Màu nền xanh cho tăng trưởng dương
                                    } else if (growth < 0) {
                                        // Tăng trưởng âm (doanh thu năm 2 thấp hơn năm 1)
                                        growthElement.innerText = `${growth.toFixed(2)}%`;
                                        growthElement.classList.add("text-red-500"); // Màu nền đỏ cho tăng trưởng âm
                                    } else {
                                        // Không có sự thay đổi (doanh thu bằng nhau)
                                        growthElement.innerText = `0%`;
                                        growthElement.classList.add("text-white"); // Màu nền xám cho không thay đổi
                                    }

                                    // build two‐line config for the chart
                                    const cfg = {
                                        type: 'line',
                                        data: {
                                            labels: data1.labels, // assuming both have same months
                                            datasets: [{
                                                    label: `Doanh thu ${data1.year}`,
                                                    data: data1.revenue,
                                                    borderColor: 'rgb(255, 99, 132)',
                                                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                                                    tension: 0.4
                                                },
                                                {
                                                    label: `Doanh thu ${data2.year}`,
                                                    data: data2.revenue,
                                                    borderColor: 'rgb(54, 162, 235)',
                                                    backgroundColor: 'rgba(54, 162, 235, 0.3)',
                                                    tension: 0.4
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                legend: {
                                                    position: 'top'
                                                },
                                                title: {
                                                    display: true,
                                                    text: `So sánh doanh thu ${data1.year} vs ${data2.year}`
                                                }
                                            }
                                        }
                                    };

                                    // destroy old chart & draw new
                                    const ctx = document.getElementById('lineChart').getContext('2d');
                                    if (lineChartInstance) lineChartInstance.destroy();
                                    lineChartInstance = new Chart(ctx, cfg);
                                });
                            }

                            // initial draw: only one year until a compare is chosen
                            const defaultYear = parseInt($('#yearSelect').val(), 10);
                            fetchTwoYears(defaultYear, defaultYear);

                            // when either select changes, and both have values, redraw
                            $('#yearSelect, #compareYearSelect').on('change', function() {
                                const y1 = parseInt($('#yearSelect').val(), 10);
                                const y2 = parseInt($('#compareYearSelect').val(), 10);
                                if (y1 && y2) {
                                    fetchTwoYears(y1, y2);
                                }
                            });
                        });
                    </script>

                </div>
                <div class="grid grid-rows-[auto_1fr_1fr] gap-2">

                    <div>
                        <select id="yearSelect" name="year" class="p-2 rounded-md border-gray border-2" onchange="changeChart()">

                            <?php
                            $oldestYear = null;
                            $orders = $orderController->getAllOrder();
                            foreach ($orders as $order) {
                                $dateString = $order->getDateOfOrder();
                                $year = (int) date('Y', strtotime($dateString));

                                if ($oldestYear === null || $year < $oldestYear) {
                                    $oldestYear = $year;
                                }
                            }

                            $currentYear = (int) date('Y');
                            for ($year = $currentYear; $year >= $oldestYear; $year--) {
                                echo "<option value=\"{$year}\" selected>{$year}</option>\n";
                            }
                            ?>
                            <script>
                                function changeChart() {
                                    const selectEl = document.getElementById("yearSelect");
                                    const selectedYear = parseInt(selectEl.value, 10); // Re‑fetch and redraw the chart for that year
                                    // fetchTwoYears()
                                }

                                // Attach the change handler
                                document.getElementById("yearSelect")
                                    .addEventListener("change", changeChart);
                            </script>

                        </select>
                        <select id="compareYearSelect" class="p-2 rounded-md border-gray-300 border-2">
                            <option value="" disabled selected>So sánh với...</option>
                            <?php for ($y = $currentYear; $y >= $oldestYear; $y--): ?>
                                <option value="<?= $y ?> " selected><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4"> <!-- Add grid layout to display side by side -->
                        <!-- First Doanh thu box for the first selected year -->
                        <div class="border-0 rounded-md bg-[#ff9f1a] flex flex-col p-3">
                            <p class="text-white text-3xl font-medium text-center">Doanh thu (Năm 1)</p>
                            <div class="flex items-center gap-2 p-2" style="flex-grow:1;">
                                <i class="fa-solid fa-dollar-sign text-5xl text-[#32ff7e]"></i>
                                <div class="flex items-center">
                                    <p id="revenueYear1" class="text-2xl font-sm text-[#3ae374]"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Second Doanh thu box for the second selected year -->
                        <div class="border-0 rounded-md bg-[#ff9f1a] flex flex-col p-3">
                            <p class="text-white text-3xl font-medium text-center">Doanh thu (Năm 2)</p>
                            <div class="flex items-center gap-2 p-2" style="flex-grow:1;">
                                <i class="fa-solid fa-dollar-sign text-5xl text-[#32ff7e]"></i>
                                <div class="flex items-center">
                                    <p id="revenueYear2" class="text-2xl font-sm text-[#3ae374]"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-0 rounded-md bg-[#7d5fff] p-3 text-white flex flex-col">
                        <p class="text-3xl font-medium text-center ">Tăng trưởng </p>
                        <div class="flex items-center gap-10 p-2" style="flex-grow:1;"><i
                                class="fa-solid fa-chart-line text-6xl"></i>
                            <div class="flex items-center">
                                <p class="text-5xl font-medium " id="growth_p"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="bg-white border-0 rounded-md grid grid-rows-[auto_1fr] gap-2 p-2">
            <div class="w-fit">
                <select class="rounded-md border-2 border-gray-300 px-2 py-1 text-sm" onchange="changeDiv()">
                    <option value="" disabled selected>Chọn năm để thống kê ...</option>
                  
                </select>
                <script>
                    function changeDiv() {
                        $.ajax({
                            url: "include/Statistic/GetOverallDataStatisic.php",
                            method: "GET",
                            successfunction(data) {

                            }
                        })
                    }
                </script>
            </div>

            <div>
                <p>hi</p>
            </div>
        </div> -->

    </div>

</div>