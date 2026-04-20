{{-- =================================================== --}}
{{-- FILE: resources/views/admin/stores/edit.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')
@include('admin.stores.form', ['store' => $store])
@endsection