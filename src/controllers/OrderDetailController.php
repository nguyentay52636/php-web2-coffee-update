<?php

require_once __DIR__ . '/../config/DatabaseConnection.php';
require_once __DIR__ . '/../models/OrderDetail.php'; // Đảm bảo đã bao gồm model OrderDetail
require_once __DIR__ . '/../models/Product.php';  // Đảm bảo đã bao gồm model OrderDetail

class OrderDetailController
{
    private $connection;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getOrderDetailById($id)
    {
        $sql = "SELECT * FROM ORDERDETAILS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orderDetails = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orderDetails[] = new OrderDetail(
                    $row['ID'],
                    $row['ORDERID'],
                    $row['PRODUCTID'],
                    $row['QUANTITY'],
                    $row['PRICE'],
                    $row['TOTAL']
                );
            }
            return $orderDetails;
        } else {
            return null;
        }
    }

    public function getAllOrderDetails()
    {
        $sql = "SELECT * FROM ORDERDETAILS";
        $result = $this->connection->query($sql);
        $orderDetails = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orderDetails[] = new OrderDetail(
                    $row['ID'],
                    $row['ORDERID'],
                    $row['PRODUCTID'],
                    $row['QUANTITY'],
                    $row['PRICE'],
                    $row['TOTAL']
                );
            }
        }

        return $orderDetails;
    }

    public function createOrderDetail(OrderDetail $orderDetail)
    {
        $sql = "INSERT INTO ORDERDETAILS (ORDERID, PRODUCTID, QUANTITY, PRICE, TOTAL) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param(
            "iiidd",
            $orderDetail->getOrderId(),
            $orderDetail->getProductId(),
            $orderDetail->getQuantity(),
            $orderDetail->getPrice(),
            $orderDetail->getTotal()
        );

        if ($stmt->execute()) {
            return $this->connection->insert_id; // Trả về ID vừa được thêm
        } else {
            return false;
        }
    }

    public function updateOrderDetail(OrderDetail $orderDetail)
    {
        $sql = "UPDATE ORDERDETAILS SET ORDERID = ?, PRODUCTID = ?, QUANTITY = ?, PRICE = ?, TOTAL = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param(
            "iiiddi",
            $orderDetail->getOrderId(),
            $orderDetail->getProductId(),
            $orderDetail->getQuantity(),
            $orderDetail->getPrice(),
            $orderDetail->getTotal(),
            $orderDetail->getId()
        );

        return $stmt->execute();
    }

    public function deleteOrderDetail($id)
    {
        $sql = "DELETE FROM ORDERDETAILS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
