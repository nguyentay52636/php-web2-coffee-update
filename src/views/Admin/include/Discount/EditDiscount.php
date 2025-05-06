<?php
include __DIR__ . "/../../../../controllers/DiscountController.php";
// include __DIR__ ."/../../../../models/Discount.php";

$id = $_GET['id'];

$discountController = new DiscountController();

$discount = $discountController->getDiscountById($id);
if ($discount) {
    $discountId = $discount->getId();
    $voucherName  = $discount->getDiscountName();
    $percent    = $discount->getDiscountPercent();
    $requiredAmount = $discount->getRequirement();
    $startTime = $discount->getStartDate();
    $endTime  = $discount->getEndDate();
} else {
    echo "Khong tim thay discount";
    exit;
}


$startTimeFormatted = date('Y-m-d', strtotime($startTime));
$endTimeFormatted = date('Y-m-d', strtotime($endTime));



// Tạo mảng dữ liệu cần lưu
$discount = new Discount();
$discount->setDiscountName($voucherName);
$discount->setDiscountPercent($percent);
$discount->setRequirement($requiredAmount);
$discount->setStartDate($startTimeFormatted);
$discount->setEndDate($endTimeFormatted);



?>

<body id="addVoucher" class="bg-gray-50 min-h-screen relative ">

    <form method="post" id='voucherForm'>
        <input type="hidden" name="discountId" value="<?php echo $discountId; ?>">
        <!-- Container chính -->
        <div class="max-w-5xl mx-auto p-4 md:p-6 h-[700px] overflow-y-scroll">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 mb-2">
                <a href="#" class="hover:text-gray-700">Home</a>
                <span class="mx-1">/</span>
                <a href="#" class="hover:text-gray-700">Discounts</a>
                <span class="mx-1">/</span>
                <a href="#" class="hover:text-gray-700">Voucher Discount</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700">Edit</span>
            </nav>

            <!-- Tiêu đề trang -->
            <h1 class="text-2xl font-bold text-gray-700 mb-6">Edit Voucher Discount</h1>

            <!-- Form chính -->
            <form class="space-y-8">
                <!-- BASIC INFORMATION -->
                <div class="bg-white p-6 rounded-md shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Basic Information</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Add the description of the voucher here.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Voucher Name -->
                        <div>
                            <label for="voucherName" class="block text-sm font-medium text-gray-700 mb-1">
                                Voucher Name
                            </label>
                            <input type="text" id="voucherName" name="voucherName" placeholder="e.g. JulyPayday"
                                value="<?php echo htmlspecialchars($voucherName); ?>"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>

                        <!-- Voucher Percent -->
                        <div class="relative">
                            <label for="percent" class="block text-sm font-medium text-gray-700 mb-1">
                                Percent (%)
                            </label>
                            <input type="text" id="percent" name="percent" placeholder="10"
                                value="<?php echo htmlspecialchars($percent); ?>"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <div id="percentError" class="mt-1 text-xs text-red-500 hidden">
                                Vui lòng nhập số dương hợp lệ.
                            </div>
                        </div>
                        <div class="relative">
                            <label for="requiredAmount" class="block text-sm font-medium text-gray-700 mb-1">
                                Required Amount ($)
                            </label>
                            <input type="text" id="requiredAmount" name="requiredAmount" placeholder="1000"
                                value="<?php echo htmlspecialchars($requiredAmount); ?>"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <div id="requiredAmountError" class="mt-1 text-xs text-red-500 hidden">
                                Vui lòng nhập số dương hợp lệ.
                            </div>
                        </div>
                    </div>

                    <!-- Chọn loại khách hàng (All Customer / Specific Customer) -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Who can use this voucher?
                        </label>
                        <div class="flex items-center space-x-4">
                            <!-- All Customer -->
                            <label class="inline-flex items-center group cursor-pointer">
                                <input type="radio" name="customerType" value="all" checked
                                    class="form-radio text-orange-500 focus:ring-blue-500" />
                                <span class="ml-2 text-gray-700">All Customer</span>
                                <!-- Tooltip -->
                                <div
                                    class="relative ml-2 group-hover:opacity-100 group-hover:scale-100 transition transform origin-left opacity-0 scale-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 cursor-pointer"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 8a6 6 0 11-12 0 6 6 0 0112 0zM9 4a1 1 0 102 0 1 1 0 00-2 0zm1 3a1 1 0 00-1 1v2a1 1 0 002 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <!-- Nội dung tooltip -->
                                    <div
                                        class="absolute top-5 left-0 bg-gray-800 text-white text-xs rounded py-1 px-2 w-44">
                                        Voucher will be displayed on the website and can be used by all visitors.
                                    </div>
                                </div>
                            </label>


                        </div>
                    </div>
                </div>

                <!-- ACTIVE PERIOD -->
                <div class="bg-white p-6 rounded-md shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Active Period</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Set the discount period and time range.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                        <!-- Start & End Time -->
                        <div>
                            <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">
                                Start & End Time
                            </label>
                            <div class="flex space-x-2">
                                <input type="date" id="startTime" name="startTime"
                                    value="<?php echo htmlspecialchars($startTime); ?>"
                                    class="block w-1/2 border border-gray-300 rounded-md py-2 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                                <input type="date" id="endTime" name="endTime"
                                    value="<?php echo htmlspecialchars($endTime); ?>"
                                    class="block w-1/2 border border-gray-300 rounded-md py-2 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                        </div>


                    </div>
                </div>
                <!-- PRODUCT TYPE -->
                <div class="bg-white p-6 rounded-md shadow-sm mb-2">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Product Type</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Choose the product range to apply this voucher.
                    </p>
                    <div class="flex items-center space-x-6">
                        <label class="inline-flex items-center">
                            <input type="radio" name="productType" value="all"
                                class="form-radio text-orange-500 focus:ring-blue-500" checked />
                            <span class="ml-2 text-gray-700">All Product</span>
                        </label>
                        <!-- <label class="inline-flex items-center">
                            <input type="radio" name="productType" value="specific"
                                class="form-radio text-orange-500 focus:ring-blue-500" />
                            <span class="ml-2 text-gray-700">Specific Product</span>
                        </label> -->
                    </div>
                </div>

                <!-- Nút điều hướng -->
                <div class="flex items-center justify-end space-x-4">
                    <button onclick="closeAddDiscountModal()" type="button" class="text-gray-500 hover:text-gray-700">
                        Cancel
                    </button>

                    <button type="submit" name="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                        Save changes
                    </button>

                </div>
            </form>
        </div>
    </form>


    <script>
        document.getElementById("voucherForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Ngăn form gửi dữ liệu theo cách mặc định
            let isValid = true;
            let voucherName = document.getElementById(`voucherName`);
            if (voucherName.value.trim() == "" || voucherName.value.trim() == null) {
                voucherName.focus();
                isValid = false;
                return;
            }

            // Lấy giá trị các input
            let percent = document.getElementById("percent").value.trim();

            // Kiểm tra percent (chỉ nhận số dương)
            if (!/^\d+(\.\d+)?$/.test(percent) || parseFloat(percent) <= 0) {
                document.getElementById("percent").focus();

                document.getElementById("percent").addEventListener('focus', () => {
                    const errorEl = document.getElementById('percentError');
                    if (errorEl) {
                        errorEl.classList.remove('hidden');
                    }
                });

                isValid = false;
                return
            }

            let requiredAmount = document.getElementById("requiredAmount").value.trim();

            // Kiểm tra Required Amount (chỉ nhận số dương)
            if (!/^\d+(\.\d+)?$/.test(requiredAmount) || parseFloat(requiredAmount) <= 0) {
                document.getElementById("requiredAmount").focus();

                document.getElementById("requiredAmount").addEventListener('focus', () => {
                    const errorEl = document.getElementById('requiredAmountError');
                    if (errorEl) {
                        errorEl.classList.remove('hidden');
                    }
                });

                isValid = false;
                return
            }


            let startTime = document.getElementById("startTime").value.trim();
            let endTime = document.getElementById("endTime").value.trim();

            // Kiem tra startTime va endTime
            if (startTime == "") {
                document.getElementById("startTime").focus();
                isValid = false;
                return;
            }

            if (endTime == "") {
                document.getElementById("endTime").focus();
                isValid = false;
                return;
            }

            // Kiem tra startTime va endTime
            if (startTime > endTime) {
                document.getElementById("startTime").focus();
                isValid = false;
                return;
            }


            // Nếu dữ liệu không hợp lệ, chặn form gửi đi
            if (!isValid) {
                console.log("Invalid form data");
                event.preventDefault();
            }


            // Validate dữ liệu ở đây nếu cần, ví dụ như đã kiểm tra số dương cho percent và requiredAmount
            let formData = new FormData(this);
            const element = document.createElement('div');
            fetch('./php/Discount/editDiscount.php', {
                    method: 'POST',
                    body: formData
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
                        alert("Sửa giảm giá thành công");
                        // Thông báo cập nhật thành công (có thể hiển thị thông báo toast, modal, ...)


                        console.log(data.message);
                    } else {
                        alert("Sửa giảm giá thất bại")
                        // Thông báo cập nhật thất bại



                        // Thông báo lỗi
                        console.error(data.message);
                    }

                    setTimeout(() => {
                        document.body.removeChild(element);
                    })
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra khi cập nhật');
                });
        });
    </script>

</body>