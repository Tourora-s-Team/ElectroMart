<?php
// Import PHPMailer (chú ý dùng đúng đường dẫn)
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailController
{
    private $mailer;
    private $fromEmail;
    private $fromName = 'ElectroMart';

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->fromEmail = getenv('MAIL_USER'); // Lấy từ biến môi trường
        try {
            // Cấu hình SMTP Gmail
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->fromEmail;
            $this->mailer->Password = getenv('MAIL_PASSWORD');
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mailer->Port = 465;

            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = 'UTF-8';
            $this->mailer->Encoding = 'base64';
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $e->getMessage();
        }
    }

    // 1. Gửi email xác thực tài khoản
    public function sendVerificationEmail($toEmail, $toName, $verificationCode)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject = 'Xác minh địa chỉ email của bạn';

            $verificationLink = "http://localhosthttps://electromart-t8ou8.ondigitalocean.app/public/account/verify-email/" . urlencode($verificationCode);

            $this->mailer->Body = "
            <h2>Xin chào $toName,</h2>
            <p>Cảm ơn bạn đã đăng ký tài khoản tại ElectroMart.</p>
            <p>Vui lòng nhấn vào liên kết bên dưới để xác minh địa chỉ email của bạn:</p>
            <p><a href='$verificationLink'>$verificationLink</a></p>
            <p>Nếu bạn không thực hiện hành động này, hãy bỏ qua email.</p>
        ";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Gửi email xác minh thất bại: " . $e->getMessage());
            return false;
        }
    }



    // 2. Gửi email chào mừng
    public function sendWelcomeEmail($toEmail, $toName)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject = 'Chào mừng bạn đến với ElectroMart!';
            $this->mailer->Body = "
                <h2>Chào mừng $toName!</h2>
                <p>Cảm ơn bạn đã tạo tài khoản tại ElectroMart.</p>
                <p>Hãy khám phá các sản phẩm và ưu đãi hấp dẫn dành cho bạn!</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Welcome email failed: " . $e->getMessage());
            return false;
        }
    }

    // 3. Gửi email thông báo đơn hàng mới
    public function sendOrderNotificationEmail($toEmail, $toName, $orderDetails)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject = 'Xác nhận đơn hàng mới từ ElectroMart';

            $orderHtml = "<ul>";
            foreach ($orderDetails['items'] as $item) {
                $orderHtml .= "<li>{$item['name']} - {$item['quantity']} x " . number_format($item['price']) . " VND</li>";
            }
            $orderHtml .= "</ul>";

            $this->mailer->Body = "
                <h2>Xin chào $toName,</h2>
                <p>Bạn vừa đặt hàng thành công tại ElectroMart. Thông tin đơn hàng:</p>
                $orderHtml
                <p><strong>Tổng cộng:</strong> " . number_format($orderDetails['total']) . " VND</p>
                <p>Cảm ơn bạn đã mua sắm cùng chúng tôi!</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Order email failed: " . $e->getMessage());
            return false;
        }
    }
}
