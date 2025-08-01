<?php
include ROOT_PATH . '/app/views/layouts/header.php';
?>

<div id="toast-container"></div>
<?php if (!empty($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast("<?= addslashes($_SESSION['message']) ?>", '<?= $_SESSION['status_type'] ?>');
        });
    </script>
<?php endif;
unset($_SESSION['message']);
unset($_SESSION['status_type']); ?>

<section class="contact-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="/electromart/public/">Trang chủ</a>
            <span>/</span>
            <a href="/electromart/public/about">Về chúng tôi</a>
            <span>/</span>
            <span>Liên hệ</span>
        </div>
        <h1>Liên hệ với chúng tôi</h1>
        <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
    </div>
</section>

<section class="contact-info">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Địa chỉ</h3>
                <p>123 Đường ABC, Quận 1<br>TP. Hồ Chí Minh, Việt Nam</p>
            </div>

            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Điện thoại</h3>
                <p>Hotline: <a href="tel:+84123456789">0123 456 789</a><br>
                    Hỗ trợ: <a href="tel:+84987654321">0987 654 321</a></p>
            </div>

            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email</h3>
                <p>Tổng đài: <a href="mailto:info@electromart.vn">info@electromart.vn</a><br>
                    Hỗ trợ: <a href="mailto:support@electromart.vn">support@electromart.vn</a></p>
            </div>

            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Giờ làm việc</h3>
                <p>Thứ 2 - Thứ 6: 8:00 - 17:30<br>
                    Thứ 7 - CN: 8:00 - 12:00</p>
            </div>
        </div>
    </div>
</section>

<section class="contact-form-section">
    <div class="container">
        <div class="form-grid">
            <div class="form-content">
                <h2>Gửi tin nhắn cho chúng tôi</h2>
                <p>Nếu bạn có bất kỳ câu hỏi hoặc góp ý nào, hãy điền vào form bên dưới và chúng tôi sẽ phản hồi sớm
                    nhất có thể.</p>

                <form action="/electromart/public/about/submit-contact" method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Họ và tên *</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Chủ đề *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Chọn chủ đề</option>
                            <option value="product-inquiry">Hỏi về sản phẩm</option>
                            <option value="order-support">Hỗ trợ đơn hàng</option>
                            <option value="technical-support">Hỗ trợ kỹ thuật</option>
                            <option value="warranty">Bảo hành</option>
                            <option value="partnership">Hợp tác kinh doanh</option>
                            <option value="feedback">Góp ý</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Nội dung *</label>
                        <textarea id="message" name="message" rows="6" required
                            placeholder="Nhập nội dung tin nhắn của bạn..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        Gửi tin nhắn
                    </button>
                </form>
            </div>

            <div class="map-container">
                <h3>Vị trí của chúng tôi</h3>
                <div class="map-placeholder">
                    <!-- Google Maps embed would go here -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4326002877653!2d106.69729831462052!3d10.776530392316638!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3c99fa9f%3A0x6b129e6d6bd1d59f!2zMTIzIMSQ4buTbmcgS2hvaSUyQyBRdeG6rW4gMSUyQyBU4bqjbiBUcmUgQ2hpbWVyYW!5e0!3m2!1svi!2svn!4v1623123456789!5m2!1svi!2svn"
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

                <div class="social-links">
                    <h4>Theo dõi chúng tôi</h4>
                    <div class="social-icons">
                        <a href="#" class="social-link facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link zalo">
                            <i class="fas fa-comment"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2>Câu hỏi thường gặp</h2>
            <p>Một số câu hỏi phổ biến từ khách hàng</p>
        </div>

        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Làm thế nào để đặt hàng?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Bạn có thể đặt hàng trực tiếp trên website bằng cách thêm sản phẩm vào giỏ hàng và thanh toán,
                        hoặc gọi điện trực tiếp cho chúng tôi qua hotline.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Thời gian giao hàng bao lâu?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Thời gian giao hàng trong nội thành TP.HCM là 1-2 ngày, các tỉnh thành khác từ 2-5 ngày tùy theo
                        địa điểm.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Chính sách bảo hành như thế nào?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Tất cả sản phẩm đều được bảo hành chính hãng từ 12-24 tháng tùy theo từng sản phẩm. Chúng tôi hỗ
                        trợ đổi trả trong 7 ngày đầu nếu có lỗi.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Có hỗ trợ kỹ thuật không?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Có, chúng tôi có đội ngũ kỹ thuật chuyên nghiệp hỗ trợ 24/7 qua hotline, email và chat online.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<script>
    function toggleFaq(element) {
        const faqItem = element.parentElement;
        const answer = faqItem.querySelector('.faq-answer');
        const icon = element.querySelector('i');

        // Close all other FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem) {
                item.classList.remove('active');
                item.querySelector('.faq-answer').style.maxHeight = '0';
                item.querySelector('.faq-question i').style.transform = 'rotate(0deg)';
            }
        });

        // Toggle current FAQ item
        faqItem.classList.toggle('active');

        if (faqItem.classList.contains('active')) {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        } else {
            answer.style.maxHeight = '0';
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>

<style>
    .contact-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0 60px;
    }

    .breadcrumb {
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb a:hover {
        color: white;
    }

    .breadcrumb span {
        margin: 0 10px;
        color: rgba(255, 255, 255, 0.6);
    }

    .contact-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .contact-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .contact-info {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .contact-item {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .contact-item:hover {
        transform: translateY(-5px);
    }

    .contact-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .contact-icon i {
        font-size: 1.8rem;
        color: white;
    }

    .contact-item h3 {
        font-size: 1.3rem;
        margin-bottom: 15px;
        color: #333;
    }

    .contact-item p {
        color: #666;
        line-height: 1.6;
    }

    .contact-item a {
        color: #667eea;
        text-decoration: none;
    }

    .contact-item a:hover {
        text-decoration: underline;
    }

    .contact-form-section {
        padding: 60px 0;
        background: white;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
    }

    .form-content h2 {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #333;
    }

    .form-content p {
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .contact-form {
        max-width: 100%;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .submit-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .map-container h3 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    .map-placeholder {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .social-links h4 {
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #333;
    }

    .social-icons {
        display: flex;
        gap: 15px;
    }

    .social-link {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .social-link:hover {
        transform: translateY(-3px);
    }

    .social-link.facebook {
        background: #3b5998;
    }

    .social-link.instagram {
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    }

    .social-link.youtube {
        background: #ff0000;
    }

    .social-link.zalo {
        background: #0068ff;
    }

    .faq-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-header h2 {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #333;
    }

    .section-header p {
        color: #666;
        font-size: 1.1rem;
    }

    .faq-grid {
        max-width: 800px;
        margin: 0 auto;
    }

    .faq-item {
        background: white;
        border-radius: 12px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s ease;
    }

    .faq-question:hover {
        background: #f8f9fa;
    }

    .faq-question h4 {
        font-size: 1.1rem;
        color: #333;
        margin: 0;
    }

    .faq-question i {
        color: #667eea;
        transition: transform 0.3s ease;
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .faq-answer p {
        padding: 0 25px 20px;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .contact-hero h1 {
            font-size: 2rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>