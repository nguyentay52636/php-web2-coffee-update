<?php
include __DIR__ . "/../../../../controllers/UnitController.php";

$unitController = new UnitController();

$unitId = $_GET['id'];

$unit = $unitController->getUnitById($unitId);



?>

<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Sửa Đơn Vị Tính</h2>

        <form id="edit-unit-form" class="space-y-6">

            <input class="hidden" type="text" name="unit_id" value="<?php echo $unit->getId(); ?>">
            <!-- Tên đơn vị -->
            <div>
                <label for="unit_name" class="block text-sm font-medium text-gray-600 mb-1">Tên đơn vị</label>
                <input type="text" id="unit_name" name="unit_name" value="<?php echo $unit->getType(); ?>"
                    placeholder="VD: Cup, ml, ..." required
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Mô tả (với giới hạn 255 ký tự) -->


            <div>
                <label for="unit_description" class="block text-sm font-medium text-gray-600 mb-1">
                    Mô tả (tối đa 255 ký tự)
                </label>
                <textarea id="unit_description" name="unit_description" rows="3" maxlength="255"
                    placeholder="Nhập mô tả cho đơn vị" class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500
                    text-black"><?php echo $unit->getDescription(); ?>
                </textarea>
            </div>

            <!-- Nút cập nhật -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none">
                    Cập nhật đơn vị

                </button>
            </div>
        </form>
    </div>

    <!-- Script demo xử lý submit form -->
    <script>
        document.getElementById("edit-unit-form").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            fetch("./php/Unit/updateUnit.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Data received:", data);
                    try {
                        const jsonData = JSON.parse(data.trim());
                        return jsonData;
                        console.log("Parsed JSON:", jsonData);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload the page
                    } else {
                        alert(data.message);
                    }
                    window.loocation.href = "http://localhost/Web_Advanced_Project/src/views/Admin/index.php?pages=recipe";
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    </script>
</body>

</html>