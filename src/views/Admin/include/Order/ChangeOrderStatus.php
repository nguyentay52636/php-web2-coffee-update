<?php
include __DIR__ . "/../../../../controllers/OrderController.php";
include __DIR__ . "/../../../../controllers/DiscountController.php";
include __DIR__ . "/../../../../controllers/UserController.php";

$orderController = new OrderController();
$discountController = new DiscountController();
$userController = new UserController();
$order;
// $discounts;
// $users;

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$id = $data['id'];
$status = $data['status'];

$orderController->updateOrderStatus($id, $status);
