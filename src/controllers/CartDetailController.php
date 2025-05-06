<?php

require_once __DIR__ . '/../models/CartDetail.php';

class CartDetailController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }

    public function createCartDetail($cartId, $productId, $quantity) {
        $sql = "INSERT INTO CARTDETAILS (CARTID, PRODUCTID, QUANTITY) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iid", $cartId, $productId, $quantity);

        if ($stmt->execute()) {
            return new CartDetail($cartId, $productId, $quantity);
        } else {
            return null;
        }
    }

    public function getCartDetail($cartId, $productId) {
        // Câu truy vấn SQL để lấy thông tin chi tiết giỏ hàng
        $sql = "SELECT * FROM CARTDETAILS WHERE CARTID = ? AND PRODUCTID = ?";
        
        // Chuẩn bị câu lệnh
        $stmt = $this->conn->prepare($sql);
        
        // Gắn các tham số vào câu truy vấn
        $stmt->bind_param("ii", $cartId, $productId);
        
        // Thực thi câu lệnh
        $stmt->execute();
        
        // Lấy kết quả truy vấn
        $result = $stmt->get_result();
    
        // Kiểm tra nếu có dữ liệu
        if ($result->num_rows > 0) {
            // Lấy dòng dữ liệu đầu tiên từ kết quả
            $row = $result->fetch_assoc();
            
            // Trả về đối tượng CartDetail
            return new CartDetail($row['CARTID'], $row['PRODUCTID'], $row['QUANTITY']);
        } else {
            // Nếu không tìm thấy, trả về null
            return null;
        }
    }
    
public function getCartDetailByCartId($cartId) {
    $sql = "SELECT * FROM CARTDETAILS WHERE CARTID = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cartDetails = []; // Tạo một mảng để lưu các kết quả
    while ($row = $result->fetch_assoc()) {
        $cartDetails[] = new CartDetail($row['CARTID'], $row['PRODUCTID'], $row['QUANTITY']);
    }
    return $cartDetails; // Trả về danh sách các CartDetail
}


    // Thêm các phương thức khác như updateCartDetail, deleteCartDetail nếu cần
    public function addItem($cartId, $productId, $quantity) {
        $sql = "INSERT INTO CARTDETAILS (CARTID, PRODUCTID, QUANTITY) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE QUANTITY = QUANTITY + ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $cartId, $productId, $quantity, $quantity);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $this->updateCartQuantity($cartId);
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->affected_rows > 0; // Trả về true nếu thêm thành công
    }

    public function removeItem($cartId, $productId) {
        $sql = "DELETE FROM CARTDETAILS WHERE CARTID = ? AND PRODUCTID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $cartId, $productId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $this->updateCartQuantity($cartId);
        }
        return $stmt->affected_rows > 0; // Trả về true nếu xóa thành công
    }
    public function clearCart($cartId) {
        $sql = "DELETE FROM CARTDETAILS WHERE CARTID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cartId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $this->updateCartQuantity($cartId);
        }
        return $stmt->affected_rows > 0; // Trả về true nếu xóa tất cả thành công
    }
    public function updateCartQuantity($cartId) {
        // Lấy tổng số lượng sản phẩm trong giỏ hàng theo CARTID
        $sql = "UPDATE CARTS
                SET QUANTITY = (
                    SELECT IFNULL(SUM(QUANTITY), 0)
                    FROM CARTDETAILS
                    WHERE CARTID = ?
                )
                WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $cartId, $cartId);
        $stmt->execute();
    
        return $stmt->affected_rows > 0;
    }
    

}

?>