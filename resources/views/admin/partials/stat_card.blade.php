{{-- FILE: resources/views/admin/partials/stat_card.blade.php --}}
{{-- Nhận các biến: $title, $value, $icon, $color (để thay đổi màu sắc) --}}

<div class="stat-card stat-card--{{ $color }}">
    <div class="stat-card__icon-wrapper">
        <i class="fa-solid {{ $icon }} stat-card__icon"></i>
    </div>
    <div class="stat-card__content">
        <p class="stat-card__title">{{ $title }}</p>
        <h3 class="stat-card__value">{{ $value }}</h3>
    </div>
</div>