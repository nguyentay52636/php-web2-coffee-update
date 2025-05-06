<?php

class Unit {
    private $id;
    private $type;

    private $description;

    public function __construct($id = null, $type = null,$description = null) {
        $this->id = $id;
        $this->type = $type;
        $this->description = $description;
    }
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
}

?>