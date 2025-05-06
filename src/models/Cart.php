<?php

class Cart {
    private $id;
    private $userId;
    private $quantity;

    public function __construct($id = null, $userId = null, $quantity = null) {
        $this->id = $id;
        $this->userId = $userId;
        $this->quantity = $quantity;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
}

?>