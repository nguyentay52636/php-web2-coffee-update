<?php
include __DIR__ . "/../../../../controllers/UnitController.php";
$unitController = new UnitController();
$units = $unitController->getAllUnits();

include __DIR__ . "/../../../../controllers/IngredientController.php";
$ingredientController = new IngredientController();
$ingredients = $ingredientController->getAllIngredients();



?>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Thêm Công Thức Pha Chế</h2>

        <form id="recipe-form" class="space-y-6">
            <!-- Tên công thức -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tên công thức</label>
                <input type="text" name="recipe_name"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required />
            </div>

            <!-- Mô tả -->
            <!-- <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Mô tả</label>
                <textarea name="description" rows="3"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div> -->

            <!-- Nguyên liệu -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nguyên liệu</label>
                <div id="ingredients" class="space-y-2   w-full  h-[150px] overflow-auto">
                    <!-- Dòng nguyên liệu -->
                    <div class="flex space-x-2 ">

                        <select name="ingredient_name[]" class="w-64 border rounded-md px-2 py-1" required>
                            <option value="" disabled selected>-- Chọn nguyên liệu --</option>
                            <?php

                            foreach ($ingredients as $ingredient) {
                                echo '<option value="' . $ingredient->getId() . '">' . $ingredient->getIngredientName() . '</option>';
                            }

                            ?>

                        </select>

                        <input type="number" name="ingredient_quantity[]" placeholder="Số lượng"
                            class="w-24 border rounded-md px-2 py-1" min="1" required />



                        <select name=" ingredient_unit[]" id="unit" class="w-64 border rounded-md px-2 py-1" required>
                            <option value="" disabled selected>-- Chọn đơn vị --</option>
                            <?php
                            foreach ($units as $unit) {
                                echo '<option value="' . $unit->getId() . '">' . $unit->getType() . '</option>';
                            }
                            ?>
                        </select>
                        <button type="button" onclick="removeIngredient(this)"
                            class="text-red-600 hover:underline text-sm bg-red-100 rounded-md px-2 py-1">X</button>
                    </div>
                </div>

                <!-- Nút thêm dòng nguyên liệu -->
                <button type="button" onclick="addIngredient()" class="mt-3 text-blue-600 hover:underline text-sm">+
                    Thêm nguyên liệu</button>
            </div>

            <!-- Nút lưu -->
            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">Lưu công
                    thức</button>
            </div>
        </form>
    </div>

    <!-- Script thêm dòng nguyên liệu -->
    <script>
        document.getElementById("recipe-form").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            const element = document.createElement("div"); // Container cho thông báo

            fetch("./php/Recipe/addRecipe.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(text => {
                    console.log("Dữ liệu nhận được:", text);
                    try {
                        const jsonData = JSON.parse(text.trim());
                        return jsonData;
                    } catch (error) {
                        console.error("Lỗi khi parse JSON:", error);
                    }
                })
                .then(data => {
                    if (!data) return; // Nếu JSON parse lỗi

                    if (data.success) {


                        alert("Them cong thuc thanh cong")

                    } else {

                        // console.error(data.message);
                    }

                    document.body.appendChild(element);
                    setTimeout(() => {
                        element.remove();
                    }, 3000);
                })
                .catch(error => {
                    console.error("Lỗi gửi dữ liệu:", error);
                });
        });




        function removeIngredient(button) {
            const ingredientDiv = button.parentNode;
            ingredientDiv.remove();
        }

        function addIngredient() {
            const ingredientsDiv = document.getElementById("ingredients");

            const div = document.createElement("div");
            div.className = "flex space-x-2";

            div.innerHTML = `
        <select name="ingredient_name[]" class="w-64 border rounded-md px-2 py-1" required>
        <option value="" disabled selected>-- Chọn nguyên liệu --</option>
                            <?php
                            foreach ($ingredients as $ingredient) {
                                echo '<option value="' . $ingredient->getId() . '">' . $ingredient->getIngredientName() . '</option>';
                            }

                            ?>

                        </select>
        <input type="number" name="ingredient_quantity[]" placeholder="Số lượng" class="w-24 border rounded-md px-2 py-1" required />
        <select name="ingredient_unit[]" id="unit" class="w-64 border rounded-md px-2 py-1" required>
        <option value="" disabled selected>-- Chọn đơn vị --</option>
                            <?php
                            foreach ($units as $unit) {
                                echo '<option value="' . $unit->getId() . '">' . $unit->getType() . '</option>';
                            }
                            ?>
                        </select>
        <button type="button" onclick="removeIngredient(this)" class="text-red-600 hover:underline text-sm bg-red-100 rounded-md px-2 py-1">X</button>
      `;
            ingredientsDiv.appendChild(div);
        }

        // Xử lý submit form (demo)
    </script>
</body>

</html>