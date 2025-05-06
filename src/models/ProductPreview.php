<?php

class ProductReview {
    private $id;
    private $userId;
    private $productId;
    private $rating;
    private $date;
    private $comment;

    public function __construct($id = null, $userId = null, $productId = null, $rating = null, $date = null, $comment = null) {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->rating = $rating;
        $this->date = $date;
        $this->comment = $comment;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }
}

?>