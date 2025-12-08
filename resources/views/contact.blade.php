{{-- FILE: resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Liên hệ với chúng tôi')

@section('content')
<div class="contact-page">
    {{-- HERO SECTION --}}
    <section class="contact-hero">
        <div class="grid wide">
            <div class="contact-hero__content">
                <h1 class="contact-hero__title">Liên hệ với chúng tôi</h1>
                <p class="contact-hero__subtitle">Chúng tôi luôn sẵn sàng hỗ trợ bạn. Hãy liên hệ với TechStore để được tư vấn và giải đáp mọi thắc mắc về sản phẩm và dịch vụ.</p>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="contact-main">
        <div class="grid wide">
            <div class="row">
                {{-- FORM SECTION --}}
                <div class="col l-7 m-12 c-12">
                    <div class="contact-form-card">
                        <h2 class="contact-form__title">
                            <i class="far fa-comment-dots"></i>
                            Gửi tin nhắn cho chúng tôi
                        </h2>

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                            @csrf
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <label for="name" class="form-label">Họ và tên <span class="required">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Nguyễn Văn A"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-col">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           placeholder="0901234567"
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="required">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="example@email.com"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="subject" class="form-label">Chủ đề <span class="required">*</span></label>
                                <input type="text" 
                                       name="subject" 
                                       id="subject" 
                                       class="form-control @error('subject') is-invalid @enderror" 
                                       placeholder="Tư vấn sản phẩm, hỗ trợ kỹ thuật..."
                                       value="{{ old('subject') }}"
                                       required>
                                @error('subject')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="message" class="form-label">Nội dung tin nhắn <span class="required">*</span></label>
                                <textarea name="message" 
                                          id="message" 
                                          rows="6" 
                                          class="form-control @error('message') is-invalid @enderror" 
                                          placeholder="Mô tả chi tiết yêu cầu của bạn..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i>
                                Gửi tin nhắn
                            </button>
                        </form>
                    </div>
                </div>

                {{-- INFO SECTION --}}
                <div class="col l-5 m-12 c-12">
                    {{-- CONTACT INFO --}}
                    <div class="contact-info-card">
                        <h3 class="contact-info__title">Thông tin liên hệ</h3>
                        
                        <div class="info-item">
                            <div class="info-item__icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-item__content">
                                <h4>Điện thoại</h4>
                                <p>+84 901 234 567</p>
                                <p>+84 901 234 568</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item__icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-item__content">
                                <h4>E-mail</h4>
                                <p>contact@techstore.vn</p>
                                <p>support@techstore.vn</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item__icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-item__content">
                                <h4>Địa chỉ</h4>
                                <p>123 Đường Nguyễn Huệ</p>
                                <p>Quận 1, TP. Hồ Chí Minh</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item__icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-item__content">
                                <h4>Giờ làm việc</h4>
                                <p>Thứ 2 - Thứ 6: 8:00 - 18:00</p>
                                <p>Thứ 7 - CN: 9:00 - 17:00</p>
                            </div>
                        </div>
                    </div>

                    {{-- QUICK SUPPORT --}}
                    <div class="quick-support-card">
                        <h3 class="quick-support__title">Hỗ trợ nhanh</h3>
                        
                        <a href="tel:1900-1234" class="support-btn support-btn--hotline">
                            <i class="fas fa-phone"></i>
                            <span>Gọi hotline: 1900-1234</span>
                        </a>

                        <a href="#" class="support-btn support-btn--chat">
                            <i class="fas fa-comments"></i>
                            <span>Trò chuyện trực tuyến</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ SECTION --}}
    <section class="contact-faq">
        <div class="grid wide">
            <h2 class="section-title">Câu hỏi thường gặp</h2>
            <p class="section-subtitle">Tìm câu trả lời nhanh chóng cho những câu hỏi phổ biến nhất</p>

            <div class="row">
                <div class="col l-6 m-12 c-12">
                    <div class="faq-item">
                        <h3 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            Làm thế nào để theo dõi đơn hàng?
                        </h3>
                        <p class="faq-answer">Bạn có thể theo dõi đơn hàng bằng cách đăng nhập vào tài khoản và truy cập mục "Đơn hàng của tôi".</p>
                    </div>
                </div>

                <div class="col l-6 m-12 c-12">
                    <div class="faq-item">
                        <h3 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            Chính sách trả lại như thế nào?
                        </h3>
                        <p class="faq-answer">Chúng tôi hỗ trợ trả lại toàn bộ trong vòng 7 ngày kể từ khi nhận hàng với sản phẩm điều kiện còn nguyên seal.</p>
                    </div>
                </div>

                <div class="col l-6 m-12 c-12">
                    <div class="faq-item">
                        <h3 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            Sản phẩm có bảo hành không?
                        </h3>
                        <p class="faq-answer">Tất cả sản phẩm đều được bảo hành chính hãng từ 12-24 tháng tùy theo từng sản phẩm.</p>
                    </div>
                </div>

                <div class="col l-6 m-12 c-12">
                    <div class="faq-item">
                        <h3 class="faq-question">
                            <i class="fas fa-question-circle"></i>
                            Hỗ trợ thanh toán trực tuyến?
                        </h3>
                        <p class="faq-answer">Có, chúng tôi hỗ trợ thanh toán qua ZaloPay, MoMo và các thẻ Visa/Mastercard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MAP SECTION (Optional) --}}
    <section class="contact-map">
        <div class="grid wide">
            <h2 class="section-title">Vị trí của chúng tôi</h2>
            <div class="map-wrapper">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2443.5197434518554!2d108.25335632080157!3d15.976075216777728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142108997dc971f%3A0x1295cb3d313469c9!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiB2w6AgVHJ1eeG7gW4gdGjDtG5nIFZp4buHdCAtIEjDoG4sIMSQ4bqhaSBo4buNYyDEkMOgIE7hurVuZw!5e1!3m2!1svi!2s!4v1765175779223!5m2!1svi!2s" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</div>
