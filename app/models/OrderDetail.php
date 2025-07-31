<?php
class OrderDetail
{
    private $OrderID;
    private $ProductID;
    private $Quantity;
    private $UnitPrice;
    private $ShopID;

    public function __construct($OrderID = null, $ProductID = null, $Quantity = null, $UnitPrice = null, $ShopID = null)
    {
        $this->OrderID = $OrderID;
        $this->ProductID = $ProductID;
        $this->Quantity = $Quantity;
        $this->UnitPrice = $UnitPrice;
        $this->ShopID = $ShopID;
    }

    public function getOrderID()
    {
        return $this->OrderID;
    }

    public function getProductID()
    {
        return $this->ProductID;
    }
    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function getUnitPrice()
    {
        return $this->UnitPrice;
    }

    public function getShopID()
    {
        return $this->ShopID;
    }

    public function getOrderDetails()
    {
        return [
            'OrderID' => $this->OrderID,
            'ProductID' => $this->ProductID,
            'Quantity' => $this->Quantity,
            'UnitPrice' => $this->UnitPrice,
            'ShopID' => $this->ShopID
        ];
    }
    public function getOrderDetailsByOrderId($orderId)
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM OrderDetail WHERE OrderID = :orderId";
        $params = [':orderId' => $orderId];
        $res = $handleData->getDataWithParams($sql, $params);

        $result = []; // Trả về mảng các OrderDetail
        foreach ($res as $row) {
            $result[] = new OrderDetail(
                $row['OrderID'],
                $row['ProductID'],
                $row['Quantity'],
                $row['UnitPrice'],
                $row['ShopID']
            );
        }

        return $result;
    }
    public function getAllOrderIdByUserId($userId)
    {
        $handleData = new HandleData();
        $jsonString = $handleData->callProcedureWithOutParam("GetOrdersByUserId", [$userId]);

        $data = json_decode($jsonString, true);

        if ($data === null) {
            $_SESSION['message'] = "JSON decode failed: " . json_last_error_msg();
        } 
        else {
            return $data;
        }
    }


}

?>