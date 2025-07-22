<?php
require_once ROOT_PATH . '/app/models/Product.php';

class HomeController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }
    public function index()
    {
        $productModels = new Product();

        // Lấy cả products và productImages
        $products = $productModels->getAllProduct();
        $this->view('/home', [
            'title' => 'ElectroMart - Linh kiện điện tử chất lượng',
            'products' => $products,
        ]);
    }
}
?>