@endsection

@push('css')
<style>
/* ======================================================== */
/* CONTACT PAGE STYLES */
/* ======================================================== */

:root {
    --primary: #009688;
    --primary-dark: #00796b;
    --primary-light: #e0f2f1;
    --success: #4caf50;
    --text-dark: #2c3e50;
    --text-light: #6c757d;
    --border: #e0e0e0;
    --bg-light: #f8f9fa;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.1);
}

.contact-page {
    background: #fff;
}

/* ===== HERO SECTION ===== */
.contact-hero {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 80px 0 60px;
    text-align: center;
    color: #fff;
}

.contact-hero__title {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 15px;
}

.contact-hero__subtitle {
    font-size: 16px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    opacity: 0.95;
}

/* ===== MAIN SECTION ===== */
.contact-main {
    padding: 80px 0;
    background: var(--bg-light);
}

/* ===== FORM CARD ===== */
.contact-form-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: var(--shadow-md);
    margin-bottom: 30px;
}

.contact-form__title {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.contact-form__title i {
    color: var(--primary);
    font-size: 26px;
}

/* Alert */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert i {
    font-size: 20px;
}

/* Form */
.contact-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-col {
    display: flex;
    flex-direction: column;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.required {
    color: #dc3545;
}

.form-control {
    padding: 14px 16px;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #fff;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(0, 150, 136, 0.1);
}

.form-control::placeholder {
    color: #aaa;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.error-message {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

textarea.form-control {
    resize: vertical;
    font-family: inherit;
}

.btn-submit {
    padding: 16px 40px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 12px rgba(0, 150, 136, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 150, 136, 0.4);
}

/* ===== INFO CARD ===== */
.contact-info-card {
    background: #fff;
    border-radius: 16px;
    padding: 35px 30px;
    box-shadow: var(--shadow-md);
    margin-bottom: 25px;
}

.contact-info__title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 30px;
}

.info-item {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    padding-bottom: 25px;
    border-bottom: 1px solid var(--border);
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-item__icon {
    width: 50px;
    height: 50px;
    background: var(--primary-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-item__icon i {
    font-size: 22px;
    color: var(--primary);
}

.info-item__content h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.info-item__content p {
    font-size: 14px;
    color: var(--text-light);
    margin: 0;
    line-height: 1.6;
}

/* ===== QUICK SUPPORT CARD ===== */
.quick-support-card {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 16px;
    padding: 30px;
    box-shadow: var(--shadow-md);
}

.quick-support__title {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 20px;
}

.support-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    background: #fff;
    border-radius: 8px;
    text-decoration: none;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.support-btn:last-child {
    margin-bottom: 0;
}

.support-btn--hotline {
    color: var(--primary);
}

.support-btn--chat {
    color: var(--success);
}

.support-btn:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.support-btn i {
    font-size: 20px;
}

.support-btn span {
    font-weight: 600;
    font-size: 15px;
}

/* ===== FAQ SECTION ===== */
.contact-faq {
    padding: 80px 0;
    background: #fff;
}

.section-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-dark);
    text-align: center;
    margin-bottom: 15px;
}

.section-subtitle {
    font-size: 16px;
    color: var(--text-light);
    text-align: center;
    margin-bottom: 50px;
}

.faq-item {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.faq-item:hover {
    box-shadow: var(--shadow-sm);
    transform: translateY(-2px);
}

.faq-question {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.faq-question i {
    color: var(--primary);
    font-size: 20px;
}

.faq-answer {
    font-size: 15px;
    color: var(--text-light);
    line-height: 1.6;
    margin: 0;
}

/* ===== MAP SECTION ===== */
.contact-map {
    padding: 80px 0;
    background: var(--bg-light);
}

.map-wrapper {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    margin-top: 30px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1023px) {
    .contact-info-card,
    .quick-support-card {
        margin-top: 30px;
    }
}

@media (max-width: 739px) {
    .contact-hero {
        padding: 60px 0 40px;
    }
    
    .contact-hero__title {
        font-size: 32px;
    }
    
    .contact-hero__subtitle {
        font-size: 14px;
    }
    
    .contact-main,
    .contact-faq,
    .contact-map {
        padding: 50px 0;
    }
    
    .contact-form-card {
        padding: 25px 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .section-title {
        font-size: 28px;
    }
    
    .btn-submit {
        width: 100%;
    }
}
</style>
@endpush