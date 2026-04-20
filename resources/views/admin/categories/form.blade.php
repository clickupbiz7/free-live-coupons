{{-- =================================================== --}}
{{-- FILE: resources/views/admin/categories/form.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            {{ isset($category) ? 'Edit Category' : 'Create Category' }}
        </h2>
        <p class="text-muted mb-0">Manage categories professionally</p>
    </div>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-dark px-4">
        <i class="fa fa-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4">
<div class="card-body p-4">

@if(isset($category))
<form action="{{ route('admin.categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
@endif
@csrf

<div class="row g-4">

<!-- NAME -->
<div class="col-md-6">
<label class="form-label fw-semibold">Category Name</label>
<input type="text"
name="name"
class="form-control admin-input"
value="{{ old('name', $category->name ?? '') }}"
placeholder="Enter category name">
</div>

<!-- ICON -->
<div class="col-md-6">
<label class="form-label fw-semibold">FontAwesome Icon</label>
<input type="text"
name="icon"
id="iconInput"
class="form-control admin-input"
value="{{ old('icon', $category->icon ?? '') }}"
placeholder="fa-solid fa-tag">
<small class="text-muted">Example: fa-solid fa-mobile-screen</small>
</div>

<!-- ICON PREVIEW -->
<div class="col-md-6 text-center">
<label class="form-label fw-semibold d-block">Icon Preview</label>

<div style="height:90px;display:flex;align-items:center;justify-content:center;border:1px solid #eee;border-radius:14px;">
<i id="iconPreview"
class="{{ old('icon', $category->icon ?? 'fa-solid fa-tag') }}"
style="font-size:42px;color:#4f46e5;"></i>
</div>
</div>

<!-- IMAGE -->
<div class="col-md-6 text-center">
<label class="form-label fw-semibold d-block">Image Preview</label>

<img id="preview"
src="{{ isset($category) && $category->image ? asset('uploads/categories/'.$category->image) : 'https://via.placeholder.com/110x90?text=Image' }}"
style="width:110px;height:90px;object-fit:cover;border-radius:12px;border:1px solid #eee;">
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">Upload Image (Optional)</label>
<input type="file"
name="image"
class="form-control admin-input"
onchange="previewImage(event)">
</div>

<!-- SUBMIT -->
<div class="col-md-12 pt-2">
<button class="btn btn-primary px-5 py-2 rounded-pill">
<i class="fa fa-save me-2"></i>
{{ isset($category) ? 'Update Category' : 'Save Category' }}
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
document.getElementById('iconInput').addEventListener('input', function(){
document.getElementById('iconPreview').className = this.value || 'fa-solid fa-tag';
});

function previewImage(event){
let reader = new FileReader();
reader.onload = function(){
document.getElementById('preview').src = reader.result;
}
reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection