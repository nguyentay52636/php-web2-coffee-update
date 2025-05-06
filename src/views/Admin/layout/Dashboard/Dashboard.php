<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <div class="bg-gray-100 font-sans w-full h-[400px]">
            <div class="flex h-screen">

                <!-- Sidebar -->
                <aside class="bg-white w-64 p-4 h-screen ">
                    <div class="flex items-center mb-8">
                        <span class="text-xl font-semibold">CoffeeShop</span>

                    </div>
                    <div class="flex items-center mb-6">

                        <div>
                            <span class="block text-sm font-semibold">CoffeeShop_SGU</span>
                            <span class="block text-xs text-gray-500">Administrator</span>
                        </div>
                    </div>
                    <nav>
                        <div class="mb-4">
                            <span class="text-xs text-gray-500">MASTER DATA</span>
                        </div>

                        <a href="index.php?pages=product">
                            <button data-target="product"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100 ">
                                <i class=" fas fa-box-open mr-2"></i> Products
                            </button>
                        </a>

                        <a href="index.php?pages=discount">
                            <button data-target="discount"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fas fa-bullhorn mr-2"></i> Discounts
                            </button>
                        </a>

                        <a href="index.php?pages=statistic">
                            <button data-target="statistic"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt mr-2"></i> Stasticts
                            </button>
                        </a>

                        <a href="index.php?pages=customer">
                            <button data-target="account"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fas fa-users mr-2"></i> Customers
                            </button>
                        </a>

                        <a href="index.php?pages=order">
                            <button data-target="order"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fa-solid fa-cart-shopping mr-2"></i>Orders
                            </button>
                        </a>

                        <a href="index.php?pages=producer">
                            <button data-target="producer"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fa-solid fa-truck-field mr-2"></i> Producer
                            </button>
                        </a>

                        <a href="index.php?pages=import">
                            <button data-target="import"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fa-solid fa-file-import mr-2 "></i> Import
                            </button>
                        </a>

                        <a href="index.php?pages=ingredient">
                            <button data-target="ingredient"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fa-solid fa-wheat-awn-circle-exclamation mr-2"></i> Ingredient
                            </button>
                        </a>


                        <a href="index.php?pages=recipe">
                            <button data-target="recipe"
                                class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
                                <i class="fa-solid fa-weight-hanging mr-2"></i> Unit &
                                <i class="fa-solid fa-mug-saucer ml-2 mr-2"></i> Recipe
                            </button>
                        </a>


                        <a href="../Pages/Home.php">
                            <button class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100 mt-4">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                            </button>
                        </a>
                </aside>



                <!-- Main container chứa nội dung module -->
                <main id="dashboard" class="flex-1 p-8">
                    <div id="module-container">
                        <div class="products active-module">
                            <?php
                            $pages  = isset($_GET['pages']) ? $_GET['pages'] : 'product';
                            $check = isset($_GET['check']) ? $_GET['check'] : 1;
                            if ($pages == 'product') {
                                include_once __DIR__  . "/../../include/Product/Product.php";
                            } else if ($pages == 'discount') {
                                include_once __DIR__  . "/../../include/Discount/Discount.php";
                            } else if ($pages == 'statistic') {
                                include_once __DIR__  . "/../../include/Statistic/Statistic.php";
                            } else if ($pages == 'customer') {
                                include_once __DIR__  . "/../../include/Account/Account.php";
                            } else if ($pages == 'order') {
                                include_once __DIR__  . "/../../include/Order/Order.php";
                            } else if ($pages  == 'producer') {
                                include_once __DIR__  . "/../../include/Producer/Producer.php";
                            } else if ($pages  == 'import') {
                                include_once __DIR__  . "/../../include/Import/Import.php";
                            } else if ($pages  == 'ingredient') {
                                include_once __DIR__  . "/../../include/Ingredient/Ingredients.php";
                            } else if ($pages  == 'recipe') {
                                include_once __DIR__  . "/../../include/Recipe/Recipe.php";
                            } else if ($pages == 'addProduct') {
                                include_once __DIR__  . "/../../include/Product/AddProduct.php";
                            } else if ($pages == 'editProduct') {
                                include_once __DIR__  . "/../../include/Product/EditProduct.php";
                            } else if ($pages == 'addDiscount') {
                                include_once __DIR__  . "/../../include/Discount/AddDiscount.php";
                            } else if ($pages == 'editDiscount') {
                                include_once __DIR__  . "/../../include/Discount/EditDiscount.php";
                            } else if ($pages == 'detailAccount') {
                                include_once __DIR__  . "/../../include/Account/DetailAccount.php";
                            } else if ($pages == 'addUnit') {
                                include_once __DIR__  . "/../../include/Unit/AddUnit.php";
                            } else if ($pages == 'editUnit') {
                                include_once __DIR__  . "/../../include/Unit/EditUnit.php";
                            } else if ($pages = 'editRecipe' && $check == 1) {
                                include_once __DIR__  . "/../../include/Recipe/EditRecipe.php";
                            } else if ($pages = 'addRecipe' && $check == 0) {
                                include_once __DIR__  . "/../../include/Recipe/AddRecipe.php";
                            }
                            ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script>

    </script>
    //
</body>