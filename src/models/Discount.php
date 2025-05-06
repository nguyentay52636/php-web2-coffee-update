<?php

class Discount {
    private $id;
    private $discountName;
    private $discountPercent;
    private $requirement;
    private $startDate;
    private $endDate;

    public function __construct($id = null, $discountName = null, $discountPercent = null, $requirement = null, $startDate = null, $endDate = null) {
        $this->id = $id;
        $this->discountName = $discountName;
        $this->discountPercent = $discountPercent;
        $this->requirement = $requirement;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDiscountName() {
        return $this->discountName;
    }

    public function setDiscountName($discountName) {
        $this->discountName = $discountName;
    }

    public function getDiscountPercent() {
        return $this->discountPercent;
    }

    public function setDiscountPercent($discountPercent) {
        $this->discountPercent = $discountPercent;
    }

    public function getRequirement() {
        return $this->requirement;
    }

    public function setRequirement($requirement) {
        $this->requirement = $requirement;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
}

?>