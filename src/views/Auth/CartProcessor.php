<?php

class CartProcessor
{
    private $cartController;
    private $cartDetailController;
    private $productController;

    public function __construct($cartController, $cartDetailController, $productController)
    {
        $this->cartController = $cartController;
        $this->cartDetailController = $cartDetailController;
        $this->productController = $productController;
    }

    // Phương thức xử lý giỏ hàng
    public function getCart($userId,)
    {
        // Lấy thông tin giỏ hàng
        $cart = $this->cartController->getCartByUser($userId);

        if (!$cart) {
            return null; // Không có giỏ hàng
        } else return $cart;
    }
    // Lấy thông tin chi tiết giỏ hàng
    public function getCartDetails($userId)
    {
        $cart = $this->getCart($userId);
        $cartDetail = $this->cartDetailController->getCartDetailByCartId($cart->getId());
        if (!$cartDetail) {
            return null; // Không có chi tiết giỏ hàng
        } else return $cartDetail;
    }
    // Lấy thông tin sản phẩm trong giỏ hàng
    public function getProductsInCart($userId)
    {
        $cartDetail = $this->getCartDetails($userId);
        $products = [];
        if ($cartDetail != null) {

            foreach ($cartDetail as $detail) {
                $productId = $detail->getProductId();
                $products[] = [
                    'product' => $this->productController->getProductById($productId),
                    'quantity' => $detail->getQuantity()
                ];
            }
        }
        return $products;
    }
    // Tính tổng tiền
    public function calculateTotalPrice($userId)
    {
        $products = $this->getProductsInCart($userId);
        $totalPrice = 0;
        if ($products != null) {
            foreach ($products as $entry) {
                $item = $entry['product'];
                $totalPrice += $item->getPrice() * $entry['quantity'];
            }
        }
        return $totalPrice;
    }

    public function calculateTotalQuantity($userId)
    {
        $products = $this->getProductsInCart($userId);
        $totalQuantity = 0;
        if ($products != null) {
            foreach ($products as $entry) {
                $totalQuantity += $entry['quantity'];
            }
        }
        return $totalQuantity;
    }
    //
    public function countProductTypesInCart($userId)
    {
        $cartDetails = $this->getCartDetails($userId);
        if (!$cartDetails) {
            return 0;
        }
        return count($cartDetails); // Mỗi chi tiết là 1 loại sản phẩm
    }

    public function clearCart($userId)
    {
        // Kết nối đến cơ sở dữ liệu
        $db = (new DatabaseConnection())->getConnection();

        // Xóa tất cả sản phẩm trong giỏ hàng của người dùng
        $stmt = $db->prepare("DELETE FROM CARTDETAILS WHERE CARTID IN (SELECT ID FROM CARTS WHERE USERID = ?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
}
