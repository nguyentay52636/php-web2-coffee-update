<?php
include __DIR__ . "/../../../../controllers/ProducerController.php";

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$search = $data['search'];
$filter = $data['filter'];
$sortBy = $data['sortBy'];

$producerController = new ProducerController();
$producers;

if ($search != "") {
    $producers = $producerController->getSortProducerSearchFilter($search, $filter, $sortBy);
} else $producers = $producerController->getSortProducerFilter($filter, $sortBy);

$i = 1;
$tableStr = "";
if ($producers) {
    foreach ($producers as $pr) {
        $rowColor = "bg-white";
        if (!($i & 1)) $rowColor = "bg-gray-200";

        $tableStr .= '
<tr class="' . $rowColor . '">
    <td class="p-3">' . $pr->getId() . '</td>
    <td class="p-3">' . $pr->getProducerName() . '</td>
    <td class="p-3">' . $pr->getAddress() . '</td>
    <td class="p-3">' . $pr->getPhone() . '</td>
    <td class="p-3">
    <button type="button" class="text-blue-700   font-medium rounded-lg text-sm px-1 py-1 me-1 mb-1    focus:outline-none "onclick=" editProducer(' . $pr->getId() . ',' . $pr->getProducerName() . ',' . $pr->getAddress() . ',' . $pr->getPhone() . ') ">Sửa</button></td>

    <td class="p-3">
    <button type="button" class="focus:outline-none text-red-500  font-medium rounded-lg text-sm px-1 py-1 me-1 mb-1 ">Xóa</button></td> 

</tr>
    ';
        $i++;
    }
    echo $tableStr;
}
