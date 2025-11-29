{{-- FILE: resources/views/partials/user_dropdown.blade.php --}}

<div class="user-dropdown-menu hidden" style="
    position: absolute; 
    right: 0; 
    top: 55px; 
    width: 200px; 
    background: white; 
    border-radius: 8px; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: 1000;
">
    <div class="user-dropdown-header" style="padding: 10px 15px; border-bottom: 1px solid #eee;">
        <p style="font-weight: 600; margin: 0;">{{ Auth::user()->name }}</p>
        <span style="font-size: 13px; color: #666;">{{ Auth::user()->email }}</span>
    </div>
    
    <ul class="user-dropdown-list" style="list-style: none; padding: 0; margin: 0;">
        {{-- 1. Chỉnh sửa thông tin cá nhân --}}
        <li style="padding: 8px 15px;">
            <a href="{{ route('profile.edit') }}" style="text-decoration: none; color: #333; display: block; font-size: 1.4rem;">
                <i class="fa-regular fa-id-card" style="margin-right: 8px;"></i> Chỉnh sửa
            </a>
        </li>
        
        {{-- 2. Đăng xuất --}}
        <li style="padding: 8px 15px; border-top: 1px solid #eee;">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: #ff424f; display: block; font-weight: 600; font-size: 1.4rem;">
                <i class="fa-solid fa-right-from-bracket" style="margin-right: 8px;"></i> Đăng xuất
            </a>
        </li>
    </ul>

    {{-- Form ẩn để xử lý Logout (Dùng chung cho cả trang) --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    
</div>