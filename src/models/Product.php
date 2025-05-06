<?php

class Product
{
    private $id;
    private $recipeId;
    private $productName;
    private $price;
    private $linkImage;
    private $unitId;
    private $categoryId;

    public function __construct($id = null, $recipeId = null, $productName = null, $price = null, $linkImage = null, $unitId = null, $categoryId = null)
    {
        $this->id = $id;
        $this->recipeId = $recipeId;
        $this->productName = $productName;
        $this->price = $price;
        $this->linkImage = $linkImage;
        $this->unitId = $unitId;
        $this->linkImage = $linkImage;
        $this->categoryId = $categoryId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRecipeId()
    {
        return $this->recipeId;
    }

    public function setRecipeId($recipeId)
    {
        $this->recipeId = $recipeId;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getUnitId()
    {
        return $this->unitId;
    }

    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    }

    public function getLinkImage()
    {
        return $this->linkImage;
    }

    public function setLinkImage($linkImage)
    {
        $this->linkImage = $linkImage;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
}
