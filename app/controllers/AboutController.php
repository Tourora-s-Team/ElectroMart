<?php
class AboutController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    // Hiển thị trang về chúng tôi
    public function index()
    {
        $this->view('about/index', [
            'title' => 'Về chúng tôi - ElectroMart'
        ]);
    }

    // Hiển thị trang liên hệ
    public function contact()
    {
        $this->view('about/contact', [
            'title' => 'Liên hệ - ElectroMart'
        ]);
    }

    // Xử lý form liên hệ
    public function submitContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            // Validate dữ liệu
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $_SESSION['message'] = 'Vui lòng điền đầy đủ thông tin';
                $_SESSION['status_type'] = 'error';
            } else {
                // Xử lý gửi email hoặc lưu vào database
                // Tạm thời chỉ hiển thị thông báo thành công
                $_SESSION['message'] = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.';
                $_SESSION['status_type'] = 'success';
            }

            header('Location: https://electromart.online/public/about/contact');
            exit;
        }
    }
}
?>