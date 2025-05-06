<?php
include __DIR__ . "/../../../../controllers/ProducerController.php";
$producerController = new ProducerController();
?>
<div class="flex flex-col  gap-5 bg-white h-screen border-0 rounded-md" id="producer_main">
    <div class="">
        <h1 class="font-bold text-center pt-2">Nhà cung cấp </h1>
    </div>
    <div class=" bg-white flex justify-between">
        <div class="px-5">
            <div class="flex  border rounded-sm bg-black-500 ">
                <input type="text" placeholder="Search" class="border-0 p-2 focus:outline-none" id="input_search">
                <button class="text-sm px-4 bg-gray-200 w-full" onclick="sortProducer()">
                    <i class="fas fa-search text-gray-500"></i>
                </button>
            </div>
        </div>

        <div class=" grid grid-cols-3 gap-3">
            <select name="" id="select_filter" class="px-3 py-2  me-2 mb-2 bg-gray-100 border-0 rounded-md text-black"
                onchange="sortProducer()">
                <option value="" disabled selected>Sort by</option>
                <option value="id">Id</option>
                <option value="name">Name</option>
            </select>
            <button
                class="focus:outline-none text-white bg-orange-500  font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2  dark:hover:opacity-75 "
                onclick="sortProducer()" value="" id="btn_sort">Sort &nbsp;</button>
            <button type="button"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 "
                onclick="displayAddProducer()">Thêm</button>
            <script>
                function turnOffOverlayProducer() {
                    document.getElementById("overlay_producer").remove();
                    document.getElementById("div_producer_add").remove();
                }

                function displayAddProducer() {
                    let producerMain = document.getElementById("producer_main");
                    producerMain.insertAdjacentHTML("beforeend",
                        `   
     <div class="z-50 flex flex-col justify-center w-1/2 pb-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded-md shadow-lg" id="div_producer_add">
        <h1 class="text-center font-bold text-md">Thêm nhà cung cấp</h1>
        <form action="" class="grid grid-rows-5 gap-3">
            <div class="grid grid-rows-2">
                <label for="">Tên nhà cung cấp</label>
                <input type="text" name="" class="border-2 border-dark rounded-md h-[30px]" id="input_name_producer">
            </div>
            <div class="grid grid-rows-2">
                <label for="">Địa chỉ</label>
                <input type="text" name="" class="border-2 border-dark rounded-md h-[30px]" id="input_address_producer">
            </div>

            <div class="grid grid-rows-2">
                <label for="">Số điện thoại</label>
                <input type="tel" id="input_phone_producer" class="border-2 border-dark rounded-md h-[30px]">

            </div>
        </form>
        <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700" onclick="addProducer()">Thêm</button>
    </div>
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40" id="overlay_producer" onclick="turnOffOverlayProducer()"></div>`
                    );
                }

                function ValidateUSPhoneNumber(phoneNumber) {
                    var regExp = /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}/;
                    var phone = phoneNumber.match(regExp);
                    if (phone) {
                        return true;
                    }
                    return false;
                }

                function addProducer() {
                    let name = document.getElementById("input_name_producer");
                    let address = document.getElementById("input_address_producer");
                    let phone = document.getElementById("input_phone_producer");
                    if (!ValidateUSPhoneNumber(phone.value)) {
                        alert("Phải có định dạng xxx-xxx-xxxxx !");
                        turnOffOverlayProducer();

                        return;
                    }
                    $.ajax({
                        url: "include/Producer/AddProducer.php",
                        method: "POST",
                        data: JSON.stringify({
                            "name": name.value,
                            "address": address.value,
                            "phone": phone.value,
                        }),
                        success: function(data) {
                            alert("Thêm thành công!");
                            LoadTable();
                            turnOffOverlayProducer();
                        }
                    })
                }
            </script>
        </div>
        <script>
            function sortProducer() {
                let search = document.getElementById("input_search");
                let filter = document.getElementById("select_filter");
                let btn_sort = document.getElementById("btn_sort");
                $.ajax({
                    url: "include/Producer/SortProducer.php",
                    method: "POST",
                    data: JSON.stringify({
                        'search': search.value,
                        'filter': filter.value,
                        'sortBy': btn_sort.value,
                    }),
                    success: function(data) {
                        document.getElementById("table_producer_body").innerHTML = data;
                    }
                });
                if (btn_sort.value == "" || btn_sort.value == "ASC") {
                    btn_sort.innerHTML = `Sort &nbsp;<i class="fa-solid fa-down-long"></i>`;
                    btn_sort.value = "DESC";
                } else if (btn_sort.value = "DESC") {
                    btn_sort.innerHTML = `Sort &nbsp;<i class="fa-solid fa-up-long"></i>`;
                    btn_sort.value = "ASC";
                }
            }
        </script>
    </div>
    <div class="px-3">
        <div class="border-0 border-black rounded-md overflow-hidden ">
            <div class=" overflow-y-auto text-[0.8rem]" style="height: calc(97vh - 150px);">
                <table class="table-auto w-full border-collapse ">
                    <thead class="bg-gray-100 sticky top-0 ">
                        <tr>
                            <th class="p-2 ">Mã</th>
                            <th class="p-2 ">Tên</th>
                            <th class="p-2 ">Địa chỉ NCC</th>
                            <th class="p-2 ">SDT</th>
                            <th class="p-2 ">&nbsp;</th>
                            <th class="p-2 ">&nbsp;</th>

                        </tr>
                    </thead>
                    <tbody class="text-center" id="table_producer_body">
                        <!-- Generate a lot of rows to test scrolling -->
                        <?php
                        $producers = $producerController->getAllProducers();
                        $i = 1;
                        foreach ($producers as $pr) {
                            $rowColor = "bg-white";
                            if (!($i & 1)) $rowColor = "bg-gray-200";

                            echo '
                        <tr class="' . $rowColor . '">
                            <td class="p-3">' . $pr->getId() . '</td>
                            <td class="p-3">' . $pr->getProducerName() . '</td>
                            <td class="p-3">' . $pr->getAddress() . '</td>
                            <td class="p-3">' . $pr->getPhone() . '</td>
                            <td class="p-3">
                                <button type="button" class="text-blue-700   font-medium rounded-lg text-sm px-1 py-1 me-1 mb-1    focus:outline-none " onclick="editProducer(\'' . addslashes($pr->getId()) . '\', \'' . addslashes($pr->getProducerName()) . '\', \'' . addslashes($pr->getAddress()) . '\', \'' . addslashes($pr->getPhone()) . '\')"
>Sửa</button></td>
                            <td class="p-3">
                            <button type="button" class="focus:outline-none text-red-500  font-medium rounded-lg text-sm px-1 py-1 me-1 mb-1 ">Xóa</button></td> 

                        </tr>
                            ';
                            $i++;
                        }

                        ?>

                    </tbody>
                </table>
                <script>
                    function LoadTable() {
                        $.ajax({
                            url: "include/Producer/LoadProducer.php",
                            method: "GET",
                            success: function(data) {
                                document.getElementById("table_producer_body").innerHTML = data;
                            }
                        })
                    }

                    function editProducer(id, name, address, phone) {
                        let producerMain = document.getElementById("producer_main");
                        producerMain.insertAdjacentHTML("beforeend",
                            `   
     <div class="z-50 flex flex-col justify-center w-1/2 pb-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded-md shadow-lg" id="div_producer_add">
        <h1 class="text-center font-bold text-md">Sửa nhà cung cấp</h1>
        <form action="" class="grid grid-rows-5 gap-3">
            <div class="grid grid-rows-2">
                <label for="">Tên nhà cung cấp</label>
                <input type="text" name="" class="border-2 border-dark rounded-md h-[30px]" id="input_name_producer" value=${name}>
            </div>
            <div class="grid grid-rows-2">
                <label for="">Địa chỉ</label>
                <input type="text" name="" class="border-2 border-dark rounded-md h-[30px]" id="input_address_producer" value=${address}>
            </div>

            <div class="grid grid-rows-2">
                <label for="">Số điện thoại</label>
                <input type="tel" id="input_phone_producer" class="border-2 border-dark rounded-md h-[30px]" value=${phone}>

            </div>
        </form>
        <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700" onclick="editProducerDatabase(${id})">Sửa</button>
    </div>
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40" id="overlay_producer" onclick="turnOffOverlayProducer()"></div>`
                        );

                    }

                    function editProducerDatabase(id) {
                        let name = document.getElementById("input_name_producer");
                        let address = document.getElementById("input_address_producer");
                        let phone = document.getElementById("input_phone_producer");
                        if (!ValidateUSPhoneNumber(phone.value)) {
                            alert("Phải có định dạng xxx-xxx-xxxxx !");
                            turnOffOverlayProducer();

                            return;
                        }
                        $.ajax({
                            url: "include/Producer/EditProducer.php",
                            method: "POST",
                            data: JSON.stringify({
                                "id": id,
                                "name": name.value,
                                "address": address.value,
                                "phone": phone.value,
                            }),
                            success: function(data) {
                                alert("Sửa thành công!");
                                LoadTable();
                                turnOffOverlayProducer();
                            }
                        })
                    }
                </script>
            </div>
        </div>
    </div>

</div>