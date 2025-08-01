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

<section class="about-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Về ElectroMart</h1>
            <p>Chúng tôi là đối tác tin cậy trong việc cung cấp linh kiện điện tử chất lượng cao</p>
        </div>
    </div>
</section>

<section class="about-story">
    <div class="container">
        <div class="story-grid">
            <div class="story-content">
                <h2>Câu chuyện của chúng tôi</h2>
                <p>ElectroMart được thành lập với sứ mệnh mang đến những sản phẩm linh kiện điện tử chất lượng cao với
                    giá cả hợp lý cho mọi người. Từ những ngày đầu khởi nghiệp, chúng tôi đã không ngừng nỗ lực để trở
                    thành một trong những cửa hàng linh kiện điện tử uy tín nhất.</p>

                <p>Với đội ngũ kỹ thuật viên giàu kinh nghiệm và am hiểu sâu về công nghệ, chúng tôi luôn sẵn sàng tư
                    vấn và hỗ trợ khách hàng tìm được những sản phẩm phù hợp nhất với nhu cầu của mình.</p>

                <div class="highlight-stats">
                    <div class="stat-item">
                        <div class="stat-number">5000+</div>
                        <div class="stat-label">Khách hàng tin tưởng</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">10000+</div>
                        <div class="stat-label">Sản phẩm chất lượng</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Hỗ trợ khách hàng</div>
                    </div>
                </div>
            </div>

            <div class="story-image">
                <img src="https://electromart-t8ou8.ondigitalocean.app/public/images/logo-main.png"
                    alt="Về ElectroMart">
            </div>
        </div>
    </div>
</section>

<section class="mission-vision">
    <div class="container">
        <div class="mv-grid">
            <div class="mv-item">
                <div class="mv-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Sứ mệnh</h3>
                <p>Cung cấp những sản phẩm linh kiện điện tử chất lượng cao, chính hãng với dịch vụ khách hàng tốt nhất.
                    Chúng tôi cam kết mang đến giá trị thực sự cho mỗi khách hàng.</p>
            </div>

            <div class="mv-item">
                <div class="mv-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Tầm nhìn</h3>
                <p>Trở thành cửa hàng linh kiện điện tử hàng đầu Việt Nam, được khách hàng tin tưởng và lựa chọn. Chúng
                    tôi hướng tới việc mở rộng ra toàn quốc trong tương lai gần.</p>
            </div>

            <div class="mv-item">
                <div class="mv-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Giá trị cốt lõi</h3>
                <p>Chất lượng - Uy tín - Tận tâm. Chúng tôi luôn đặt lợi ích khách hàng lên hàng đầu và không ngừng cải
                    thiện chất lượng sản phẩm và dịch vụ.</p>
            </div>
        </div>
    </div>
</section>

