@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Website Settings</h2>
        <p class="text-muted mb-0">Manage branding, social links & policies</p>
    </div>
</div>

<form method="POST"
action="{{ route('admin.settings.save') }}"
enctype="multipart/form-data">
@csrf

<div class="card p-4">

<div class="row g-4">

<!-- Site Name -->
<div class="col-md-6">
<label class="form-label fw-semibold">Site Name</label>
<input type="text"
name="site_name"
value="{{ \App\Models\Setting::get('site_name') }}"
class="form-control">
</div>

<!-- Favicon -->
<div class="col-md-6">
<label class="form-label fw-semibold">Favicon</label>
<input type="file" name="favicon" class="form-control">

@if(\App\Models\Setting::get('favicon'))
<img src="{{ asset(\App\Models\Setting::get('favicon')) }}"
class="mt-2 rounded"
style="height:45px;width:45px;">
@endif
</div>

<!-- Header Logo -->
<div class="col-md-6">
<label class="form-label fw-semibold">Header Logo</label>
<input type="file" name="logo" class="form-control">

@if(\App\Models\Setting::get('logo'))
<img src="{{ asset(\App\Models\Setting::get('logo')) }}"
class="mt-2 rounded"
style="height:60px;">
@endif
</div>

<!-- Footer Logo -->
<div class="col-md-6">
<label class="form-label fw-semibold">Footer Logo</label>
<input type="file" name="footer_logo" class="form-control">

@if(\App\Models\Setting::get('footer_logo'))
<img src="{{ asset(\App\Models\Setting::get('footer_logo')) }}"
class="mt-2 rounded"
style="height:60px;">
@endif
</div>

<!-- Footer Desc -->
<div class="col-md-12">
<label class="form-label fw-semibold">Footer Description</label>
<textarea name="footer_desc"
rows="3"
class="form-control">{{ \App\Models\Setting::get('footer_desc') }}</textarea>
</div>

<!-- Policies -->
<div class="col-md-12">
<label class="form-label fw-semibold">Privacy Policy</label>
<textarea name="privacy_policy"
rows="6"
class="form-control">{{ \App\Models\Setting::get('privacy_policy') }}</textarea>
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">Terms & Conditions</label>
<textarea name="terms_condition"
rows="6"
class="form-control">{{ \App\Models\Setting::get('terms_condition') }}</textarea>
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">FAQ</label>
<textarea name="faq"
rows="6"
class="form-control">{{ \App\Models\Setting::get('faq') }}</textarea>
</div>

<!-- Save -->
<div class="col-md-12">
<button class="btn btn-primary px-5">
<i class="fa fa-save me-2"></i>Save Settings
</button>
</div>

</div>

</div>

</form>

</div>

@endsection