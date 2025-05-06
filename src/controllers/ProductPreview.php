<?php

require_once 'config/DatabaseConnection.php';
require_once 'models/ProductReview.php'; // Đảm bảo ProductReview.php được bao gồm

class ProductReviewController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllProductReviews() {
        $sql = "SELECT * FROM PRODUCTREVIEWS";
        $result = $this->connection->query($sql);

        $productReviews = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productReview = new ProductReview(
                    $row['ID'],
                    $row['USERID'],
                    $row['PRODUCTID'],
                    $row['RATING'],
                    $row['DATE'],
                    $row['COMMENT']
                );
                $productReviews[] = $productReview;
            }
        }
        return $productReviews;
    }

    public function getProductReviewById($id) {
        $sql = "SELECT * FROM PRODUCTREVIEWS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new ProductReview(
                $row['ID'],
                $row['USERID'],
                $row['PRODUCTID'],
                $row['RATING'],
                $row['DATE'],
                $row['COMMENT']
            );
        }
        return null;
    }

    public function addProductReview(ProductReview $productReview) {
        $sql = "INSERT INTO PRODUCTREVIEWS (USERID, PRODUCTID, RATING, DATE, COMMENT) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $userId = $productReview->getUserId();
        $productId = $productReview->getProductId();
        $rating = $productReview->getRating();
        $date = $productReview->getDate();
        $comment = $productReview->getComment();

        $stmt->bind_param("iids", $userId, $productId, $rating, $date, $comment);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProductReview(ProductReview $productReview) {
        $sql = "UPDATE PRODUCTREVIEWS SET USERID = ?, PRODUCTID = ?, RATING = ?, DATE = ?, COMMENT = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $userId = $productReview->getUserId();
        $productId = $productReview->getProductId();
        $rating = $productReview->getRating();
        $date = $productReview->getDate();
        $comment = $productReview->getComment();
        $id = $productReview->getId();

        $stmt->bind_param("iidsi", $userId, $productId, $rating, $date, $comment, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProductReview($id) {
        $sql = "DELETE FROM PRODUCTREVIEWS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductReviewsByProductId($productId) {
        $sql = "SELECT * FROM PRODUCTREVIEWS WHERE PRODUCTID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        $productReviews = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productReview = new ProductReview(
                    $row['ID'],
                    $row['USERID'],
                    $row['PRODUCTID'],
                    $row['RATING'],
                    $row['DATE'],
                    $row['COMMENT']
                );
                $productReviews[] = $productReview;
            }
        }
        return $productReviews;
    }
}

?>