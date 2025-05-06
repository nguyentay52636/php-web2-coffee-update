<?php

class Category {
    private $id;
    private $categoryName;

    public function __construct($id, $categoryName) {
        $this->id = $id;
        $this->categoryName = $categoryName;
    }

    public function getId() {
        return $this->id;
    }

    public function getCategoryName() {
        return $this->categoryName;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }
}
?>