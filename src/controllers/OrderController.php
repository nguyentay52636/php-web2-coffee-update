<?php

require_once __DIR__ . '/../config/DatabaseConnection.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController
{

    private $conn;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }
    public function getAllOrder()
    {
        $sql = "SELECT * FROM ORDERS";
        $result = $this->conn->query($sql);

        $orders = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $order = new Order(
                    $row['ID'],
                    $row['USERID'],
                    $row['TOTAL'],
                    $row['DATEOFORDER'],
                    $row['ORDERSTATUS'],
                    $row['DISCOUNTID'],
                    $row['PRICEBEFOREDISCOUNT']
                );
                $orders[] = $order;
            }
        }
        return $orders;
    }
    public function createOrder($userId, $total, $dateOfOrder, $discountId, $priceBeforeDiscount)
    {
        $sql = "INSERT INTO ORDERS (USERID, TOTAL, DATEOFORDER, DISCOUNTID) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("idss", $userId, $total, $dateOfOrder, $discountId);

        if ($stmt->execute()) {
            return new Order($this->conn->insert_id, $userId, $total, $dateOfOrder, 'PENDING', $discountId, $priceBeforeDiscount); // Mặc định trạng thái là PENDING
        } else {
            return null;
        }
    }

    public function getOrder($id)
    {
        $sql = "SELECT * FROM ORDERS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Order(
                $row['ID'],
                $row['USERID'],
                $row['TOTAL'],
                $row['DATEOFORDER'],
                $row['ORDERSTATUS'],
                $row['DISCOUNTID'],
                $row['PRICEBEFOREDISCOUNT']
            );
        } else {
            return null;
        }
    }

    public function updateOrderStatus($id, $status)
    {
        $sql = "UPDATE ORDERS SET ORDERSTATUS = ? WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function searchOrder($status, $start, $end)
    {
        if ($status == "all") {
            $sql = "SELECT * FROM ORDERS WHERE DATEOFORDER >=? and DATEOFORDER <= ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $start, $end);
        } else {
            $status = strtoupper($status);
            $sql = "SELECT * FROM ORDERS WHERE ORDERSTATUS = ? AND DATEOFORDER >=? and DATEOFORDER <= ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $status, $start, $end);
        }
        $stmt->execute();
        $orders = [];
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $order = new Order(
                    $row['ID'],
                    $row['USERID'],
                    $row['TOTAL'],
                    $row['DATEOFORDER'],
                    $row['ORDERSTATUS'],
                    $row['DISCOUNTID'],
                    $row['PRICEBEFOREDISCOUNT']
                );
                $orders[] = $order;
            }
            return $orders;
        } else {
            return null;
        }
    }
}
