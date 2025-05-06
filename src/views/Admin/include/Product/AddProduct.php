<body>
    <?php
    include_once __DIR__ ."/../../../../controllers/RecipeController.php";
    include_once __DIR__ ."/../../../../controllers/UnitController.php";
    include_once __DIR__ . "/../../../../controllers/ProductController.php";
    
    $recipeController = new RecipeController();

    $unitController = new UnitController();
    ?>
    <form id="addProductForm" method="POST" class="space-y-6">
        <div id=" addProductModal" class=" bg-gray-50 min-h-screen relative h-[600px] overflow-y-scroll">
            <div class=" bg-gray-100 min-h-screen p-4">
                <div class="max-w-4xl mx-auto bg-white rounded-md shadow-md p-6">
                    <!-- Tiêu đề -->
                    <div
                        class="flex flex-col md:flex-row items-start md:items-center justify-between border-b pb-4 mb-4">
                        <div>
                            <h1 class="text-xl font-semibold">Thêm sản phẩm</h1>
                            <p class="text-sm text-gray-500">Vui lòng điền thông tin bên dưới để thêm dữ liệu!</p>
                        </div>
                        <!-- Product Existing -->
                        <div class="mt-4 md:mt-0 flex items-center space-x-2">
                            <a href="index.php?pages=product" class="text-gray-500 focus:outline-none">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Khu vực form chính -->

                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-lg font-semibold mb-3">Thông tin cơ bản</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Product Name -->
                            <div>
                                <label for="product-name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tên sản phẩm</label>
                                <input type="text" id="product-name" name="product_name" class="block w-full border border-gray-300 rounded-md py-2 px-3
                         focus:outline-none focus:ring focus:ring-blue-300" placeholder="Nhập tên sản phẩm" />
                            </div>



                        </div>
                    </div>


                    <!-- Recipe -->
                    <div>
                        <h2 class="text-lg font-semibold mb-3">Công thức</h2>
                        <div class="flex flex-wrap gap-4">
                            <select name="recipe" id="recipe">
                                <option value="">Chọn công thức</option>
                                <?php 
                                    $recipes = $recipeController->getAllRecipes();
                                    
                                foreach ($recipes as $recipe) { 
                                    
                                echo '
                                <option value="' . $recipe->getId() . '">' . $recipe->getRecipeName() . '</option>';
                        }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Unit -->

                    <div>
                        <h2 class="text-lg font-semibold mb-3">Đơn vị</h2>
                        <div class="flex flex-wrap gap-4">
                            <select name="unit" id="unit">
                                <option value="">Chọn đơn vị</option>
                                <?php
                                $units = $unitController->getAllUnits();
                                foreach ($units as $unit) { 
                                echo '
                                <option value="' . $unit->getId() . '">' . $unit->getType() . '</option>';
                        }
                                ?>
                            </select>
                        </div>
                    </div>




                    <!-- Product Pricing -->
                    <div>
                        <h2 class="text-lg font-semibold mb-3">Giá sản phẩm</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>
                                <label for="final-price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Giá bán</label>
                                <input type="number" id="final-price" name="final_price" class="block w-full border border-gray-300 rounded-md py-2 px-3
                         focus:outline-none focus:ring focus:ring-blue-300" placeholder="0" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold mb-3">Ảnh sản phẩm</h2>
                        <p class="text-sm text-gray-500 mb-2">
                            Ảnh nên có định dạng .jpg hoặc .png, kích thước tối thiểu 300x300 px. <br />
                            Đối với hình ảnh quảng cáo lớn, dùng tối thiểu 1200x1200 px.
                        </p>
                        <input type="file" id="product-image" name="product_image" accept="image/*" class="block w-full text-sm text-gray-500
                     file:mr-4 file:py-2 file:px-4
                     file:rounded file:border-0
                     file:text-sm file:font-semibold
                     file:bg-blue-50 file:text-blue-700
                     hover:file:bg-blue-100" />
                    </div>

                    <!-- Nút tạo sản phẩm -->
                    <div class="pt-4 border-t">

                        <button id="create-product" type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md" value="Create product"
                            name="create_product">
                            Tạo sản phẩm
                        </button>

                    </div>


                </div>
            </div>
        </div>
    </form>

    <script>
    document.getElementById("create-product").addEventListener("click", function(event) {
        event.preventDefault();


        var productName = document.getElementById("product-name").value;
        var recipe = document.getElementById("recipe").value;
        var unit = document.getElementById("unit").value;
        var finalPrice = document.getElementById("final-price").value;
        var productImage = document.getElementById("product-image").files[0] || null;




        if (productName.trim() == '' || productName == null) {
            document.getElementById("product-name").focus();

            return
        }

        if (recipe.trim() == '' || recipe == null) {
            document.getElementById("recipe").focus();

            return
        }

        if (unit.trim() == '' || unit == null) {
            document.getElementById("unit").focus();

            return
        }

        if (!/^\d+(\.\d+)?$/.test(finalPrice.trim()) || parseFloat(finalPrice.trim()) <= 0 || finalPrice
            .trim() ==
            '' || finalPrice.trim() == null) {
            document.getElementById("final-price").focus();

            return

        }

        let formData = new FormData(document.getElementById("addProductForm"));

        // const element = document.createElement('div');
        fetch("./php/Product/addProduct.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                console.log("Data received:", text);
                try {
                    const jsonData = JSON.parse(text.trim());
                    return jsonData;
                    console.log("Parsed JSON:", jsonData);
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
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