<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Cart
{

    function __construct()
    {

    }
    function getProductCart($userID)
    {
        $cartID = $this->getCartID($userID);
        $handleData = new HandleData();

        $sql = "SELECT p.*, ci.*, c.*, pi.ImageID, pi.ImageURL, pi.IsThumbnail, s.*
            FROM Product p
                 JOIN CartItem ci ON ci.ProductID = p.ProductID AND ci.ShopID = p.ShopID
                 JOIN Cart c ON c.CartID = ci.CartID
                 LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND p.ShopID = pi.ShopID AND pi.IsThumbnail = 1
                 JOIN Shop s ON p.ShopID = s.ShopID
            WHERE ci.CartID = :cartID AND c.UserID = :userID;";

        $params = ['cartID' => $cartID, 'userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;
    }

    function getCartID($userID)//hàm lấy CartID của người dùng
    {
        $handleData = new HandleData();
        $sql = "SELECT CartID FROM Cart WHERE UserID = :userID";
        $params = ['userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['CartID'] : null;
    }

    public function getShopID($productID)//hàm lấy ShopID của sản phẩm
    {
        $handleData = new HandleData();
        $sql = 'SELECT s.ShopID FROM Product p
                JOIN Shop s ON p.ShopID = s.ShopID
                WHERE p.ProductID = :productID';
        $params = ['productID' => $productID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['ShopID'] : null;
    }

    // Thêm giỏ hàng mới cho người dùng nếu chưa có
    public function createCart($userID)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO Cart (UserID, LastUpdate, Status) 
            VALUES (:userID, NOW(3), 'Active')";

        $params = ['userID' => $userID];
        $handleData->execDataWithParams($sql, $params);

        return $this->getCartID($userID); // Trả về CartID mới tạo
    }

    public function addProductCart($cartId, $productId, $quantity, $shopId)//hàm thêm sản phẩm vào giỏ hàng
    {
        $handleData = new HandleData();
        if ($this->isProductInCart($cartId, $productId) > 0) {
            $quantity += $this->isProductInCart($cartId, $productId);// Cộng thêm số lượng nếu sản phẩm đã có trong giỏ hàng
            $sql = "UPDATE CartItem 
            SET Quantity = :quantity 
            WHERE CartID = :cartId AND ProductID = :productId";
            $params = [
                'cartId' => $cartId,
                'productId' => $productId,
                'quantity' => $quantity,
            ];
            $handleData->execDataWithParams($sql, $params);
        } else {
            $sql = "INSERT INTO CartItem (CartID, ProductID, Quantity, ShopID) VALUES (:cartId, :productId, :quantity, :shopId)";
            $params = [
                'cartId' => $cartId,
                'productId' => $productId,
                'quantity' => $quantity,
                'shopId' => $shopId,
            ];
            $handleData->execDataWithParams($sql, $params);
        }
    }
    public function removeProductCart($cartItemId, $productId)//hàm xóa sản phẩm khỏi giỏ hàng
    {
        $handleData = new HandleData();
        $sql = "DELETE FROM CartItem WHERE CartID = :cartItemId AND ProductID = :productId";
        $params = [
            'cartItemId' => $cartItemId,
            'productId' => $productId
        ];
        $handleData->execDataWithParams($sql, $params);
    }
    public function updateQuantityCart($cartId, $productId, $quantity)//hàm cập nhật số lượng sản phẩm trong giỏ hàng
    {
        $handleData = new HandleData();
        $sql = "UPDATE CartItem
            SET Quantity = :quantity
            WHERE CartID = :cartId AND ProductID = :productId";
        $params = [
            'cartId' => $cartId,
            'productId' => $productId,
            'quantity' => $quantity,
        ];
        $handleData->execDataWithParams($sql, $params);
    }
    public function isProductInCart($cartId, $productId)//hàm kiểm tra sản phẩm đã có trong giỏ hàng hay chưa
    {
        $handleData = new HandleData();
        $sql = "SELECT Quantity FROM CartItem WHERE CartID = :cartId AND ProductID = :productId";
        $params = [
            'cartId' => $cartId,
            'productId' => $productId
        ];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['Quantity'] : 0;
    }
    public function cartCount($userID)
    {
        $cartId = $this->getCartID($userID);
        $handleData = new HandleData();

        $sql = "SELECT COUNT(ProductID) AS total FROM CartItem 
            INNER JOIN Cart ON CartItem.CartID = Cart.CartID 
            WHERE Cart.CartID = :cartId";
        $params = [
            'cartId' => $cartId
        ];

        $result = $handleData->getDataWithParams($sql, $params);

        if (!empty($result) && isset($result[0]['total'])) {
            return (int) $result[0]['total'];
        }

        return 0;
    }

}
?>