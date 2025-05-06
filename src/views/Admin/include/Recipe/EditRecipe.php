<?php
include __DIR__ . "/../../../../controllers/RecipeController.php";
include __DIR__ . "/../../../../controllers/RecipeDetailController.php";
include __DIR__ . "/../../../../controllers/UnitController.php";
include __DIR__ . "/../../../../controllers/IngredientController.php";

$recipeController = new RecipeController();
$recipeDetailController = new RecipeDetailController();

$recipeId = $_GET['id'];

$recipe = $recipeController->getRecipebyId($recipeId);
$recipeDetails = $recipeDetailController->getRecipeDetail($recipeId);
// echo $recipeDetails[0]->getIngredientId();

$ingredientController = new IngredientController();
$ingredients = $ingredientController->getAllIngredients();

$unitController = new UnitController();
$units = $unitController->getAllUnits();


// var_dump($units);
?>

<body class="bg-gray-100 p-6">
    <form id="edit-recipe-form" method="POST" action="updateRecipe.php" class="space-y-6">
        <input type="hidden" name="recipe_id" value="<?php echo $recipeId; ?>">

        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
            <!-- Tiêu đề trang -->
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Xem và Sửa Công Thức</h2>

            <!-- Form hiển thị và chỉnh sửa công thức -->

            <!-- Tên công thức -->
            <div>
                <label for="recipe_name" class="block text-sm font-medium text-gray-600 mb-1">
                    Tên công thức
                </label>
                <input type="text" id="recipe_name" name="recipe_name" value="<?php echo $recipe->getRecipeName(); ?>"
                    required class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Mô tả công thức -->
            <!-- <div>
                <label for="description" class="block text-sm font-medium text-gray-600 mb-1">
                    Mô tả (tối đa 255 ký tự)
                </label>
                <textarea id="description" name="description" rows="3" maxlength="255"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Nhập mô tả cho công thức">Đây là công thức Espresso cơ bản với hương vị đậm đà...</textarea>
            </div> -->

            <!-- Danh sách nguyên liệu -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Nguyên liệu
                </label>
                <div id="ingredients" class="space-y-2  h-[150px] overflow-auto">
                    <!-- Nguyên liệu 1 -->
                    <?php

                    foreach ($recipeDetails as $recipeDetail) {

                        echo '
                                <div class="flex space-x-2">
                                <select name="ingredient_name[]" class="w-64 border rounded-md px-2 py-1" required>
                            <option value="" disabled selected>-- Chọn nguyên liệu --</option>
                            ';
                        foreach ($ingredients as $ingredient) {

                            if ($recipeDetail->getIngredientId() == $ingredient->getId()) {
                                echo '<option value="' . $ingredient->getId() . '" selected>' . $ingredient->getIngredientName() . '</option>';
                            } else {
                                echo '<option value="' . $ingredient->getId() . '">' . $ingredient->getIngredientName() . '</option>';
                            }
                        }
                        echo '
                            </select>
                                ';

                        echo '<input type="number" name="ingredient_quantity[]" placeholder="Số lượng" value="' . $recipeDetail->getQuantity() . '"
                            class="w-24 border rounded-md px-2 py-1" required />';

                        echo '
                            <select name="ingredient_unit[]" id="unit" class="w-64 border rounded-md px-2 py-1" required>
                            <option value="" disabled selected>-- Chọn đơn vị --</option>
                            ';
                        foreach ($units as $unit) {
                            if ($recipeDetail->getUnitId() == $unit->getId()) {
                                echo '<option value="' . $unit->getId() . '" selected>' . $unit->getType() . '</option>';
                            } else {
                                echo '<option value="' . $unit->getId() . '">' . $unit->getType() . '</option>';
                            }
                        }
                        echo '
                            </select>';

                        echo '
                            <button type="button" onclick="removeIngredient(this)"
                            class="text-red-600 hover:underline text-sm bg-red-100 rounded-md px-2 py-1">X</button>
                            
                            </div>
                            ';
                    }
                    ?>



                </div>
                <!-- Nút thêm nguyên liệu -->
                <button type="button" onclick="addIngredient()" class="mt-3 text-blue-600 hover:underline text-sm">+
                    Thêm nguyên liệu</button>
            </div>

            <!-- Nút cập nhật công thức -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none">
                    Cập nhật công thức
                </button>
            </div>
        </div>
    </form>

    <!-- Script thêm dòng nguyên liệu -->
    <script>
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
        document.getElementById("edit-recipe-form").addEventListener("submit", function(e) {
            e.preventDefault();
            const form = e.target;

            // Lấy dữ liệu từ form
            const formData = new FormData(form);

            // Gửi dữ liệu qua fetch (AJAX)
            fetch("./php/Recipe/updateRecipe.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            alert("Cập nhật công thức thành công!");
                            location.reload();
                        } else {
                            alert("Lỗi: " + data.message);
                        }
                        window.location.href = "http://localhost/Web_Advanced_Project/src/views/Admin/index.php?pages=recipe";
                    } catch {
                        console.log("Phản hồi lỗi:", text);
                        alert("Phản hồi không hợp lệ từ máy chủ.");
                        window.location.href = "http://localhost/Web_Advanced_Project/src/views/Admin/index.php?pages=recipe";
                    }
                })
                .catch(err => {
                    console.error("Lỗi gửi dữ liệu:", err);
                    alert("Đã xảy ra lỗi khi gửi dữ liệu.");
                });
        });

        function removeIngredient(button) {
            const ingredientDiv = button.parentNode;
            ingredientDiv.remove();
        }
    </script>
</body>

</html>