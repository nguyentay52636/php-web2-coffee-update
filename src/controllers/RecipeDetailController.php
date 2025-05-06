<?php

include __DIR__ ."/../models/RecipeDetail.php";
include_once __DIR__ ."/../config/DatabaseConnection.php";

class RecipeDetailController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }
    public function deleteRecipeDetail($recipeId) {
        $sql = "DELETE FROM RECIPEDETAILS WHERE RECIPEID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $recipeId);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function createRecipeDetail($recipeId, $ingredientId, $quantity, $unitId) {
        $sql = "INSERT INTO RECIPEDETAILS (RECIPEID, INGREDIENTID, QUANTITY, UNITID) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiid", $recipeId, $ingredientId, $quantity, $unitId);

        if ($stmt->execute()) {
            return new RecipeDetail($recipeId, $ingredientId, $quantity, $unitId);
        } else {
            return null;
        }
    }

    public function getRecipeDetail($recipeId) {
        $sql = "SELECT * FROM RECIPEDETAILS WHERE RECIPEID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $recipeId);
        $stmt->execute();
        $result = $stmt->get_result();
        $recipeDetails = [];
        while ($row = $result->fetch_assoc()) {
            $recipeDetails[] = new RecipeDetail($row['RECIPEID'], $row['INGREDIENTID'], $row['QUANTITY'], $row['UNITID']);
        }
        return $recipeDetails;
    }

    // Thêm các phương thức khác như updateRecipeDetail, deleteRecipeDetail nếu cần
}

?>