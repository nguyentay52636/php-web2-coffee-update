<?php
include __DIR__ . "/../../../../controllers/ProducerController.php";
$producerController = new ProducerController();

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$name = $data['name'];
$address = $data['address'];
$phone = $data['phone'];

$producerController->addProducer(new Producer(null, $name, $address, $phone));
