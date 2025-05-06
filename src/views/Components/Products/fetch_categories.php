<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Web_Advanced_Project/src/config/DatabaseConnection.php');

header('Content-Type: application/json');

$conn = (new DatabaseConnection())->getConnection();

$sql = "SELECT id, categoryName FROM categories";
$result = $conn->query($sql);

$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = [
        'id' => $row['id'],
        'name' => $row['categoryName']
    ];
}

echo json_encode($categories);