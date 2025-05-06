<?php
    $productId = $_GET['id'];
    if ($productId) {
        echo '
        <script>
        console.log("productId: ' . $productId . '");
        </script>
        ';
    } else {
        die("productId not found in session");
    }
include_once __DIR__ . "/../../../../controllers/RecipeController.php";
include_once __DIR__ . "/../../../../controllers/UnitController.php";
include_once __DIR__ . "/../../../../controllers/ProductController.php";

$recipeController   = new RecipeController();
$unitController     = new UnitController();
$productController = new ProductController();

$product = $productController->getProductById($productId );

?>

<body>
    <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-6 h-[750px] overflow-auto">
        <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
        <!-- Nội dung form -->
        <div class="bg-gray-50 min-h-screen relative h-[500px] overflow-y-scroll">
            <div class="bg-gray-100 min-h-screen p-4">
                <div class="max-w-4xl mx-auto bg-white rounded-md shadow-md p-6">
                    <!-- Tiêu đề -->
                    <div
                        class="flex flex-col md:flex-row items-start md:items-center justify-between border-b pb-4 mb-4">
                        <div>
                            <h1 class="text-xl font-semibold">Sửa sản phẩm</h1>
                            <p class="text-sm text-gray-500">Vui lòng chỉnh sửa thông tin bên dưới.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="index.php?pages=product" class="text-gray-500 focus:outline-none">
                                <button type="button" class="text-gray-500">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Tên sản phẩm -->
                    <div>
                        <label for="product-name" class="block text-sm font-medium text-gray-700 mb-1">Tên sản
                            phẩm</label>
                        <input type="text" id="product-name" name="product_name"
                            value="<?= htmlspecialchars($product->getProductName()) ?>"
                            class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300" />
                    </div>

                    <!-- Công thức -->
                    <div>
                        <label for="recipe" class="block text-sm font-medium text-gray-700 mt-4 mb-1">Công
                            thức</label>
                        <select name="recipe" id="recipe" class="w-full border border-gray-300 rounded-md py-2 px-3">
                            <option value="">Chọn công thức</option>
                            <?php foreach ($recipeController->getAllRecipes() as $recipe): ?>
                            <option value="<?= $recipe->getId() ?>"
                                <?= $recipe->getId() == $product->getRecipeId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($recipe->getRecipeName()) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Đơn vị tính -->
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mt-4 mb-1">Đơn vị
                            tính</label>
                        <select name="unit" id="unit" class="w-full border border-gray-300 rounded-md py-2 px-3">
                            <option value="">Chọn đơn vị</option>
                            <?php foreach ($unitController->getAllUnits() as $unit): ?>
                            <option value="<?= $unit->getId() ?>"
                                <?= $unit->getId() == $product->getUnitId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($unit->getType()) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Giá -->
                    <div>
                        <label for="final-price" class="block text-sm font-medium text-gray-700 mt-4 mb-1">Giá</label>
                        <input type="number" id="final-price" name="final_price" value="<?= $product->getPrice() ?>"
                            class="block w-full border border-gray-300 rounded-md py-2 px-3" placeholder="0" />
                    </div>

                    <!-- Ảnh sản phẩm -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh sản phẩm</label>
                        <?php if ($product->getLinkImage()): ?>
                        <img src="<?= $product->getLinkImage() ?>" alt="Ảnh hiện tại"
                            class="w-32 h-32 object-cover rounded mb-2" />
                        <?php endif; ?>
                        <input type="hidden" name="old_image" value="<?= $product->getLinkImage() ?>">
                        <input type="file" id="product-image" name="product_image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    </div>

                    <!-- Submit -->
                    <div class="pt-4 border-t mt-6">
                        <button id="save-product" type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                            Cập nhật sản phẩm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
    // Gửi form bằng fetch
    document.getElementById("save-product").addEventListener("click", function(e) {
        e.preventDefault();

        const form = document.getElementById("editProductForm");
        const formData = new FormData(form);

        fetch("./php/Product/editProduct.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert("Cập nhật sản phẩm thành công!");
                        location.reload();
                    } else {
                        alert("Lỗi: " + data.message);
                    }
                } catch {
                    console.log("Phản hồi lỗi:", text);
                    alert("Phản hồi không hợp lệ từ máy chủ.");
                }
            })
            .catch(err => {
                console.error("Lỗi gửi dữ liệu:", err);
                alert("Đã xảy ra lỗi khi gửi dữ liệu.");
            });
    });
    </script>
</body>

</html>