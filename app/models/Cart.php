<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Cart
{

    function __construct()
    {

    }
    function getProductCart($userID)//hàm lấy tất cả sản phẩm trong giỏ hàng của người dùng
    {
        $cartID = $this->getCartID($userID);
        $handleData = new HandleData();
        $sql = "SELECT p.ProductName, pi.ImageURL, p.Price, ci.Quantity, ci.CartID, ci.ProductID, p.StockQuantity, p.ShopID
                FROM product p
                     JOIN cartitem ci ON ci.ProductID = p.ProductID
                     JOIN cart c ON c.CartID = ci.CartID
                     LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
                WHERE (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL) AND ci.CartID = :cartID AND c.UserID = :userID;";
        $params = ['cartID' => $cartID, 'userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;

    }
    function getCartID($userID)//hàm lấy CartID của người dùng
    {
        $handleData = new HandleData();
        $sql = "SELECT CartID FROM cart WHERE UserID = :userID";
        $params = ['userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['CartID'] : null;
    }

    public function getShopID($productID)//hàm lấy ShopID của sản phẩm
    {
        $handleData = new HandleData();
        $sql = 'SELECT s.ShopID FROM product p
                JOIN shop s ON p.ShopID = s.ShopID
                WHERE p.ProductID = :productID';
        $params = ['productID' => $productID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['ShopID'] : null;
    }
    public function addProductCart($cartId, $productId, $quantity, $shopId)//hàm thêm sản phẩm vào giỏ hàng
    {
        $handleData = new HandleData();
        if ($this->isProductInCart($cartId, $productId) > 0) {
            $quantity += $this->isProductInCart($cartId, $productId);// Cộng thêm số lượng nếu sản phẩm đã có trong giỏ hàng
            $sql = "UPDATE cartitem 
            SET Quantity = :quantity 
            WHERE CartID = :cartId AND ProductID = :productId";
            $params = [
                'cartId' => $cartId,
                'productId' => $productId,
                'quantity' => $quantity,
            ];
            $handleData->execDataWithParams($sql, $params);
        } else {
            $sql = "INSERT INTO cartitem (CartID, ProductID, Quantity, ShopID) VALUES (:cartId, :productId, :quantity, :shopId)";
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
        $sql = "DELETE FROM cartitem WHERE CartID = :cartItemId AND ProductID = :productId";
        $params = [
            'cartItemId' => $cartItemId,
            'productId' => $productId
        ];
        $handleData->execDataWithParams($sql, $params);
    }
    public function updateQuantityCart($cartId, $productId, $quantity)//hàm cập nhật số lượng sản phẩm trong giỏ hàng
    {
        $handleData = new HandleData();
        $sql = "UPDATE cartitem 
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
        $sql = "SELECT Quantity FROM cartitem WHERE CartID = :cartId AND ProductID = :productId";
        $params = [
            'cartId' => $cartId,
            'productId' => $productId
        ];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['Quantity'] : 0;
    }
}
?>