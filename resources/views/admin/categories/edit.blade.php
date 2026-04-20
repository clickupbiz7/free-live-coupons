{{-- =================================================== --}}
{{-- FILE: resources/views/admin/categories/edit.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')
@include('admin.categories.form', ['category' => $category])
@endsection