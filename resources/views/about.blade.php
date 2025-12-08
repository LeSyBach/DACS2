{{-- FILE: resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', 'Giới thiệu về chúng tôi')

@section('content')
<div class="about-page">
    {{-- HERO SECTION --}}
    <section class="about-hero">
        <div class="grid wide">
            <div class="about-hero__content">
                <h1 class="about-hero__title">Về Chúng Tôi</h1>
                <p class="about-hero__subtitle">Nơi mang đến những sản phẩm chất lượng cao cho cuộc sống của bạn</p>
            </div>
        </div>
    </section>

    {{-- STORY SECTION --}}
    <section class="about-story">
        <div class="grid wide">
            <div class="row">
                <div class="col l-6 m-12 c-12">
                    <div class="about-story__image">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800" alt="Cửa hàng của chúng tôi">
                    </div>
                </div>
                <div class="col l-6 m-12 c-12">
                    <div class="about-story__content">
                        <h2 class="section-title">
                            <i class="fas fa-store"></i>
                            Câu Chuyện Của Chúng Tôi
                        </h2>
                        <p class="about-text">
                            Được thành lập từ năm 2020, chúng tôi bắt đầu với niềm đam mê mang đến những sản phẩm chất lượng cao cho khách hàng Việt Nam. Từ một cửa hàng nhỏ, chúng tôi đã không ngừng phát triển và trở thành một trong những địa chỉ mua sắm tin cậy.
                        </p>
                        <p class="about-text">
                            Với đội ngũ nhân viên nhiệt tình và giàu kinh nghiệm, chúng tôi cam kết mang đến trải nghiệm mua sắm tuyệt vời nhất. Sự hài lòng của bạn chính là động lực để chúng tôi không ngừng phát triển và hoàn thiện.
                        </p>
                        <div class="story-highlights">
                            <div class="highlight-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Sản phẩm chính hãng 100%</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Giao hàng toàn quốc</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- VALUES SECTION --}}
    <section class="about-values">
        <div class="grid wide">
            <h2 class="section-title center">
                <i class="fas fa-gem"></i>
                Tại Sao Chọn Chúng Tôi?
            </h2>
            
            <div class="row">
                <div class="col l-3 m-6 c-12">
                    <div class="value-card">
                        <div class="value-card__icon value-card__icon--primary">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="value-card__title">Chất Lượng Đảm Bảo</h3>
                        <p class="value-card__desc">100% sản phẩm chính hãng, có tem chống hàng giả</p>
                    </div>
                </div>
                
                <div class="col l-3 m-6 c-12">
                    <div class="value-card">
                        <div class="value-card__icon value-card__icon--success">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="value-card__title">Giao Hàng Nhanh</h3>
                        <p class="value-card__desc">Vận chuyển nhanh chóng trong 24-48h toàn quốc</p>
                    </div>
                </div>
                
                <div class="col l-3 m-6 c-12">
                    <div class="value-card">
                        <div class="value-card__icon value-card__icon--warning">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h3 class="value-card__title">Đổi Trả Dễ Dàng</h3>
                        <p class="value-card__desc">Chính sách đổi trả linh hoạt trong vòng 7 ngày</p>
                    </div>
                </div>
                
                <div class="col l-3 m-6 c-12">
                    <div class="value-card">
                        <div class="value-card__icon value-card__icon--info">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="value-card__title">Hỗ Trợ 24/7</h3>
                        <p class="value-card__desc">Đội ngũ tư vấn nhiệt tình sẵn sàng hỗ trợ bạn</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="about-stats">
        <div class="grid wide">
            <div class="row">
                <div class="col l-3 m-6 c-6">
                    <div class="stat-box">
                        <div class="stat-box__icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="stat-box__number">10,000+</div>
                        <div class="stat-box__label">Sản Phẩm</div>
                    </div>
                </div>
                
                <div class="col l-3 m-6 c-6">
                    <div class="stat-box">
                        <div class="stat-box__icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-box__number">50,000+</div>
                        <div class="stat-box__label">Khách Hàng</div>
                    </div>
                </div>
                
                <div class="col l-3 m-6 c-6">
                    <div class="stat-box">
                        <div class="stat-box__icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-box__number">100,000+</div>
                        <div class="stat-box__label">Đơn Hàng</div>
                    </div>
                </div>
                
                <div class="col l-3 m-6 c-6">
                    <div class="stat-box">
                        <div class="stat-box__icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-box__number">4.8★</div>
                        <div class="stat-box__label">Đánh Giá</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TEAM SECTION - 2 FOUNDERS --}}
    <section class="about-team">
        <div class="grid wide">
            <h2 class="section-title center">
                <i class="fas fa-user-tie"></i>
                Đội Ngũ Sáng Lập
            </h2>
            <p class="section-subtitle center">Những người đã xây dựng nên thành công của chúng tôi</p>
            
            <div class="row justify-center">
                <div class="col l-4 m-6 c-12">
                    <div class="team-card">
                        <div class="team-card__image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="CEO">
                        </div>
                        <div class="team-card__info">
                            <h3 class="team-card__name">Nguyễn Văn A</h3>
                            <p class="team-card__position">CEO & Co-Founder</p>
                            <p class="team-card__desc">10 năm kinh nghiệm trong lĩnh vực thương mại điện tử và quản lý chuỗi cung ứng</p>
                            <div class="team-card__social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col l-4 m-6 c-12">
                    <div class="team-card">
                        <div class="team-card__image">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400" alt="COO">
                        </div>
                        <div class="team-card__info">
                            <h3 class="team-card__name">Trần Thị B</h3>
                            <p class="team-card__position">COO & Co-Founder</p>
                            <p class="team-card__desc">Chuyên gia vận hành với 8 năm kinh nghiệm trong ngành bán lẻ và dịch vụ khách hàng</p>
                            <div class="team-card__social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="about-cta">
        <div class="grid wide">
            <div class="cta-box">
                <div class="cta-box__icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 class="cta-box__title">Sẵn Sàng Trải Nghiệm?</h2>
                <p class="cta-box__text">Khám phá hàng ngàn sản phẩm chất lượng với giá tốt nhất thị trường</p>
                <div class="cta-box__buttons">
                    <a href="{{ route('product') }}" class="btn-cta btn-cta--primary">
                        <i class="fas fa-shopping-cart"></i> Mua Sắm Ngay
                    </a>
                    <a href="{{ route('contact') }}" class="btn-cta btn-cta--outline">
                        <i class="fas fa-phone"></i> Liên Hệ
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('css')
<style>
/* ======================================================== */
/* ABOUT PAGE - MODERN & CLEAN */
/* ======================================================== */

