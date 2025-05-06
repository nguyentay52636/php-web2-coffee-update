<?php
include_once __DIR__ . "/../config/DatabaseConnection.php";
include_once __DIR__ . "/../models/User.php"; // Đảm bảo bạn đã định nghĩa model User
include_once __DIR__ . "/../models/Order.php";
class UserController
{
    private $connection;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM USERS";
        $result = $this->connection->query($sql);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User(
                    $row['ID'],
                    $row['ACCOUNTID'],
                    $row['FULLNAME'],
                    $row['ADDRESS'],
                    $row['PHONE'],
                    $row['EMAIL'],
                    $row['DATEOFBIRTH']
                );
                $users[] = $user;
            }
        }
        return $users;
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM USERS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row['ID'],
                $row['ACCOUNTID'],
                $row['FULLNAME'],
                $row['ADDRESS'],
                $row['PHONE'],
                $row['EMAIL'],
                $row['DATEOFBIRTH']
            );
        }
        return null;
    }
    public function getUserByAccountId($id)
    {
        $sql = "SELECT * FROM USERS WHERE ACCOUNTID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row['ID'],
                $row['ACCOUNTID'],
                $row['FULLNAME'],
                $row['ADDRESS'],
                $row['PHONE'],
                $row['EMAIL'],
                $row['DATEOFBIRTH']
            );
        }
        return null;
    }
    public function createUser($accountId)
    {
        $sql = "INSERT INTO USERS (ID, ACCOUNTID) VALUES (?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $accountId, $accountId);
        if ($stmt->execute()) {
            return $this->connection->insert_id; // Trả về ID của user vừa tạo
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }

    public function updateUser(User $user)
    {
        $sql = "UPDATE USERS SET ACCOUNTID = ?, FULLNAME = ?, ADDRESS = ?, PHONE = ?, EMAIL = ?, DATEOFBIRTH = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isssssi", $user->getAccountId(), $user->getFullName(), $user->getAddress(), $user->getPhone(), $user->getEmail(), $user->getDateOfBirth(), $user->getId());

        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        try {
            // Bắt đầu transaction
            $this->connection->begin_transaction();

            // 1. Xoá chi tiết giỏ hàng (CARTDETAILS) liên quan tới các giỏ hàng (CARTS) của user
            $sql = "DELETE cd 
                    FROM CARTDETAILS cd 
                    INNER JOIN CARTS c ON cd.CARTID = c.ID 
                    WHERE c.USERID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // 2. Xoá các giỏ hàng (CARTS) của user
            $sql = "DELETE FROM CARTS WHERE USERID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // 3. Xoá chi tiết đơn hàng (ORDERDETAILS) dựa trên đơn hàng của user
            $sql = "DELETE od 
                    FROM ORDERDETAILS od 
                    INNER JOIN ORDERS o ON od.ORDERID = o.ID 
                    WHERE o.USERID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // 4. Xoá các đơn hàng (ORDERS) của user
            $sql = "DELETE FROM ORDERS WHERE USERID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // 5. Xoá các đánh giá sản phẩm của user (PRODUCTREVIEWS)
            $sql = "DELETE FROM PRODUCTREVIEWS WHERE USERID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // 6. Cuối cùng, xoá bản ghi user ở bảng USERS
            $sql = "DELETE FROM USERS WHERE ID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // Nếu có các bảng khác cần xử lý dữ liệu liên quan, hãy xoá theo thứ tự phù hợp trước.

            // Cam kết transaction
            $this->connection->commit();
            json_encode(array("status" => "success", "message" => ""));
            return true;
        } catch (Exception $e) {
            // Nếu có lỗi, rollback toàn bộ transaction
            $this->connection->rollback();
            json_encode(array("error" => $e->getMessage()));
            return false;
        }
    }


    public function __destruct()
    {
        $this->connection->close();
    }

    public function getOrderByAccountId($userId)
    {
        $sql = "SELECT * FROM ORDERS WHERE USERID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $order = new Order(
                    $row['ID'],
                    $row['USERID'],
                    $row['TOTAL'],
                    $row['DATEOFORDER'],
                    $row['ORDERSTATUS'],
                    $row['DISCOUNTID'],
                    $row['PRICEBEFOREDISCOUNT'],
                );
                $orders[] = $order;
            }
        }
        return $orders;
    }
}
