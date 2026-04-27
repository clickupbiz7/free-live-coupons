@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
<div>
<h2 class="fw-bold mb-1">Website Settings</h2>
<p class="text-muted mb-0">
Manage branding, header, footer, youtube, socials & pages
</p>
</div>
</div>

<form method="POST"
action="{{ route('admin.settings.save') }}"
enctype="multipart/form-data"
id="settingsForm">
@csrf

<div class="card border-0 rounded-4 p-4 settings-card">

<div class="row g-4">

<!-- BASIC -->
<div class="col-12">
<h5 class="section-title">Branding Settings</h5>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Site Name Header</label>
<input type="text"
name="header_site_name"
value="{{ \App\Models\Setting::get('header_site_name') }}"
class="form-control modern-input"
placeholder="Shown beside logo in navbar">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Site Name Footer</label>
<input type="text"
name="site_name"
value="{{ \App\Models\Setting::get('site_name') }}"
class="form-control modern-input">
</div>

<!-- HEADER LOGO -->
<div class="col-md-6">
<label class="form-label fw-semibold">Header Logo</label>
<input type="file" name="logo" class="form-control modern-input">

@if(\App\Models\Setting::get('logo'))
<div class="preview-box mt-2">
<div class="position-relative d-inline-block">
<img src="{{ asset(\App\Models\Setting::get('logo')) }}" class="preview-img">

<button type="button"
class="btn btn-danger remove-file-btn"
onclick="removeFile('remove_logo',this)">×</button>
</div>
</div>
<input type="hidden" name="remove_logo" id="remove_logo" value="0">
@endif
</div>

<!-- FAVICON -->
<div class="col-md-6">
<label class="form-label fw-semibold">Favicon</label>
<input type="file" name="favicon" class="form-control modern-input">

@if(\App\Models\Setting::get('favicon'))
<div class="preview-box mt-2">
<div class="position-relative d-inline-block">
<img src="{{ asset(\App\Models\Setting::get('favicon')) }}" class="preview-img small-preview">

<button type="button"
class="btn btn-danger remove-file-btn"
onclick="removeFile('remove_favicon',this)">×</button>
</div>
</div>
<input type="hidden" name="remove_favicon" id="remove_favicon" value="0">
@endif
</div>

<!-- FOOTER LOGO -->
<div class="col-md-6">
<label class="form-label fw-semibold">Footer Logo</label>
<input type="file" name="footer_logo" class="form-control modern-input">

@if(\App\Models\Setting::get('footer_logo'))
<div class="preview-box mt-2">
<div class="position-relative d-inline-block">
<img src="{{ asset(\App\Models\Setting::get('footer_logo')) }}" class="preview-img">

<button type="button"
class="btn btn-danger remove-file-btn"
onclick="removeFile('remove_footer_logo',this)">×</button>
</div>
</div>
<input type="hidden" name="remove_footer_logo" id="remove_footer_logo" value="0">
@endif
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Footer Description</label>
<textarea name="footer_desc"
rows="3"
class="form-control modern-input">{{ \App\Models\Setting::get('footer_desc') }}</textarea>
</div>

<!-- YOUTUBE -->

<!-- YOUTUBE -->
<div class="col-12 pt-2">
<h5 class="section-title">YouTube Widget</h5>
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">Channel Name</label>
<input type="text"
name="youtube_channel_name"
value="{{ \App\Models\Setting::get('youtube_channel_name') }}"
class="form-control modern-input"
placeholder="My Channel">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Channel Link</label>
<input type="text"
name="youtube_link"
value="{{ \App\Models\Setting::get('youtube_link') }}"
class="form-control modern-input"
placeholder="https://youtube.com/@channelname">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Custom Thumbnail / Banner</label>

<input type="file"
name="youtube_thumb"
class="form-control modern-input">

@if(\App\Models\Setting::get('youtube_thumb'))

<div class="preview-box mt-2">
<div class="position-relative d-inline-block">

<img src="{{ asset('uploads/settings/'.\App\Models\Setting::get('youtube_thumb')) }}"
class="preview-img"
style="height:90px;width:190px;object-fit:cover;">

<button type="button"
class="btn btn-danger remove-file-btn"
onclick="removeFile('remove_youtube_thumb',this)">×</button>

</div>
</div>

<input type="hidden"
name="remove_youtube_thumb"
id="remove_youtube_thumb"
value="0">

@endif

</div>


<!-- SOCIAL -->
@php
$socials = json_decode(\App\Models\Setting::get('social_links'), true) ?? [];
@endphp

<div class="col-12 pt-2">
<h5 class="section-title">Social Links</h5>
</div>

<div class="col-12">

<div id="social-wrapper">

@if(count($socials))
@foreach($socials as $item)

<div class="row g-2 social-row mb-2">

<div class="col-md-4">
<select name="social_platform[]" class="form-control modern-input">
<option value="{{ $item['platform'] }}">
{{ ucfirst($item['platform']) }}
</option>
</select>
</div>

<div class="col-md-7">
<input type="text"
name="social_url[]"
value="{{ $item['url'] }}"
class="form-control modern-input">
</div>

<div class="col-md-1">
<button type="button"
class="btn btn-danger w-100 remove-social">
<i class="fa fa-trash"></i>
</button>
</div>

</div>

@endforeach
@endif

</div>

<button type="button"
id="add-social"
class="btn btn-dark mt-2 rounded-3 px-4">
<i class="fa fa-plus me-2"></i>Add Social Link
</button>

</div>

