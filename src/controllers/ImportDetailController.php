<?php


require_once './../models/ImportDetail.php'; // Đảm bảo đường dẫn chính xác


class ImportDetailsController {
    private $connection;

    public function __construct(DatabaseConnection $db) {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllImportDetails() {
        $sql = "SELECT * FROM IMPORTDETAILS";
        $result = $this->connection->query($sql);
        $importDetails = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $importDetails[] = new ImportDetails(
                    $row['ID'],
                    $row['IMPORTID'],
                    $row['INGREDIENTID'],
                    $row['QUANTITY'],
                    $row['PRICE'],
                    $row['TOTAL'],
                    $row['UNITID']
                );
            }
        }
        return $importDetails;
    }

    public function getImportDetailById($id) {
        $sql = "SELECT * FROM IMPORTDETAILS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new ImportDetails(
                $row['ID'],
                $row['IMPORTID'],
                $row['INGREDIENTID'],
                $row['QUANTITY'],
                $row['PRICE'],
                $row['TOTAL'],
                $row['UNITID']
            );
        }
        return null;
    }

    public function createImportDetail(ImportDetails $importDetail) {
        $sql = "INSERT INTO IMPORTDETAILS (IMPORTID, INGREDIENTID, QUANTITY, PRICE, TOTAL, UNITID) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("iiidddi", $importDetail->getImportId(), $importDetail->getIngredientId(), $importDetail->getQuantity(), $importDetail->getPrice(), $importDetail->getTotal(), $importDetail->getUnitId());
        return $stmt->execute();
    }

    public function updateImportDetail(ImportDetails $importDetail) {
        $sql = "UPDATE IMPORTDETAILS SET IMPORTID = ?, INGREDIENTID = ?, QUANTITY = ?, PRICE = ?, TOTAL = ?, UNITID = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("iiidddii", $importDetail->getImportId(), $importDetail->getIngredientId(), $importDetail->getQuantity(), $importDetail->getPrice(), $importDetail->getTotal(), $importDetail->getUnitId(), $importDetail->getId());
        return $stmt->execute();
    }

    public function deleteImportDetail($id) {
        $sql = "DELETE FROM IMPORTDETAILS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>