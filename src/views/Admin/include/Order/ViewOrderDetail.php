<?php
include __DIR__ . "/../../../../controllers/OrderController.php";
include __DIR__ . "/../../../../controllers/UserController.php";
include __DIR__ . "/../../../../controllers/DiscountController.php";
include __DIR__ . "/../../../../controllers/OrderDetailController.php";
include __DIR__ . "/../../../../controllers/ProductController.php";

$json = file_get_contents("php://input");
$data = json_decode($json, true);
$id = $data['id'];

$orderController = new OrderController();
$userController = new UserController();
$discountController = new DiscountController();
$orderDetailController = new OrderDetailController();
$productController = new ProductController();

$orders;
$users;
$discounts;
$i = 1;

$orderDetails = $orderDetailController->getOrderDetailById($id);
$divStr = "";
if ($orderDetails) {
    foreach ($orderDetails as $ord) {
        $rowColor = "bg-white";
        if (!($i & 1)) $rowColor = "bg-gray-200";
        $divStr .= '
        <tr class="' . $rowColor . '">
            <td class="p-3">' . $ord->getProductId() . '</td>
            <td class="p-3">' . $productController->getProductById($ord->getProductId())->getProductName() . '</td>                        
            <td class="p-3">' . $ord->getQuantity() . '</td>
            <td class="p-3">' . $ord->getPrice() . '</td>
            <td class="p-3">' . $ord->getTotal() . '</td>

        </tr>
        ';
        $i++;
    }
}
echo $divStr;
// <tr class="' . $rowColor . '">
//                             <td class="p-3">' . $ord->getId() . '</td>
//                             <td class="p-3">' . $ord->getUserId() . '</td>
//                             <td class="p-3">' . $ord->getDateOfOrder() . '</td>
//                             <td class="p-3">' . $discountController->getDiscountById($ord->getDiscountId())->getDiscountPercent() . '</td>
//                             <td class="p-3">' . $ord->getPriceBeforeDiscount() . '</td>
//                             <td class="p-3">' . $ord->getTotal() . '</td>
//                             <td class="p-3 font-bold ' . $statusColor . '">' . $ord->getOrderStatus() . '</td>
//                             <td class="p-3 font-bold" onclick="viewOrderDetail(' . $ord->getId() . ',' . $ord->getDateOfOrder() . ')"><i class="fa-solid fa-eye text-blue-500" data-id="' . $ord->getId() . '"></i></td>
//                             <td class="p-3"> 
//                             <select name="" id="" onchange="changeColor(this)" class="font-bold text-blue-500 bg-transparent" data-id="' . $ord->getId() . '">
//                                 <option value="" selected disabled class="font-bold text-blue-500 ">EDIT</option>
//                                 <option value="CANCELLED"  class="texta-red-500 font-bold"  >CANCELLED</option>
//                                 <option value="COMPLETED" class="text-green-500 bont-bold">COMPLETED</option>
//                                 </select>
//                             </td>

//                             </tr>
