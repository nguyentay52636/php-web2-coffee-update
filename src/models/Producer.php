<?php

class Producer {
    private $id;
    private $producerName;
    private $address;
    private $phone;

    public function __construct($id = null, $producerName = null, $address = null, $phone = null) {
        $this->id = $id;
        $this->producerName = $producerName;
        $this->address = $address;
        $this->phone = $phone;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProducerName() {
        return $this->producerName;
    }

    public function setProducerName($producerName) {
        $this->producerName = $producerName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
}

?>