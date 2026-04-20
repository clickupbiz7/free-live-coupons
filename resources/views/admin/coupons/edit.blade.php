{{-- =================================================== --}}
{{-- FILE: resources/views/admin/coupons/edit.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')
@include('admin.coupons.form', ['coupon' => $coupon])
@endsection