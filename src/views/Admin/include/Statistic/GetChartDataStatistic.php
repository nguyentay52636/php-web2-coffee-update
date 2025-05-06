<?php
// include controllers
include_once __DIR__ . "/../../../../controllers/OrderController.php";

// force JSON output
header('Content-Type: application/json');

// 1) Read & decode request JSON
$request  = json_decode(file_get_contents('php://input'), true);
$yearReq  = isset($request['year']) ? (int)$request['year'] : null;

// 2) Default to current year if not supplied
$year = $yearReq ?? (int) date('Y');

// 3) Fetch all orders
$orderController = new OrderController();
/** @var Order[] $orders */
$orders = $orderController->getAllOrder();

// 4) Prepare monthly buckets
$monthlyRevenue = array_fill(0, 12, 0);
$monthlyOrders  = array_fill(0, 12, 0);

// 5) Tally revenue & count per month
foreach ($orders as $order) {
    // use your Order getter, not array access
    $dateStr   = $order->getDateOfOrder();
    $ts        = strtotime($dateStr);
    $oYear     = (int) date('Y', $ts);
    if ($oYear !== $year) {
        continue;
    }

    $monthIdx              = (int) date('n', $ts) - 1; // 1→0, 2→1, …
    $monthlyRevenue[$monthIdx] += $order->getTotal();
    $monthlyOrders[$monthIdx]  += 1;
}

// 6) Labels for Chart.js
$labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

// 7) Output JSON
echo json_encode([
    'year'    => $year,
    'labels'  => $labels,
    'revenue' => $monthlyRevenue,
    'orders'  => $monthlyOrders
]);
