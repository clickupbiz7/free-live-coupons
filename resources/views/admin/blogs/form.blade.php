{{-- =================================================== --}}
{{-- FILE: resources/views/admin/blogs/form.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            {{ isset($blog) ? 'Edit Blog' : 'Create Blog' }}
        </h2>
        <p class="text-muted mb-0">Manage blog content professionally</p>
    </div>

    <a href="{{ route('admin.blogs.index') }}" class="btn btn-dark px-4">
        <i class="fa fa-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4">
<div class="card-body p-4">

@if(isset($blog))
<form action="{{ route('admin.blogs.update',$blog->id) }}" method="POST" enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
@endif
@csrf

<div class="row g-4">

<!-- TITLE -->
<div class="col-md-12">
<label class="form-label fw-semibold">Blog Title</label>
<input type="text"
name="title"
class="form-control admin-input"
value="{{ old('title', $blog->title ?? '') }}"
placeholder="Enter blog title">
</div>

<!-- CONTENT -->
<div class="col-md-12">
<label class="form-label fw-semibold">Blog Content</label>
<textarea
name="content"
rows="8"
class="form-control admin-input"
placeholder="Write blog content...">{{ old('content', $blog->content ?? '') }}</textarea>
</div>

<!-- STATUS -->
<div class="col-md-6">
<label class="form-label fw-semibold">Status</label>
<select name="status" class="form-select admin-input">
<option value="1"
{{ old('status', $blog->status ?? 1) == 1 ? 'selected' : '' }}>
Active
</option>

<option value="0"
{{ old('status', $blog->status ?? 1) == 0 ? 'selected' : '' }}>
Inactive
</option>
</select>
</div>

<!-- IMAGE -->
<div class="col-md-6">
<label class="form-label fw-semibold">Blog Image</label>
<input type="file"
name="image"
class="form-control admin-input"
onchange="previewImage(event)">
</div>

<!-- PREVIEW -->
<div class="col-md-12 text-center">
<label class="form-label fw-semibold d-block">Image Preview</label>

<img id="preview"
src="{{ isset($blog) && $blog->image ? asset('uploads/blogs/'.$blog->image) : 'https://via.placeholder.com/260x150?text=Preview' }}"
style="width:260px;height:150px;object-fit:cover;border-radius:14px;border:1px solid #eee;">
</div>

<!-- SUBMIT -->
<div class="col-md-12 pt-2">
<button class="btn btn-primary px-5 py-2 rounded-pill">
<i class="fa fa-save me-2"></i>
{{ isset($blog) ? 'Update Blog' : 'Save Blog' }}
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