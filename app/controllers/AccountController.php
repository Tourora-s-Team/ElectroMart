<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../models/Customer.php");

class AccountController
{
    private $userID;
    private $user;
    private $customer;
    private $userData;
    private $customerData;

    public function __construct()
    {
        $this->userID = $_SESSION["user"][0]["UserID"];
        $this->user = new User();
        $this->customer = new Customer();

        // Lấy userId từ session, nếu không có thì null
        $userId = $_SESSION['user'][0]['UserID'] ?? null;
        if ($userId != null) {
            $this->userData = $this->user->getUserData($userId);
            $this->customerData = $this->customer->getCustomerById($userId);
        } else {
            $this->userData = null;
            $this->customerData = null;
        }
    }

    private function isUserLoggedIn()
    {
        // Nếu người dùng chưa đăng nhập hoặc đang truy cập với quyền admin thì chuyển hướng đến trang đăng nhập và trả về false
        if ($this->userData == null || in_array($_SESSION["user"][0]["Role"], ['Admin'])) {
            header("Location: /electromart/public/account/signin");
            return false;
        }
        return true;
    }

    public function info()
    {
        // Gọi hàm để kiểm tra tình trạng đăng nhập
        if ($this->isUserLoggedIn() === false) {
            return;
        }
        $userData = $this->userData;
        $customerData = $this->customerData;
        $this->userData = $this->user->getUserData($this->userID);
        $this->customerData = $this->customer->getCustomerById($this->userID);
        require_once(__DIR__ . "/../views/account_manager/account_info.php");
    }

    public function updateInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $dateOfBirth = $_POST['date-of-birth'];
            $birthDateFormatted = DateTime::createFromFormat('d/m/Y', $dateOfBirth)->format('Y-m-d');


            // Cập nhật thông tin người dùng
            $this->user->updateUser($this->userID, $email, $phone);
            $this->customer->updateCustomer($this->userID, $name, $gender, $birthDateFormatted);

