{{-- =================================================== --}}
{{-- FILE: resources/views/admin/coupons/form.blade.php --}}
{{-- =================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4  flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">
            {{ isset($coupon) ? 'Edit Coupon' : 'Create Coupon' }}
        </h2>
        <p class="text-muted mb-0">
            Manage coupon details professionally
        </p>
    </div>

    <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark px-4 rounded">
        <i class="fa fa-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<div class="card-header bg-gradient-primary text-white py-3 px-4">
    <h5 class="mb-0">
        <i class="fa fa-ticket-alt me-2"></i>
        {{ isset($coupon) ? 'Update Coupon Details' : 'New Coupon Entry' }}
    </h5>
</div>

<div class="card-body p-4">

@if(isset($coupon))
<form action="{{ route('admin.coupons.update',$coupon->id) }}" method="POST" enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{ route('admin.coupons.store') }}" method="POST" enctype="multipart/form-data">
@endif
@csrf

<div class="row g-4">

<!-- TITLE -->
<div class="col-md-4">
<label class="form-label fw-semibold">Coupon Title</label>
<input type="text"
name="title"
class="form-control admin-input"
value="{{ old('title', $coupon->title ?? '') }}"
placeholder="Enter coupon title">
</div>

<!-- CODE -->
<div class="col-md-4">
<label class="form-label fw-semibold">Coupon Code</label>
<input type="text"
name="code"
class="form-control admin-input"
value="{{ old('code', $coupon->code ?? '') }}"
placeholder="SAVE20">
</div>

<!-- STORE -->
<div class="col-md-4">
<label class="form-label fw-semibold">Store</label>
<select name="store_id" class="form-select admin-input">
@foreach($stores as $store)
<option value="{{ $store->id }}"
{{ old('store_id', $coupon->store_id ?? '') == $store->id ? 'selected' : '' }}>
{{ $store->name }}
</option>
@endforeach
</select>
</div>

<!-- BADGE LABEL -->
<div class="col-md-4">
<label class="form-label fw-semibold">Badge Label</label>
<input type="text"
name="badge"
class="form-control admin-input"
value="{{ old('badge', $coupon->badge ?? 'Limited') }}"
placeholder="Limited / Hot / New">
<small class="text-muted">Top right card badge text</small>
</div>

<!-- DISCOUNT -->
<div class="col-md-4">
<label class="form-label fw-semibold">Discount</label>
<input type="text"
name="discount"
class="form-control admin-input"
value="{{ old('discount', $coupon->discount ?? '') }}"
placeholder="20">
<small class="text-muted">Example: 20 / 50 / Free</small>
</div>

<!-- CATEGORY -->
<div class="col-md-4">
<label class="form-label fw-semibold">Category</label>
<select name="category_id" class="form-select admin-input">
@foreach($categories as $cat)
<option value="{{ $cat->id }}"
{{ old('category_id', $coupon->category_id ?? '') == $cat->id ? 'selected' : '' }}>
{{ $cat->name }}
</option>
@endforeach
</select>
</div>


<!-- AFFILIATE LINK -->
<div class="col-md-4">
<label class="form-label fw-semibold">Affiliate / Deal Link</label>
<input type="text"
name="affiliate_link"
class="form-control admin-input"
value="{{ old('affiliate_link', $coupon->affiliate_link ?? '') }}"
placeholder="https://example.com/product-link">
<small class="text-muted">Important for deal redirects & coupon click open</small>
</div>


<!-- EXPIRY -->
<div class="col-md-4">
<label class="form-label fw-semibold">Expiry Date</label>
<input type="date"
name="expiry_date"
class="form-control admin-input"
value="{{ old('expiry_date', $coupon->expiry_date ?? '') }}">
</div>


<!-- TYPE -->
<div class="col-md-4">
<label class="form-label fw-semibold">Type</label>
<select name="type" class="form-select admin-input">
<option value="coupon"
{{ old('type', $coupon->type ?? '') == 'coupon' ? 'selected' : '' }}>
Coupon Code
</option>

<option value="deal"
{{ old('type', $coupon->type ?? '') == 'deal' ? 'selected' : '' }}>
Deal Link
</option>
</select>
</div>

<!-- DESCRIPTION -->
<div class="col-md-12">
<label class="form-label fw-semibold">Description</label>
<textarea
name="description"
rows="4"
class="form-control admin-input"
placeholder="Write coupon details...">{{ old('description', $coupon->description ?? '') }}</textarea>
</div>

<!-- STATUS -->
<div class="col-md-4">
<label class="form-label fw-semibold">Status</label>
<select name="status" class="form-select admin-input">
<option value="1"
{{ old('status', $coupon->status ?? 1) == 1 ? 'selected' : '' }}>
Active
</option>

<option value="0"
{{ old('status', $coupon->status ?? 1) == 0 ? 'selected' : '' }}>
Inactive
</option>
</select>
</div>

<!-- FEATURED -->
<div class="col-md-4">
<label class="form-label fw-semibold">Featured</label>
<select name="featured" class="form-select admin-input">
<option value="0"
{{ old('featured', $coupon->featured ?? 0) == 0 ? 'selected' : '' }}>
No
</option>

<option value="1"
{{ old('featured', $coupon->featured ?? 0) == 1 ? 'selected' : '' }}>
Yes
</option>
</select>
</div>

<!-- IMAGE -->
<div class="col-md-4">
<label class="form-label fw-semibold">Coupon Image</label>
<input type="file"
name="image"
class="form-control admin-input"
onchange="previewImage(event)">
</div>

<!-- PREVIEW -->
<div class="col-md-12 text-center">
<label class="form-label fw-semibold d-block">Preview</label>

<img id="preview"
src="{{ isset($coupon) && $coupon->image ? asset('uploads/coupons/'.$coupon->image) : 'https://via.placeholder.com/120x90?text=Preview' }}"
style="width:140px;height:100px;object-fit:cover;border-radius:10px;border:1px solid #eee;">
</div>

<!-- SUBMIT -->
<div class="col-md-12 pt-2 d-flex gap-2 flex-wrap">
<button class="btn btn-primary px-5 py-2 rounded">
<i class="fa fa-save me-2"></i>
{{ isset($coupon) ? 'Update Coupon' : 'Save Coupon' }}
</button>

<a href="{{ route('admin.coupons.index') }}" class="btn btn-light border px-4 py-2 rounded">
Cancel
</a>
</div>

</div>

</form>

</div>
</div>

</div>

<style>
.bg-gradient-primary{
background:linear-gradient(135deg,#4f46e5,#7c3aed);
}

.admin-input{
border-radius:14px;
padding:12px 15px;
border:1px solid #dbe2ea;
box-shadow:none;
transition:.3s;
}

.admin-input:focus{
border-color:#4f46e5;
box-shadow:0 0 0 4px rgba(79,70,229,.08);
}

.card{
background:#fff;
}

label{
margin-bottom:8px;
}

small{
font-size:12px;
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