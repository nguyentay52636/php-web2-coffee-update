<?php

require_once __DIR__ . '/../models/Cart.php';


class CartController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }

    public function createCart($userId, $quantity) {
        $sql = "INSERT INTO CARTS (USERID, QUANTITY) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("id", $userId, $quantity);

        if ($stmt->execute()) {
            return new Cart($this->conn->insert_id, $userId, $quantity);
        } else {
            return null;
        }
    }

    public function getCart($id) {
        $sql = "SELECT * FROM CARTS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Cart($row['ID'], $row['USERID'], $row['QUANTITY']);
        } else {
            return null;
        }
    }

    public function getCartByUser($userId) {
        // SQL để lấy giỏ hàng của người dùng theo userId
        $sql = "SELECT * FROM CARTS WHERE USERID = ? LIMIT 1"; // Đảm bảo bảng đúng tên
    
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($sql);
    
        // Liên kết tham số userId
        $stmt->bind_param("i", $userId);
    
        // Thực thi câu lệnh
        $stmt->execute();
    
        // Lấy kết quả
        $result = $stmt->get_result();
    
        // Kiểm tra nếu có giỏ hàng trả về
        if ($result->num_rows > 0) {
            // Lấy kết quả đầu tiên (vì LIMIT 1)
            $row = $result->fetch_assoc();
            
            // Tạo đối tượng Cart từ dữ liệu trả về
            $cart= new Cart($row['ID'], $row['USERID'], $row['QUANTITY']);  // Chỉnh lại các tên cột cho đúng
            return $cart;  // Chỉnh lại các tên cột cho đúng
        } else {
            // Trả về null nếu không tìm thấy giỏ hàng
            return null;
        }
    }
    
    public function getAllCarts() {
        $sql = "SELECT * FROM CARTS";
        $result = $this->conn->query($sql);
        $carts = [];

        while ($row = $result->fetch_assoc()) {
            $carts[] = new Cart($row['ID'], $row['USERID'], $row['QUANTITY']);
        }

        return $carts;
    }    

    // Thêm các phương thức khác như updateCart, deleteCart nếu cần
    public function updateCartQuantity($cartId, $totalQuantity) {
        $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $totalQuantity, $cartId);
        $stmt->execute();
        return $stmt->affected_rows > 0; // Trả về true nếu cập nhật thành công
    }
    public function deleteCart($cartId) {
        // Xóa các sản phẩm trong giỏ hàng trước
        $sqlDetails = "DELETE FROM cart_details WHERE cart_id = ?";
        $stmtDetails = $this->conn->prepare($sqlDetails);
        $stmtDetails->bind_param("i", $cartId);
        $stmtDetails->execute();
    
        // Xóa giỏ hàng
        $sqlCart = "DELETE FROM cart WHERE id = ?";
        $stmtCart =  $this->conn->prepare($sqlCart);
        $stmtCart->bind_param("i", $cartId);
        $stmtCart->execute();
        return $stmtCart->affected_rows > 0; // Trả về true nếu giỏ hàng được xóa thành công
    }
    
}
    


?>