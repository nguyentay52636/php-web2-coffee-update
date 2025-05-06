<?php

class CartDetail {
    private $cartId;
    private $productId;
    private $quantity;

    public function __construct($cartId = null, $productId = null, $quantity = null) {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    // Getters
    public function getCartId() {
        return $this->cartId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    // Setters
    public function setCartId($cartId) {
        $this->cartId = $cartId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
}

?>