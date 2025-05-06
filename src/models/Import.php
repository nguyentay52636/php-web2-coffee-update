<?php

class Import {
    private $id;
    private $producerId;
    private $date;
    private $total;

    public function __construct($id = null, $producerId = null, $date = null, $total = null) {
        $this->id = $id;
        $this->producerId = $producerId;
        $this->date = $date;
        $this->total = $total;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProducerId() {
        return $this->producerId;
    }

    public function setProducerId($producerId) {
        $this->producerId = $producerId;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
}

?>