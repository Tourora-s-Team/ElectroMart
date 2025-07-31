<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class MailController
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Cấu hình SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['MAIL_USER'];
        $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
        $this->mailer->SMTPSecure = 'ssl';
        $this->mailer->Port = 465;

        // Cấu hình người gửi
        $this->mailer->setFrom($_ENV['MAIL_USER'], 'ElectroMart');
        $this->mailer->isHTML(true); // Gửi dạng HTML
    }

    /**
     * Gửi email xác thực
     */
    public function sendVerificationEmail($toEmail, $toName, $verificationCode)
    {
        try {
            $this->mailer->clearAddresses(); // Xóa địa chỉ trước đó
            $this->mailer->addAddress($toEmail, $toName);

            $this->mailer->Subject = 'Xác thực tài khoản';
            $this->mailer->Body = "
                <h2>Xin chào $toName,</h2>
                <p>Vui lòng xác thực tài khoản của bạn bằng mã sau:</p>
                <h3 style='color: blue;'>$verificationCode</h3>
                <p>Hoặc nhấn vào liên kết sau để xác thực:</p>
                <a href='https://yourdomain.com/verify.php?code=$verificationCode'>Xác thực ngay</a>
            ";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Lỗi gửi email: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public function sendWelcomeEmail($toEmail, $toName)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject = "Chào mừng bạn đến với ElectroMart!";

            $this->mailer->Body = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: auto;'>
                <h2 style='color: #2e6c80;'>🎉 Chào mừng $toName!</h2>
                <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>ElectroMart</strong>.</p>

                <p>Chúng tôi rất vui khi có bạn đồng hành. Bạn giờ đây đã có thể:</p>
                <ul>
                    <li>📦 Theo dõi đơn hàng và lịch sử mua hàng</li>
                    <li>🛒 Nhận các ưu đãi độc quyền</li>
                    <li>📬 Nhận thông báo sản phẩm mới</li>
                </ul>

                <p>Hãy <a href='https://trieuthien-official.id.vn/' style='color: #1a73e8;'>đăng nhập</a> để bắt đầu ngay!</p>

                <hr>
                <p style='font-size: 0.9em; color: #666;'>Nếu bạn có bất kỳ câu hỏi nào, hãy liên hệ với chúng tôi qua email: <a href='mailto:support@trieuthien-official.id.vn'>support@trieuthien-official.id.vn</a>.</p>
                <p style='font-size: 0.9em; color: #999;'>Chúc bạn một ngày tuyệt vời!<br>Đội ngũ Triệu Thiên Official</p>
            </div>
        ";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            echo 'Lỗi gửi email: ' . $this->mailer->ErrorInfo;
            return false;
        }
    }


}
