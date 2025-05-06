<?php

class Recipe {
    private $id;
    private $recipeName;

    public function __construct($id = null, $recipeName = null) {
        $this->id = $id;
        $this->recipeName = $recipeName;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getRecipeName() {
        return $this->recipeName;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setRecipeName($recipeName) {
        $this->recipeName = $recipeName;
    }
}

?>