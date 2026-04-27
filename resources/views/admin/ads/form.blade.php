{{-- FILE: resources/views/admin/ads/form.blade.php --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">
            {{ isset($ad) ? 'Edit Ad' : 'Add New Ad' }}
        </h2>
        <p class="text-muted mb-0">
            Manage website advertisements professionally
        </p>
    </div>

    <a href="{{ route('admin.ads.index') }}" class="btn btn-dark px-4 rounded">
        <i class="fa fa-arrow-left me-2"></i>Back
    </a>
</div>


<div class="card border-0 shadow-lg rounded">
<div class="card-body p-4 p-lg-5">

@if(isset($ad))
<form action="{{ route('admin.ads.update',$ad->id) }}" method="POST">
@method('PUT')
@else
<form action="{{ route('admin.ads.store') }}" method="POST">
@endif
@csrf

<div class="row g-4">

{{-- TITLE --}}
<div class="col-md-4">
<label class="form-label fw-semibold">Ad Title</label>
<input type="text"
name="title"
class="form-control admin-input"
placeholder="Example: Homepage Top Banner"
value="{{ old('title', $ad->title ?? '') }}">
</div>

{{-- SIZE --}}
<div class="col-md-4">
<label class="form-label fw-semibold">Ad Size</label>
<input type="text"
name="size"
class="form-control admin-input"
placeholder="728x90 / 300x250 / Responsive"
value="{{ old('size', $ad->size ?? '') }}">
</div>

{{-- NETWORK --}}
<div class="col-md-4">
<label class="form-label fw-semibold">Ad Network</label>
<select name="network" class="form-control admin-input">
<option value="google"
{{ old('network', $ad->network ?? '') == 'google' ? 'selected' : '' }}>
Google Adsense
</option>

<option value="adsterra"
{{ old('network', $ad->network ?? '') == 'adsterra' ? 'selected' : '' }}>
Adsterra
</option>

<option value="monetag"
{{ old('network', $ad->network ?? '') == 'monetag' ? 'selected' : '' }}>
Monetag
</option>
</select>
</div>


{{-- PLACEMENT --}}
<div class="col-md-4">
<label class="form-label fw-semibold">Placement</label>

<select name="placement" class="form-control admin-input">

<option value="home_top"
{{ old('placement', $ad->placement ?? '') == 'home_top' ? 'selected' : '' }}>
Homepage Top
</option>

<option value="home_middle"
{{ old('placement', $ad->placement ?? '') == 'home_middle' ? 'selected' : '' }}>
Homepage Middle
</option>

<option value="home_bottom"
{{ old('placement', $ad->placement ?? '') == 'home_bottom' ? 'selected' : '' }}>
Homepage Bottom
</option>

<option value="blogs_top"
{{ old('placement', $ad->placement ?? '') == 'blogs_top' ? 'selected' : '' }}>
Blogs Page Top
</option>

<option value="blogs_middle"
{{ old('placement', $ad->placement ?? '') == 'blogs_middle' ? 'selected' : '' }}>
Blogs Page Middle
</option>

<option value="single_blog_top"
{{ old('placement', $ad->placement ?? '') == 'single_blog_top' ? 'selected' : '' }}>
Single Blog Top
</option>

<option value="single_blog_middle"
{{ old('placement', $ad->placement ?? '') == 'single_blog_middle' ? 'selected' : '' }}>
Single Blog Middle
</option>

<option value="blog_sidebar"
{{ old('placement', $ad->placement ?? '') == 'blog_sidebar' ? 'selected' : '' }}>
Blog Sidebar (Latest Blogs Below)
</option>

</select>

<small class="text-muted">
Choose where ad should appear on website
</small>

</div>



{{-- DEVICE --}}
<div class="col-md-4">
<label class="form-label fw-semibold">Device Target</label>

<select name="device" class="form-control admin-input">

<option value="all"
{{ old('device', $ad->device ?? '') == 'all' ? 'selected' : '' }}>
All Devices
</option>

<option value="desktop"
{{ old('device', $ad->device ?? '') == 'desktop' ? 'selected' : '' }}>
Desktop Only
</option>

<option value="mobile"
{{ old('device', $ad->device ?? '') == 'mobile' ? 'selected' : '' }}>
Mobile Only
</option>

</select>

</div>


{{-- PRIORITY --}}
<div class="col-md-4">
<label class="form-label fw-semibold">Priority</label>
<input type="number"
name="priority"
class="form-control admin-input"
value="{{ old('priority', $ad->priority ?? 1) }}">
<small class="text-muted">Smaller number = show first</small>
</div>


{{-- STATUS --}}
<div class="col-md-12">
<label class="form-label fw-semibold">Status</label>

<select name="status" class="form-control admin-input">

<option value="1"
{{ old('status', $ad->status ?? 1) == 1 ? 'selected' : '' }}>
Active
</option>

<option value="0"
{{ old('status', $ad->status ?? 1) == 0 ? 'selected' : '' }}>
Inactive
</option>

</select>
</div>


{{-- CODE --}}
<div class="col-md-12">
<label class="form-label fw-semibold">Ad Code</label>

<textarea
name="ad_code"
rows="9"
class="form-control admin-input code-box"
placeholder="Paste Google Adsense / Adsterra / Monetag Code Here">{{ old('ad_code', $ad->ad_code ?? '') }}</textarea>

<small class="text-muted">
Paste full javascript or html ad code
</small>

</div>


{{-- SUBMIT --}}
<div class="col-md-12 pt-2">

<button class="btn btn-primary px-5 py-2 rounded fw-semibold">

<i class="fa fa-save me-2"></i>

{{ isset($ad) ? 'Update Ad' : 'Save Ad' }}

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
padding:13px 16px;
border:1px solid #dbe2ea;
box-shadow:none;
transition:.25s;
}

.admin-input:focus{
border-color:#4f46e5;
box-shadow:0 0 0 4px rgba(79,70,229,.08);
}

.code-box{
font-family:monospace;
font-size:14px;
line-height:1.6;
resize:vertical;
min-height:220px;
}

@media(max-width:768px){

.code-box{
min-height:180px;
}

}

</style>

@endsection