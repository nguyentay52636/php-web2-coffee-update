<?php

class User {
    private $id;
    private $accountId;
    private $fullName;
    private $address;
    private $phone;
    private $email;
    private $dateOfBirth;

    public function __construct($id = null, $accountId = null, $fullName = null, $address = null, $phone = null, $email = null, $dateOfBirth = null) {
        $this->id = $id;
        $this->accountId = $accountId;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAccountId() {
        return $this->accountId;
    }

    public function setAccountId($accountId) {
        $this->accountId = $accountId;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }
}

?>