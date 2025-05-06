<?php
session_start();
$response = [];

if (isset($_SESSION['user_id'])) {
    $response['isLoggedIn'] = true;
    $response['user_id'] = $_SESSION['user_id'];

    if (isset($_SESSION['user'])) {
        $response['username'] = $_SESSION['user'];
    }
} else {
    $response['isLoggedIn'] = false;
}

echo json_encode($response);