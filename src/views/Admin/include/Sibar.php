<aside class="bg-white w-64 p-4 h-screen ">
    <div class="flex items-center mb-8">
        <span class="text-xl font-semibold">CoffeeShop</span>
        <!-- <button class="ml-auto text-gray-400 focus:outline-none">
            <i class="fas fa-chevron-left"></i>
        </button> -->
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

        <button data-target="product" onclick="switchSection('products')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100 ">
            <i class=" fas fa-box-open mr-2"></i> Products
        </button>

        <button data-target="discounts" onclick="switchSection('discounts')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fas fa-bullhorn mr-2"></i> Discounts
        </button>

        <button data-target="statistic" onclick="switchSection('statistic')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fas fa-tachometer-alt mr-2"></i> Stasticts
        </button>

        <button data-target="account" onclick="switchSection('accounts')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fas fa-users mr-2"></i> Customers
        </button>

        <button data-target="orders" onclick="switchSection('orders')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fa-solid fa-cart-shopping mr-2"></i>Orders
        </button>

        <button data-target="producer" onclick="switchSection('producers')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fa-solid fa-truck-field mr-2"></i> Producer
        </button>

        <button data-target="import" onclick="switchSection('imports')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fa-solid fa-file-import mr-2 "></i> Import
        </button>

        <button data-target="ingredient" onclick="switchSection('ingredients')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fa-solid fa-wheat-awn-circle-exclamation mr-2"></i> Ingredient
        </button>


        <button data-target="recipe" onclick="switchSection('recipes')"
            class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100">
            <i class="fa-solid fa-weight-hanging mr-2"></i> Unit &
            <i class="fa-solid fa-mug-saucer ml-2 mr-2"></i> Recipe
        </button>


        <button class="flex items-center w-64 py-2 px-4 rounded hover:bg-gray-100 mt-4">
            <a href="../Pages/Home.php">
                <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
            </a>
        </button>

</aside>
<script>
function switchSection(section) {
    sessionStorage.setItem("sectionPages", section);
}
</script>