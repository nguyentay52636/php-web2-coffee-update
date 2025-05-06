<?php

require_once __DIR__ . '/../config/DatabaseConnection.php';
require_once __DIR__ . '/../models/Producer.php'; /// Đảm bảo Producer.php đã được tạo

class ProducerController
{
    private $connection;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllProducers()
    {
        $sql = "SELECT * FROM PRODUCERS";
        $result = $this->connection->query($sql);

        $producers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $producer = new Producer(
                    $row['ID'],
                    $row['PRODUCERNAME'],
                    $row['ADDRESS'],
                    $row['PHONE']
                );
                $producers[] = $producer;
            }
        }
        return $producers;
    }

    public function getProducerById($id)
    {
        $sql = "SELECT * FROM PRODUCERS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Producer(
                $row['ID'],
                $row['PRODUCERNAME'],
                $row['ADDRESS'],
                $row['PHONE']
            );
        }
        return null;
    }

    public function getProducerNameById($id)
    {
        $sql = "SELECT PRODUCERNAME FROM PRODUCERS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['PRODUCERNAME'];
        }
        return null;
    }

    public function addProducer(Producer $producer)
    {
        $sql = "INSERT INTO PRODUCERS (PRODUCERNAME, ADDRESS, PHONE) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $producerName = $producer->getProducerName();
        $address = $producer->getAddress();
        $phone = $producer->getPhone();

        $stmt->bind_param("sss", $producerName, $address, $phone);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProducer(Producer $producer)
    {
        $sql = "UPDATE PRODUCERS SET PRODUCERNAME = ?, ADDRESS = ?, PHONE = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $producerName = $producer->getProducerName();
        $address = $producer->getAddress();
        $phone = $producer->getPhone();
        $id = $producer->getId();

        $stmt->bind_param("sssi", $producerName, $address, $phone, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProducer($id)
    {
        $sql = "DELETE FROM PRODUCERS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getSortProducerSearchFilter($search, $filter, $sortBy)
    {
        $validColumns = ['ID', 'PRODUCERNAME', 'ADDRESS', 'PHONE'];
        $validOrders = ['ASC', 'DESC'];
        if (!in_array(strtoupper($filter), $validColumns)) {
            $filter = 'PRODUCERNAME';
        }
        if (!in_array(strtoupper($sortBy), $validOrders)) {
            $sortBy = 'ASC';
        }
        $searchEscaped = $this->connection->real_escape_string($search);
        $sql = "SELECT * FROM PRODUCERS
        WHERE PRODUCERNAME LIKE '%$searchEscaped%' OR ADDRESS LIKE '%$searchEscaped%' 
        ORDER BY " . $filter . " " . $sortBy;
        $result = $this->connection->query($sql);
        $producers = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $producers[] = new Producer(
                    $row['ID'],
                    $row['PRODUCERNAME'],
                    $row['ADDRESS'],
                    $row['PHONE'],

                );
            }
        }

        return $producers;
    }
    public function getSortProducerFilter($filter, $sortBy)
    {
        $validColumns = ['ID', 'PRODUCERNAME', 'ADDRESS', 'PHONE'];
        $validOrders = ['ASC', 'DESC'];
        if (!in_array(strtoupper($filter), $validColumns)) {
            $filter = 'PRODUCERNAME';
        }
        if (!in_array(strtoupper($sortBy), $validOrders)) {
            $sortBy = 'ASC';
        }

        $sql = "SELECT * FROM PRODUCERS ORDER BY " . $filter . " " . $sortBy;

        $result = $this->connection->query($sql);
        $producers = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $producers[] = new Producer(
                    $row['ID'],
                    $row['PRODUCERNAME'],
                    $row['ADDRESS'],
                    $row['PHONE'],

                );
            }
        }

        return $producers;
    }
}