:root {
    --primary-color: #009688;
    --primary-dark: #00796b;
    --primary-light: #e0f2f1;
    --success-color: #4caf50;
    --warning-color: #ff9800;
    --info-color: #2196f3;
    --text-dark: #2c3e50;
    --text-light: #6c757d;
    --text-muted: #95a5a6;
    --border-color: #e0e0e0;
    --bg-light: #f8f9fa;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.1);
    --shadow-lg: 0 8px 32px rgba(0,0,0,0.12);
}

.about-page {
    background: #fff;
}

/* ===== HERO SECTION ===== */
.about-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    padding: 120px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,96C1248,75,1344,53,1392,42.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom center no-repeat;
    opacity: 0.3;
}

.about-hero__content {
    position: relative;
    z-index: 1;
}

.about-hero__title {
    font-size: 56px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #fff;
    letter-spacing: -1px;
}

.about-hero__subtitle {
    font-size: 20px;
    color: rgba(255,255,255,0.95);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* ===== STORY SECTION ===== */
.about-story {
    padding: 100px 0;
}

.about-story__image img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
}

.about-story__content {
    padding-left: 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

.section-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.section-title.center {
    justify-content: center;
}

.section-title i {
    color: var(--primary-color);
    font-size: 32px;
}

.section-subtitle {
    font-size: 16px;
    color: var(--text-light);
    text-align: center;
    margin-bottom: 50px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.about-text {
    font-size: 16px;
    line-height: 1.8;
    color: var(--text-light);
    margin-bottom: 20px;
}

.story-highlights {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 16px;
    color: var(--text-dark);
    font-weight: 500;
}

.highlight-item i {
    color: var(--primary-color);
    font-size: 20px;
}

/* ===== VALUES SECTION ===== */
.about-values {
    padding: 100px 0;
    background: var(--bg-light);
}

.value-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    height: 100%;
    border: 2px solid transparent;
}

.value-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
}

