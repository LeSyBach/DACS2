@extends('layouts.app')

@section('title', 'Trang chủ - TechStore')

@section('content')
    
    <div class="sidebar"></div>
    @include('home.hero')
    @include('home.category-section')
    @include('home.featured-products')
    @include('home.product-all', ['showFilter' => false])

@endsection