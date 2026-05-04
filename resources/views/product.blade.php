@extends('layouts.app')

@section('title', 'Sản phẩm')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/product-filter.css') }}">
@endpush

@section('content')
    @include('home.product-all', ['showFilter' => true])
@endsection