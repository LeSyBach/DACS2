{{-- FILE: resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin | @yield('title') - TechStore</title>
    
    {{-- CSS CHUNG --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">


    @stack('styles')
</head>
<body>
    <div id="admin-wrapper">
        
        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar') 
        
        <div id="content-wrapper">
            {{-- HEADER (Menu Bar) --}}
            @include('admin.partials.header') 

            <main class="admin-main-content">
                {{-- KHU VỰC NỘI DUNG CHÍNH --}}
                <div class="container-fluid admin-content-padding">
                    @yield('content')
                </div>
            </main>
            
            {{-- FOOTER --}}
            @include('admin.partials.footer') 
        </div>
    </div>
    
    {{-- JS CHUNG --}}
    @stack('scripts')
</body>
</html>