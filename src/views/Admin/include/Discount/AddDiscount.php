<body id="addVoucher" class="bg-gray-50 min-h-screen relative ">

    <form method="post" id='voucherForm'>
        <!-- Container chính -->
        <div class="max-w-5xl mx-auto p-4 md:p-6 h-[700px] overflow-y-scroll">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 mb-2">
                <a href="#" class="hover:text-gray-700">Trang chủ</a>
                <span class="mx-1">/</span>
                <a href="#" class="hover:text-gray-700">Khuyến mãi</a>
                <span class="mx-1">/</span>

                <span class="text-gray-700">Thêm khuyến mãi</span>
            </nav>

            <!-- Tiêu đề trang -->
            <h1 class="text-2xl font-bold text-gray-700 mb-6">Tạo khuyến mãi</h1>

            <!-- Form chính -->
            <form class="space-y-8">
                <!-- BASIC INFORMATION -->
                <div class="bg-white p-6 rounded-md shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Thông tin cơ bản</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Thêm mô tả của khuyến mãi ở đây
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Voucher Name -->
                        <div>
                            <label for="voucherName" class="block text-sm font-medium text-gray-700 mb-1">
                                Tên chương trình khuyến mãi
                            </label>
                            <input type="text" id="voucherName" name="voucherName" placeholder="e.g. JulyPayday"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>

                        <!-- Voucher Percent -->
                        <div class="relative">
                            <label for="percent" class="block text-sm font-medium text-gray-700 mb-1">
                                Phần trị khuyến mãi(%)
                            </label>
                            <input type="text" id="percent" name="percent" placeholder="10"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <div id="percentError" class="mt-1 text-xs text-red-500 hidden">
                                Vui lòng nhập số dương hợp lệ.
                            </div>
                        </div>
                        <div class="relative">
                            <label for="requiredAmount" class="block text-sm font-medium text-gray-700 mb-1">
                                Số tiền yêu cầu để được khuyến mãi
                            </label>
                            <input type="text" id="requiredAmount" name="requiredAmount" placeholder="1000"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <div id="requiredAmountError" class="mt-1 text-xs text-red-500 hidden">
                                Vui lòng nhập số dương hợp lệ.
                            </div>
                        </div>
                    </div>

                    <!-- Chọn loại khách hàng (All Customer / Specific Customer) -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ai có thể được sử dụng khuyến mãi
                        </label>
                        <div class="flex items-center space-x-4">
                            <!-- All Customer -->
                            <label class="inline-flex items-center group cursor-pointer">
                                <input type="radio" name="customerType" value="all" checked
                                    class="form-radio text-orange-500 focus:ring-blue-500" />
                                <span class="ml-2 text-gray-700">Tất cả khách hànghàng</span>
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


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                        <!-- Start & End Time -->
                        <div>
                            <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">
                                Ngày bắt đầu và ngày kết thúc
                            </label>
                            <div class="flex space-x-2">
                                <input type="date" id="startTime" name="startTime"
                                    class="block w-1/2 border border-gray-300 rounded-md py-2 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                <input type="date" id="endTime" name="endTime"
                                    class="block w-1/2 border border-gray-300 rounded-md py-2 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                        </div>


                    </div>
                </div>
                <!-- PRODUCT TYPE -->
                <div class="bg-white p-6 rounded-md shadow-sm mb-2">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Loại sản phẩm</h2>

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
                        Hủy
                    </button>

                    <button type="submit" name="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                        Lưu khuyến mãi
                    </button>

                </div>
            </form>
        </div>
    </form>

    <script>
        document.getElementById("voucherForm").addEventListener("submit", function(event) {

            event.preventDefault(); // Ngăn form gửi dữ liệu theo cách mặc định


            let voucherName = document.getElementById(`voucherName`);
            if (voucherName.value.trim() == "" || voucherName.value.trim() == null) {
                voucherName.focus();

                return;
            }

            // Lấy giá trị các input
            let percent = document.getElementById("percent").value.trim();

            // Kiểm tra percent (chỉ nhận số dương)
            if (!/^\d+(\.\d+)?$/.test(percent) || parseFloat(percent) <= 0 || percent > 100 || percent == null ||
                percent == "") {
                document.getElementById("percent").focus();

                document.getElementById("percent").addEventListener('focus', () => {
                    const errorEl = document.getElementById('percentError');
                    if (errorEl) {
                        errorEl.classList.remove('hidden');
                    }
                });


                return
            }

            let requiredAmount = document.getElementById("requiredAmount").value.trim();

            // Kiểm tra Required Amount (chỉ nhận số dương)
            if (!/^\d+(\.\d+)?$/.test(requiredAmount) || parseFloat(requiredAmount) <= 0 || requiredAmount ==
                null || requiredAmount == "") {
                document.getElementById("requiredAmount").focus();

                document.getElementById("requiredAmount").addEventListener('focus', () => {
                    const errorEl = document.getElementById('requiredAmountError');
                    if (errorEl) {
                        errorEl.classList.remove('hidden');
                    }
                });

                return
            }


            let startTime = document.getElementById("startTime").value.trim();
            let endTime = document.getElementById("endTime").value.trim();

            // Kiem tra startTime va endTime
            if (startTime == "") {
                document.getElementById("startTime").focus();

                return;
            }

            if (endTime == "") {
                document.getElementById("endTime").focus();

                return;
            }

            // Kiem tra startTime va endTime
            if (startTime > endTime) {
                document.getElementById("startTime").focus();

                return;
            }

            // Validate dữ liệu ở đây nếu cần, ví dụ như đã kiểm tra số dương cho percent và requiredAmount
            let formData = new FormData(this);

            const element = document.createElement('div');

            fetch("./php/Discount/addDiscount.php", {
                    method: "POST",
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
                        alert("Thêm khuyến mãi thành công");
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    </script>
</body>