.value-card__icon {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    transition: all 0.3s ease;
}

.value-card__icon--primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
}

.value-card__icon--success {
    background: linear-gradient(135deg, #4caf50, #388e3c);
}

.value-card__icon--warning {
    background: linear-gradient(135deg, #ff9800, #f57c00);
}

.value-card__icon--info {
    background: linear-gradient(135deg, #2196f3, #1976d2);
}

.value-card__icon i {
    font-size: 36px;
    color: #fff;
}

.value-card:hover .value-card__icon {
    transform: scale(1.1) rotate(5deg);
}

.value-card__title {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 12px;
}

.value-card__desc {
    font-size: 15px;
    color: var(--text-light);
    line-height: 1.6;
}

/* ===== STATS SECTION ===== */
.about-stats {
    padding: 80px 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    position: relative;
    overflow: hidden;
}

.about-stats::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.stat-box {
    text-align: center;
    color: #fff;
    padding: 20px;
    position: relative;
    z-index: 1;
}

.stat-box__icon {
    font-size: 48px;
    margin-bottom: 20px;
    opacity: 0.9;
}

.stat-box__number {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: -1px;
}

.stat-box__label {
    font-size: 16px;
    font-weight: 400;
    opacity: 0.95;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ===== TEAM SECTION ===== */
.about-team {
    padding: 100px 0;
}

.row.justify-center {
    justify-content: center;
}

.team-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all 0.4s ease;
    height: 100%;
}

.team-card:hover {
    transform: translateY(-12px);
    box-shadow: var(--shadow-lg);
}

.team-card__image {
    width: 100%;
    height: 320px;
    overflow: hidden;
    position: relative;
}

.team-card__image::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
}

.team-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.4s ease;
}

.team-card:hover .team-card__image img {
    transform: scale(1.1);
}

.team-card__info {
    padding: 30px 25px;
    text-align: center;
}

.team-card__name {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.team-card__position {
    font-size: 15px;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.team-card__desc {
    font-size: 14px;
    color: var(--text-light);
    line-height: 1.6;
    margin-bottom: 20px;
}

.team-card__social {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.team-card__social a {
    width: 40px;
    height: 40px;
    background: var(--bg-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
    transition: all 0.3s ease;
    font-size: 16px;
}

.team-card__social a:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-3px);
}

/* ===== CTA SECTION ===== */
.about-cta {
    padding: 100px 0;
    background: var(--bg-light);
}

.cta-box {
    background: #fff;
    border-radius: 24px;
    padding: 80px 60px;
    text-align: center;
    box-shadow: var(--shadow-lg);
    max-width: 900px;
    margin: 0 auto;
}

.cta-box__icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    box-shadow: 0 10px 30px rgba(0,150,136,0.3);
}

.cta-box__icon i {
    font-size: 48px;
    color: #fff;
}

.cta-box__title {
    font-size: 42px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 20px;
    letter-spacing: -1px;
}

.cta-box__text {
    font-size: 18px;
    color: var(--text-light);
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-box__buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 40px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-cta--primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #fff;
    box-shadow: 0 4px 15px rgba(0,150,136,0.3);
}

.btn-cta--primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,150,136,0.4);
}

.btn-cta--outline {
    background: transparent;
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-cta--outline:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-3px);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1023px) {
    .about-story__content {
        padding-left: 0;
        margin-top: 40px;
    }
}

@media (max-width: 739px) {
    .about-hero {
        padding: 80px 0;
    }
    
    .about-hero__title {
        font-size: 36px;
    }
    
    .about-hero__subtitle {
        font-size: 16px;
    }
    
    .about-story,
    .about-values,
    .about-team,
    .about-cta {
        padding: 60px 0;
    }
    
    .section-title {
        font-size: 28px;
        justify-content: center;
    }
    
    .about-story__image img {
        height: 300px;
    }
    
    .cta-box {
        padding: 50px 30px;
    }
    
    .cta-box__title {
        font-size: 28px;
    }
    
    .cta-box__text {
        font-size: 16px;
    }
    
    .cta-box__buttons {
        flex-direction: column;
    }
    
    .btn-cta {
        width: 100%;
        justify-content: center;
    }
    
    .about-stats {
        padding: 60px 0;
    }
    
    .stat-box__number {
        font-size: 36px;
    }
}
</style>
@endpush