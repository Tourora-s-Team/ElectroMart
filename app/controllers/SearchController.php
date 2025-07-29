<?php
require_once ROOT_PATH . '/app/models/Product.php';

class SearchController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function search()// Hàm xử lý tìm kiếm sản phẩm
    {
        $keyword = isset($_GET['q']) ? $_GET['q'] : '';
        $productModels = new Product();
        // Nếu không có từ khóa, gọi model hiển thị tất cả sản phẩm
        if ($keyword == '') {
            $products = $productModels->getAllProduct();
        }
        // Nếu có từ khóa, gọi model để thực hiện tìm kiếm theo từ khoá
        else if ($keyword) {
            $products = $productModels->searchProduct($keyword);

        } else {
            $products = [];
        }
        $this->view('/search', [
            'title' => 'ElectroMart - Linh kiện điện tử chất lượng',
            'products' => $products,

        ]);

    }


}
?>