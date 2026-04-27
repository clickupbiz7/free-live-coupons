@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            {{ isset($store) ? 'Edit Store' : 'Create Store' }}
        </h2>
        <p class="text-muted mb-0">Manage stores professionally</p>
    </div>

    <a href="{{ route('admin.stores.index') }}" class="btn btn-dark  px-4">
        <i class="fa fa-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card border-0 shadow-lg bg-gradient-primary rounded-4">
<div class="card-body p-4">

@if(isset($store))
<form action="{{ route('admin.stores.update',$store->id) }}" method="POST" enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
@endif
@csrf

<div class="row g-4">

<!-- STORE NAME -->
<div class="col-md-6">
<label class="form-label fw-semibold">Store Name</label>
<input type="text"
name="name"
class="form-control admin-input"
value="{{ old('name', $store->name ?? '') }}"
placeholder="Enter store name">
</div>

<!-- STATUS -->
<div class="col-md-6">
<label class="form-label fw-semibold">Status</label>
<select name="status" class="form-select admin-input">
<option value="1"
{{ old('status', $store->status ?? 1) == 1 ? 'selected' : '' }}>
Active
</option>

<option value="0"
{{ old('status', $store->status ?? 1) == 0 ? 'selected' : '' }}>
Inactive
</option>
</select>
</div>

<!-- DESCRIPTION -->
<div class="col-md-12">
<label class="form-label fw-semibold">Description</label>
<textarea
name="description"
rows="5"
class="form-control admin-input"
placeholder="Write store details...">{{ old('description', $store->description ?? '') }}</textarea>
</div>

<!-- LOGO -->
<div class="col-md-6">
<label class="form-label fw-semibold">Store Logo</label>
<input type="file"
name="logo"
class="form-control admin-input"
onchange="previewImage(event)">
</div>

<!-- PREVIEW -->
<div class="col-md-6 text-center">
<label class="form-label fw-semibold d-block">Preview</label>

<img id="preview"
src="{{ isset($store) && $store->logo ? asset('uploads/stores/'.$store->logo) : 'https://via.placeholder.com/140x90?text=Logo' }}"
style="width:140px;height:90px;object-fit:contain;border-radius:12px;border:1px solid #eee;padding:10px;background:#fff;">
</div>

<!-- SUBMIT -->
<div class="col-md-12 pt-2">
<button class="btn btn-primary px-5 py-2 rounded">
<i class="fa fa-save me-2"></i>
{{ isset($store) ? 'Update Store' : 'Save Store' }}
</button>
</div>

</div>

</form>

</div>
</div>

</div>

<style>
.admin-input{
border-radius:14px;
padding:12px 15px;
border:1px solid #dbe2ea;
transition:.3s;
box-shadow:none;
}
.admin-input:focus{
border-color:#4f46e5;
box-shadow:0 0 0 4px rgba(79,70,229,.08);
}
</style>

<script>
function previewImage(event){
let reader = new FileReader();
reader.onload = function(){
document.getElementById('preview').src = reader.result;
}
reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection