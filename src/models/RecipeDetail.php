<?php

class RecipeDetail {
    private $recipeId;
    private $ingredientId;
    private $quantity;
    private $unitId;

    public function __construct($recipeId = null, $ingredientId = null, $quantity = null, $unitId = null) {
        $this->recipeId = $recipeId;
        $this->ingredientId = $ingredientId;
        $this->quantity = $quantity;
        $this->unitId = $unitId;
    }

    // Getters
    public function getRecipeId() {
        return $this->recipeId;
    }

    public function getIngredientId() {
        return $this->ingredientId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getUnitId() {
        return $this->unitId;
    }

    // Setters
    public function setRecipeId($recipeId) {
        $this->recipeId = $recipeId;
    }

    public function setIngredientId($ingredientId) {
        $this->ingredientId = $ingredientId;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setUnitId($unitId) {
        $this->unitId = $unitId;
    }
}

?>