<!-- CONTACT -->
<div class="col-12 pt-2">
<h5 class="section-title">Contact Info</h5>
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Address</label>
<input type="text"
name="contact_address"
value="{{ \App\Models\Setting::get('contact_address') }}"
class="form-control modern-input">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Email</label>
<input type="text"
name="contact_email"
value="{{ \App\Models\Setting::get('contact_email') }}"
class="form-control modern-input">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Phone</label>
<input type="text"
name="contact_phone"
value="{{ \App\Models\Setting::get('contact_phone') }}"
class="form-control modern-input">
</div>

<div class="col-md-6">
<label class="form-label fw-semibold">Google Map URL</label>
<input type="text"
name="contact_map"
value="{{ \App\Models\Setting::get('contact_map') }}"
class="form-control modern-input">
</div>

<!-- PAGES -->
<div class="col-12 pt-2">
<h5 class="section-title">Policy Pages</h5>
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">Privacy Policy</label>
<textarea name="privacy_policy" rows="6"
class="form-control modern-input">{{ \App\Models\Setting::get('privacy_policy') }}</textarea>
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">Terms & Conditions</label>
<textarea name="terms_condition" rows="6"
class="form-control modern-input">{{ \App\Models\Setting::get('terms_condition') }}</textarea>
</div>

<div class="col-md-12">
<label class="form-label fw-semibold">FAQ</label>
<textarea name="faq" rows="6"
class="form-control modern-input">{{ \App\Models\Setting::get('faq') }}</textarea>
</div>

<!-- SAVE -->
<div class="col-md-12 mt-3">
<button id="saveBtn" class="btn btn-primary px-5 py-2 rounded-3 fw-semibold">
<i class="fa fa-save me-2"></i>
<span>Save Settings</span>
</button>
</div>

</div>
</div>

</form>
</div>

<style>

.settings-card{
background:#fff;
box-shadow:0 15px 40px rgba(0,0,0,.05);
}

.section-title{
font-weight:700;
font-size:18px;
padding-bottom:10px;
border-bottom:1px solid #ececec;
margin-bottom:5px;
}

.modern-input{
min-height:48px;
border-radius:14px;
border:1px solid #dde2ea;
transition:.25s;
}

.modern-input:focus{
border-color:#4f46e5;
box-shadow:0 0 0 4px rgba(79,70,229,.08);
}

/* IMAGE PREVIEW */
.preview-box{
padding:12px;
border:1px dashed #d9dce3;
border-radius:14px;
background:#f8fafc;
display:inline-block;
}

.preview-img{
height:60px;
max-width:180px;
object-fit:contain;
background:#fff;
padding:4px;
border-radius:10px;
border:1px solid #eee;
}

.small-preview{
height:45px !important;
width:45px !important;
max-width:45px !important;
}

/* REMOVE BUTTON */
.remove-file-btn{
position:absolute;
top:-10px;
right:-10px;
width:26px;
height:26px;
border-radius:50%;
padding:0;
line-height:24px;
font-size:18px;
font-weight:bold;
display:flex;
align-items:center;
justify-content:center;
}

/* SOCIAL */
.social-row{
padding:10px;
border:1px solid #eef0f4;
border-radius:14px;
background:#fff;
}

/* MOBILE */
@media(max-width:768px){

#saveBtn{
width:100%;
}

.settings-card{
padding:18px !important;
}

.preview-box{
width:100%;
text-align:center;
}

.preview-img{
max-width:100%;
height:auto;
}

}

</style>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function removeFile(inputId, btn)
{
Swal.fire({
title:'Remove Image?',
text:'Save karne par image delete ho jayegi.',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Yes Remove',
cancelButtonText:'Cancel',
confirmButtonColor:'#dc3545'
}).then((result)=>{

if(result.isConfirmed)
{
document.getElementById(inputId).value = 1;
btn.closest('.preview-box').style.display = 'none';
}

});
}


/* ADD SOCIAL */
document.getElementById('add-social').addEventListener('click', function(){

let html = `
<div class="row g-2 social-row mb-2">

<div class="col-md-4">
<select name="social_platform[]" class="form-control modern-input">
<option value="facebook">Facebook</option>
<option value="instagram">Instagram</option>
<option value="youtube">YouTube</option>
<option value="twitter">Twitter</option>
<option value="whatsapp">WhatsApp</option>
<option value="tiktok">Tiktok</option>
<option value="snapchat">Snapchat</option>
<option value="linkedin">Linkedin</option>
<option value="telegram">Telegram</option>
<option value="threads">Threads</option>
<option value="x">X</option>
</select>
</div>

<div class="col-md-7">
<input type="text"
name="social_url[]"
class="form-control modern-input"
placeholder="https://example.com">
</div>

<div class="col-md-1">
<button type="button"
class="btn btn-danger w-100 remove-social">
<i class="fa fa-trash"></i>
</button>
</div>

</div>
`;

document.getElementById('social-wrapper')
.insertAdjacentHTML('beforeend', html);

});


/* REMOVE SOCIAL */
document.addEventListener('click', function(e){

if(e.target.closest('.remove-social'))
{
e.target.closest('.social-row').remove();
}

});


/* SAVE LOADER */
document.getElementById('settingsForm')
.addEventListener('submit', function(){

let btn = document.getElementById('saveBtn');

btn.disabled = true;

btn.innerHTML =
'<i class="fa fa-spinner fa-spin me-2"></i> Saving...';

});


@if(session('success'))
Swal.fire({
toast:true,
position:'top-end',
icon:'success',
title:'Settings Saved Successfully',
showConfirmButton:false,
timer:2200
});
@endif

</script>

@endsection