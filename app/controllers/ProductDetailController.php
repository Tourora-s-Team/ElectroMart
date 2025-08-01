<?php
require_once ROOT_PATH . '/app/models/Product.php';

class ProductDetailController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function showDetail($id)// Hàm hiển thị chi tiết sản phẩm
    {
        $productModels = new Product();
        // Lấy thông tin chi tiết sản phẩm theo ID
        $product = $productModels->getProductById($id);
        $productModels->updateRatingProduct($id);
        $reviewCount = $productModels->countReviewProduct($id);
        $reviewComment = $productModels->getReviewComment($id);
        if (!$product) {
            // Nếu không tìm thấy sản phẩm, có thể hiển thị thông báo lỗi hoặc chuyển hướng
            header('Location: /electromart-o63e5.ondigitalocean.app/public/home');
            exit;
        }

        $productRelated = $productModels->getRelatedProduct($product['CategoryID']);
        // Hiển thị trang chi tiết sản phẩm
        $this->view('/product-detail', [
            'title' => 'Chi tiết sản phẩm - ' . htmlspecialchars($product['ProductName']),
            'product' => $product,
            'reviewCount' => $reviewCount,
            'reviewComment' => $reviewComment,
            'productRelated' => $productRelated,
        ]);

    }
    public function submitReview()// Hàm xử lý việc gửi đánh giá sản phẩm
    {
        $rating = $_POST['rating'] ?? null;
        $comment = $_POST['comment'] ?? '';
        $productId = $_POST['product_id'] ?? null;
        $shopId = $_POST['shop_id'] ?? null;
        $userId = $_SESSION['user'][0]['UserID']; // nếu có đăng nhập

        $productModels = new Product();

        if (!isset($userId)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: /electromart-o63e5.ondigitalocean.app/public/account/signin');
            exit;
        } else {
            if ($rating && $productId) {
                $productModels->addReviewComment($rating, $comment, $productId, $shopId, $userId);
                header('Location: /electromart-o63e5.ondigitalocean.app/public/product-detail/' . $productId);
                exit;
            } else {
                // Xử lý lỗi nếu không có rating hoặc productId
                echo "Vui lòng cung cấp đầy đủ thông tin đánh giá.";
            }
        }
    }

}
?>