<section class="team-section">
    <div class="container">
        <div class="section-header">
            <h2>Đội ngũ của chúng tôi</h2>
            <p>Những con người tài năng và tận tâm đứng sau thành công của ElectroMart</p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <div class="member-image">
                    <img src="https://electromart-t8ou8.ondigitalocean.app/public/images/member.png" alt="CEO">
                </div>
                <div class="member-info">
                    <h4>Lâm Triệu Thiên</h4>
                    <p class="position">Người sáng lập</p>
                    <p class="description">Với hơn 10 năm kinh nghiệm trong ngành điện tử, anh A đã xây dựng ElectroMart
                        từ một cửa hàng nhỏ thành một thương hiệu uy tín.</p>
                </div>
            </div>

            <div class="team-member">
                <div class="member-image">
                    <img src="https://electromart-t8ou8.ondigitalocean.app/public/images/member.png" alt="CTO">
                </div>
                <div class="member-info">
                    <h4>Lê Công Bằng</h4>
                    <p class="position">Người sáng lập</p>
                    <p class="description">Chuyên gia công nghệ với kinh nghiệm phát triển hệ thống e-commerce và quản
                        lý chuỗi cung ứng hiện đại.</p>
                </div>
            </div>

            <div class="team-member">
                <div class="member-image">
                    <img src="https://electromart-t8ou8.ondigitalocean.app/public/images/member.png"
                        alt="Sales Manager">
                </div>
                <div class="member-info">
                    <h4>Đỗ Thành Đạt</h4>
                    <p class="position">Người sáng lập</p>
                    <p class="description">Quản lý đội ngũ bán hàng chuyên nghiệp, luôn sẵn sàng tư vấn và hỗ trợ khách
                        hàng tìm được sản phẩm phù hợp.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="why-choose-us">
    <div class="container">
        <div class="section-header">
            <h2>Tại sao chọn ElectroMart?</h2>
        </div>

        <div class="reasons-grid">
            <div class="reason-item">
                <div class="reason-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h4>Sản phẩm chính hãng</h4>
                <p>100% sản phẩm chính hãng, có nguồn gốc xuất xứ rõ ràng và được bảo hành đầy đủ.</p>
            </div>

            <div class="reason-item">
                <div class="reason-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h4>Giao hàng nhanh chóng</h4>
                <p>Giao hàng trong 24h tại TP.HCM và các tỉnh thành lớn. Miễn phí ship cho đơn hàng trên 500k.</p>
            </div>

            <div class="reason-item">
                <div class="reason-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h4>Hỗ trợ kỹ thuật</h4>
                <p>Đội ngũ kỹ thuật chuyên nghiệp sẵn sàng hỗ trợ và tư vấn 24/7.</p>
            </div>

            <div class="reason-item">
                <div class="reason-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h4>Giá cả cạnh tranh</h4>
                <p>Cam kết giá tốt nhất thị trường với nhiều chương trình khuyến mãi hấp dẫn.</p>
            </div>

            <div class="reason-item">
                <div class="reason-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Bảo hành uy tín</h4>
                <p>Chế độ bảo hành chính hãng lên đến 24 tháng, đổi trả trong 7 ngày.</p>
            </div>

            <div class="reason-item">
                <div class="reason-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Cộng đồng lớn mạnh</h4>
                <p>Hơn 5000 khách hàng tin tưởng và lựa chọn, với đánh giá 5 sao trên các nền tảng.</p>
            </div>
        </div>
    </div>
</section>

<section class="contact-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Bạn có câu hỏi nào không?</h2>
            <p>Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
            <div class="cta-buttons">
                <a href="https://electromart-t8ou8.ondigitalocean.app/public/about/contact" class="btn btn-primary">Liên
                    hệ
                    ngay</a>
                <a href="tel:+84123456789" class="btn btn-outline">Gọi hotline</a>
            </div>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<style>
    .about-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
    }

    .hero-content h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .hero-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .about-story {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .story-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .story-content h2 {
        font-size: 2.2rem;
        margin-bottom: 25px;
        color: #333;
    }

    .story-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #666;
        margin-bottom: 20px;
    }

    .highlight-stats {
        display: flex;
        gap: 30px;
        margin-top: 40px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .story-image img {
        width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .mission-vision {
        padding: 80px 0;
        background: white;
    }

    .mv-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
    }

    .mv-item {
        text-align: center;
        padding: 40px 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .mv-item:hover {
        transform: translateY(-10px);
    }

    .mv-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
    }

    .mv-icon i {
        font-size: 2rem;
        color: white;
    }

    .mv-item h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #333;
    }

    .mv-item p {
        color: #666;
        line-height: 1.6;
    }

    .team-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-header h2 {
        font-size: 2.2rem;
        margin-bottom: 15px;
        color: #333;
    }

    .section-header p {
        font-size: 1.1rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
    }

    .team-member {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .team-member:hover {
        transform: translateY(-5px);
    }

    .member-image {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #667eea;
    }

    .member-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .member-info h4 {
        font-size: 1.3rem;
        margin-bottom: 5px;
        color: #333;
    }

    .position {
        color: #667eea;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .description {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .why-choose-us {
        padding: 80px 0;
        background: white;
    }

    .reasons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .reason-item {
        padding: 30px;
        text-align: center;
        border-radius: 12px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .reason-item:hover {
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .reason-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .reason-icon i {
        font-size: 1.8rem;
        color: white;
    }

    .reason-item h4 {
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #333;
    }

    .reason-item p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .contact-cta {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-align: center;
    }

    .cta-content h2 {
        font-size: 2.2rem;
        margin-bottom: 15px;
    }

    .cta-content p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 30px;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 15px 30px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: white;
        color: #667eea;
    }

    .btn-primary:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-outline:hover {
        background: white;
        color: #667eea;
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.2rem;
        }

        .story-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .highlight-stats {
            flex-direction: column;
            gap: 20px;
        }

        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn {
            min-width: 200px;
        }
    }
</style>