            // Sau khi cập nhật, lấy lại dữ liệu mới
            $this->userData = $this->user->getUserData($this->userID);
            $this->customerData = $this->customer->getCustomerById($this->userID);
            $_SESSION['message'] = "Cập nhật thông tin tài khoản thành công";
            $_SESSION['status_type'] = "success";
            header("Location: /electromart/public/account/info");
            exit();
        } else {
            $_SESSION['message'] = "Cập nhật thông tin tài khoản thất bại.";
            $_SESSION['status_type'] = "error";
            header("Location: /electromart/public/account/info");
            exit();
        }
    }

    function convertOrderDetailToArray($orderDetailObj)
    {
        return [
            'OrderID' => $orderDetailObj->getOrderID(),
            'ProductID' => $orderDetailObj->getProductID(),
            'Quantity' => $orderDetailObj->getQuantity(),
            'UnitPrice' => $orderDetailObj->getUnitPrice(),
            'ShopID' => $orderDetailObj->getShopID(),
        ];
    }

    public function orderHistory()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        require_once(__DIR__ . "/../models/OrderDetail.php");
        $odModel = new OrderDetail();
        $orders = $odModel->getAllOrderIdByUserId($this->userID);

        $isEmptyOrders;
        if (empty($orders)) {
            $isEmptyOrders = true;
        } else {
            $isEmptyOrders = false;
            $numOfOrders = count($orders);
        }

        require_once(__DIR__ . "/../views/account_manager/order_history.php");
    }

    public function receiverInfo()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }
        require_once(__DIR__ . "/../models/Receiver.php");

        // Lấy danh sách người nhận hàng
        $receiverModel = new Receiver();
        $receiverList = $receiverModel->getAllReceiversByUserId($this->userID);

        $customerData = $this->customerData;

        if (empty($receiverList)) {
            $receiverList = null; // Nếu không có người nhận nào, gán là null
        }
        require_once(__DIR__ . "/../views/account_manager/receiver_info.php");
    }

    public function getReceiver($id)
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        require_once(__DIR__ . "/../models/Receiver.php");
        $receiverModel = new Receiver();

        // Lấy người nhận hàng theo ID
        $receiver = $receiverModel->getReceiverById($id);

        if ($receiver) {
            http_response_code(200);
            echo json_encode($receiver);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Receiver not found']);
        }
        exit();
    }
    public function addReceiver()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        require_once(__DIR__ . "/../models/Receiver.php");
        $receiverModel = new Receiver();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /electromart/public/account/receiver-info");
            exit();
        }

        // Lấy dữ liệu từ form
        $receiverName = $_POST['ReceiverName'] ?? '';
        $contactNumber = $_POST['ContactNumber'] ?? '';
        $addressDetail = $_POST['AddressDetail'] ?? '';
        $street = $_POST['Street'] ?? '';
        $ward = $_POST['Ward'] ?? '';
        $city = $_POST['City'] ?? '';
        $country = $_POST['Country'] ?? 'Vietnam';
        $note = $_POST['note'] ?? '';

        // Thêm người nhận hàng mới
        $result = $receiverModel->addReceiver([
            'UserId' => $this->userID,
            'ReceiverName' => $receiverName,
            'ContactNumber' => $contactNumber,
            'AddressDetail' => $addressDetail,
            'Street' => $street,
            'Ward' => $ward,
            'City' => $city,
            'Country' => $country,
            'Note' => $note,
            'isDefault' => 0
        ]);

        if ($result) {
            $_SESSION['message'] = "Thêm dữ liệu người nhận thành công.";
            $_SESSION['status_type'] = "success";
            header("Location: /electromart/public/account/receiver-info");
            exit();
        } else {
            $_SESSION['message'] = "Cập nhật dữ liệu người nhận thất bại.";
            $_SESSION['status_type'] = "error";
        }
    }

    public function updateReceiver()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        require_once(__DIR__ . "/../models/Receiver.php");
        $receiverModel = new Receiver();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /electromart/public/account/receiver-info");
            exit();
        }

        // Lấy dữ liệu từ form
        $receiverID = $_POST['ReceiverID'] ?? '';
        $receiverName = $_POST['ReceiverName'] ?? '';
        $contactNumber = $_POST['ContactNumber'] ?? '';
        $addressDetail = $_POST['AddressDetail'] ?? '';
        $street = $_POST['Street'] ?? '';
        $ward = $_POST['Ward'] ?? '';
        $city = $_POST['City'] ?? '';
        $country = $_POST['Country'] ?? 'Vietnam';
        $note = $_POST['note'] ?? '';

        if (!empty($receiverID)) {
            $res = $receiverModel->updateReceiver($receiverID, [
                'UserId' => $this->userID,
                'ReceiverName' => $receiverName,
                'ContactNumber' => $contactNumber,
                'AddressDetail' => $addressDetail,
                'Street' => $street,
                'Ward' => $ward,
                'City' => $city,
                'Country' => $country,
                'Note' => $note
            ]);

            if ($res) {
                $_SESSION['message'] = "Cập nhật dữ liệu người nhận thành công.";
                $_SESSION['status_type'] = "success";
                header("Location: /electromart/public/account/receiver-info");
                exit();
            }
        } else {
            $_SESSION['message'] = "Cập nhật dữ liệu người nhận thất bại.";
            $_SESSION['status_type'] = "error";
        }


    }

    public function deleteReceiver($id)
    {
        // Ngăn không cho output HTML khác
        ob_clean();

        if (!$this->isUserLoggedIn()) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        header('Content-Type: application/json; charset=utf-8');
        require_once(__DIR__ . "/../models/Receiver.php");
        $receiverModel = new Receiver();

        // Xóa người nhận hàng theo ID
        $result = $receiverModel->deleteReceiverById($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Receiver deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete receiver']);
        }
        exit();
    }

    public function setDefaultReceiver($receiverID)
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        require_once(__DIR__ . "/../models/Receiver.php");
        $receiverModel = new Receiver();

        // Cập nhật người nhận hàng mặc định
        $result = $receiverModel->setDefaultReceiver($this->userID, $receiverID);

        if ($result) {
            $_SESSION['message'] = "Đặt địa chỉ mặc định thành công.";
            $_SESSION['status_type'] = "success";
        } else {
            $_SESSION['message'] = "Đặt địa chỉ mặc định thất bại.";
            $_SESSION['status_type'] = "error";
        }
        header("Location: /electromart/public/account/receiver-info");
        exit();
    }

    public function security()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }
        require_once(__DIR__ . "/../views/account_manager/security.php");
    }

    public function changePassword()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Kiểm tra mật khẩu hiện tại
            if ($this->user->checkPassword($this->userID, $currentPassword)) {
                // Kiểm tra mật khẩu mới và xác nhận
                if ($newPassword === $confirmPassword) {
                    // Cập nhật mật khẩu
                    $this->user->updatePassword($this->userID, $newPassword);
                    $_SESSION['message'] = "Đổi mật khẩu thành công.";
                    $_SESSION['status_type'] = "success";
                } else {
                    $_SESSION['message'] = "Mật khẩu mới và xác nhận không khớp.";
                    $_SESSION['status_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Mật khẩu hiện tại không đúng.";
                $_SESSION['status_type'] = "error";
            }
            header("Location: /electromart/public/account/security");
            exit();
        }
    }

    public function wishList()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        require_once(__DIR__ . "/../models/WishList.php");
        require_once(__DIR__ . "/../models/Product.php");

        $wishListModel = new WishList();
        $productModel = new Product();

        // Lấy danh sách ID sản phẩm yêu thích
        $wishListIDs = $wishListModel->getAllProductIDByUserId($this->userID);

        if (empty($wishListIDs)) {
            $isEmptyWishList = true;
            $favoriteProducts = [];
            $numOfProducts = 0;
        } else {
            $isEmptyWishList = false;

            // wishListIDs có dạng: [0][ProductID => 1, ProductID => 2, ...]
            // Dùng array_column để trích xuất mảng ProductID từ kết quả
            $productIDs = array_column($wishListIDs, 'ProductID');

            // Lấy chi tiết sản phẩm theo ID
            $favoriteProducts = $productModel->getProductsWithImagesByIDs($productIDs);
            $numOfProducts = count($favoriteProducts);
        }

        require_once(__DIR__ . "/../views/account_manager/wish_list.php");
    }

    public function deleteWishList($id)
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        require_once(__DIR__ . "/../models/WishList.php");
        $wishListModel = new WishList();

        // Xóa sản phẩm khỏi danh sách yêu thích
        $result = $wishListModel->removeItemById($id, $this->userID);

        if ($result) {
            $_SESSION['message'] = "Đã xóa sản phẩm khỏi danh sách yêu thích.";
            $_SESSION['status_type'] = "success";
        } else {
            $_SESSION['message'] = "Xóa sản phẩm khỏi danh sách yêu thích thất bại.";
            $_SESSION['status_type'] = "error";
        }
        header("Location: /electromart/public/account/wish-list");
        exit();
    }

    public function addWishList($id)
    {
        if (!$this->isUserLoggedIn()) {
            http_response_code(401);
            echo json_encode(['message' => 'Chưa đăng nhập']);
            return;
        }

        require_once(__DIR__ . "/../models/WishList.php");
        $wishListModel = new WishList();

        $res = $wishListModel->addItem($id, $this->userID);
        if ($res === false) {
            http_response_code(500);
            return;
        }else {
            http_response_code(200);
            return;
        }
    }

}
?>