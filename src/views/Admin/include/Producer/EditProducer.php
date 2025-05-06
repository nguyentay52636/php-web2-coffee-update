<?php
include __DIR__ . "/../../../../controllers/ProducerController.php";
$producerController = new ProducerController();

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$id = $data['id'];
$name = $data['name'];
$address = $data['address'];
$phone = $data['phone'];

$producerController->updateProducer(new Producer($id, $name, $address, $phone));
