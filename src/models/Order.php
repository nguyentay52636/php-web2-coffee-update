<?php

class Order
{
    private $id;
    private $userId;
    private $total;
    private $dateOfOrder;
    private $orderStatus;
    private $discountId;
    private $priceBeforeDiscount;

    public function __construct($id = null, $userId = null, $total = null, $dateOfOrder = null, $orderStatus = null, $discountId = null, $priceBeforeDiscount = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->total = $total;
        $this->dateOfOrder = $dateOfOrder;
        $this->orderStatus = $orderStatus;
        $this->discountId = $discountId;
        $this->priceBeforeDiscount = $priceBeforeDiscount;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getDateOfOrder()
    {
        return $this->dateOfOrder;
    }

    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    public function getDiscountId()
    {
        return $this->discountId;
    }
    public function getPriceBeforeDiscount()
    {
        return $this->priceBeforeDiscount;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setDateOfOrder($dateOfOrder)
    {
        $this->dateOfOrder = $dateOfOrder;
    }

    public function setOrderStatus($orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function setDiscountId($discountId)
    {
        $this->discountId = $discountId;
    }

    public function setPriceBeforeDiscount($priceBeforeDiscount)
    {
        $this->priceBeforeDiscount = $priceBeforeDiscount;
    }
}