<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Payment
{
    public function getProductsByIds($productIds = [])
    {
        if (empty($productIds))
            return [];

        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "SELECT * FROM product WHERE ProductID IN ($placeholders)";
        $db = new HandleData();
        return $db->getDataWithParams($sql, $productIds);
    }

}
?>