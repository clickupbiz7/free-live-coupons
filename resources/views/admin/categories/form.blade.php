{{-- FILE: resources/views/admin/categories/form.blade.php --}}

@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">
            {{ isset($category) ? 'Edit Category' : 'Create Category' }}
        </h2>
        <p class="text-muted mb-0">Manage categories professionally</p>
    </div>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-dark px-4 rounded">
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

<input type="hidden" name="remove_icon" id="remove_icon" value="0">
<input type="hidden" name="remove_image" id="remove_image" value="0">

<div class="row g-4">

{{-- NAME --}}
<div class="col-md-6">
<label class="form-label fw-semibold">Category Name</label>
<input type="text"
name="name"
class="form-control admin-input"
value="{{ old('name', $category->name ?? '') }}"
placeholder="Enter category name">
</div>

{{-- SVG --}}
<div class="col-md-6">
<label class="form-label fw-semibold">Upload SVG Icon</label>
<input type="file"
name="icon"
accept=".svg"
class="form-control admin-input"
onchange="previewSvg(event)">
<small class="text-muted">Upload clean SVG logo/icon</small>
</div>

{{-- SVG PREVIEW --}}
<div class="col-md-6 text-center">
<label class="form-label fw-semibold d-block">SVG Preview</label>

<div class="preview-box position-relative">

@if(isset($category) && $category->icon)
<img id="svgPreview"
src="{{ asset('uploads/categories/icons/'.$category->icon) }}"
class="preview-img">
<button type="button" class="remove-btn" onclick="removeSvg()">×</button>
@else
<img id="svgPreview"
src="https://via.placeholder.com/52?text=SVG"
class="preview-img">
@endif

</div>
</div>

{{-- IMAGE PREVIEW --}}
<div class="col-md-6 text-center">
<label class="form-label fw-semibold d-block">Image Preview</label>

<div class="preview-box position-relative">

<img id="preview"
src="{{ isset($category) && $category->image ? asset('uploads/categories/'.$category->image) : 'https://via.placeholder.com/110x90?text=Image' }}"
class="preview-big">

@if(isset($category) && $category->image)
<button type="button" class="remove-btn" onclick="removeImage()">×</button>
@endif

</div>
</div>

{{-- IMAGE --}}
<div class="col-md-12">
<label class="form-label fw-semibold">Upload Category Image (Optional)</label>
<input type="file"
name="image"
class="form-control admin-input"
onchange="previewImage(event)">
</div>

{{-- SUBMIT --}}
<div class="col-md-12 pt-2">
<button class="btn btn-primary px-5 py-2 rounded">
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

.preview-box{
height:110px;
display:flex;
align-items:center;
justify-content:center;
border:1px solid #eee;
border-radius:14px;
background:#fafafa;
position:relative;
overflow:hidden;
}

.preview-img{
width:52px;
height:52px;
object-fit:contain;
}

.preview-big{
width:110px;
height:90px;
object-fit:cover;
border-radius:12px;
}

.remove-btn{
position:absolute;
top:6px;
right:6px;
width:28px;
height:28px;
border:none;
border-radius:10%;
background:#ef4444;
color:#fff;
font-size:18px;
font-weight:700;
line-height:1;
cursor:pointer;
}

.remove-btn:hover{
background:#dc2626;
}

</style>

<script>

function previewImage(event){

let reader = new FileReader();

reader.onload = function(){
document.getElementById('preview').src = reader.result;
document.getElementById('remove_image').value = 0;
document.getElementById('remove_icon').value = 1;
}

reader.readAsDataURL(event.target.files[0]);

}

function previewSvg(event){

let reader = new FileReader();

reader.onload = function(){
document.getElementById('svgPreview').src = reader.result;
document.getElementById('remove_icon').value = 0;
document.getElementById('remove_image').value = 1;
}

reader.readAsDataURL(event.target.files[0]);

}

function removeSvg(){
document.getElementById('svgPreview').src =
'https://via.placeholder.com/52?text=SVG';

document.getElementById('remove_icon').value = 1;
}

function removeImage(){
document.getElementById('preview').src =
'https://via.placeholder.com/110x90?text=Image';

document.getElementById('remove_image').value = 1;
}

</script>

@endsection