{{-- FILE: resources/views/admin/partials/form_group.blade.php --}}
{{-- 
    Partial View này được thiết kế để nhận các tham số sau:
    - $label: Nhãn hiển thị cho trường.
    - $name: Thuộc tính 'name' (dùng cho validation và input).
    - $type: Loại input (text, number, password, email, textarea).
    - $value: Giá trị hiện tại (old() hoặc giá trị Model).
    - $required: true/false (Để thêm dấu *).
    - $rows: Số dòng (Chỉ dùng cho textarea).
--}}
@php
    // Đảm bảo các biến có giá trị mặc định để tránh lỗi Undefined
    $type = $type ?? 'text';
    $name = $name ?? '';
    $label = $label ?? '';
    $value = $value ?? old($name);
    $rows = $rows ?? 3;
    $isRequired = isset($required) && $required === true;
@endphp

<div class="form-group">
    <label for="{{ $name }}" class="form-label">
        {{ $label }} 
        @if($isRequired) 
            <span class="required">*</span>
        @endif
    </label>
    
    {{-- LOGIC HIỂN THỊ INPUT/TEXTAREA --}}
    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" class="form-control @error($name) is-invalid @enderror">{{ $value }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" 
               class="form-control @error($name) is-invalid @enderror" 
               value="{{ $value }}" 
               @if($isRequired) required @endif
        >
    @endif
    
    {{-- Hiển thị Lỗi Validation (Error Message) --}}
    @error($name) 
        <span class="input-error">{{ $message }}</span> 
    @enderror
</div>