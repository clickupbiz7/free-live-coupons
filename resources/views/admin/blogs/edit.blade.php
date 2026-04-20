{{-- =================================================== --}}
{{-- FILE: resources/views/admin/blogs/edit.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')
@include('admin.blogs.form', ['blog' => $blog])
@endsection