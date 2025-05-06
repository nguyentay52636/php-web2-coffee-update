<?php
include __DIR__ . "/../../../../controllers/OrderController.php";
include __DIR__ . "/../../../../controllers/UserController.php";
include __DIR__ . "/../../../../controllers/DiscountController.php";
$orderController = new OrderController();
$userController = new UserController();
$discountController = new DiscountController();
$orders;
$users;
$discounts;
$i = 1;
$orders = $orderController->getAllOrder();

$tableString = "";
if ($orders) {
    foreach ($orders as $ord) {
        $rowColor = "bg-white";
        $status = $ord->getOrderStatus();
        $statusColor = "text-gray-500";
        $dc = $ord->getDiscountId();
        if ($dc == null) $dc = "0%";
        else $dc = $discountController->getDiscountById($ord->getDiscountId())->getDiscountPercent();
        if (!($i & 1)) $rowColor = "bg-gray-200";
        if ($status == "CANCELLED") $statusColor = "text-red-500";
        else if ($status == "COMPLETED") $statusColor = "text-green-500";
        $tableString .=
            '<tr class="' . $rowColor . '">
    <td class="p-3">' . $ord->getId() . '</td>
    <td class="p-3">' . $ord->getUserId() . '</td>
    <td class="p-3">' . $ord->getDateOfOrder() . '</td>
    <td class="p-3">' . $dc . '</td>
    <td class="p-3">' . $ord->getPriceBeforeDiscount() . '</td>
    <td class="p-3">' . $ord->getTotal() . '</td>
    <td class="p-3 font-bold ' . $statusColor . '">' . $ord->getOrderStatus() . '</td>
    <td class="p-3 font-bold" onclick="viewOrderDetail(' . $ord->getId() . ',' . $ord->getDateOfOrder() . ')"><i class="fa-solid fa-eye text-blue-500" data-id="' . $ord->getId() . '"></i></td>

    <td class="p-3"> 
    <select name="" id="" onchange="changeColor(this)" class="font-bold text-blue-500 bg-transparent" data-id="' . $ord->getId() . '">
        <option value="" selected disabled class="font-bold text-blue-500 ">EDIT</option>
        <option value="CANCELLED"  class="text-red-500 font-bold"  >CANCELLED</option>
        <option value="COMPLETED" class="text-green-500 bont-bold">COMPLETED</option>
        </select>
    </td>

    </tr>';
        $i++;
    }
}
echo $tableString;
