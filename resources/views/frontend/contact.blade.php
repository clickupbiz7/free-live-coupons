{{-- FILE: resources/views/frontend/contact.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="inner-hero">
<div class="container text-center">

<h1>Contact Us</h1>
<p>We’d love to hear from you</p>

</div>
</section>


<div class="container py-5">

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">
{{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
<ul class="mb-0 ps-3">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<div class="row g-4">

<!-- FORM -->
<div class="col-lg-7">

<div class="contact-card">

<div class="contact-head">
<h4>Send Message</h4>
<p>Have questions? Send us a message anytime.</p>
</div>

<form method="POST" action="{{ route('contact.send') }}">
@csrf

<div class="row">

<div class="col-md-6 mb-3">
<input type="text"
name="name"
value="{{ old('name') }}"
class="form-control contact-input"
placeholder="Your Name"
required>
</div>

<div class="col-md-6 mb-3">
<input type="email"
name="email"
value="{{ old('email') }}"
class="form-control contact-input"
placeholder="Your Email"
required>
</div>

<div class="col-md-12 mb-3">
<input type="text"
name="subject"
value="{{ old('subject') }}"
class="form-control contact-input"
placeholder="Subject"
required>
</div>

<div class="col-md-12 mb-3">
<textarea
rows="6"
name="message"
class="form-control contact-input"
placeholder="Your Message"
required>{{ old('message') }}</textarea>
</div>

<div class="col-md-12">
<button type="submit" class="send-btn w-100">
<i class="fa fa-paper-plane me-2"></i>
Send Message
</button>
</div>

</div>

</form>

</div>

</div>



<!-- INFO -->
<div class="col-lg-5">

<div class="info-card">

<h4>Contact Info</h4>
<p class="mb-4 text-muted">
We usually reply within 24 hours.
</p>

<div class="info-row">
<div class="info-icon">
<i class="fa fa-map-marker-alt"></i>
</div>
<div>
<h6>Address</h6>
<p>{{ \App\Models\Setting::get('contact_address') ?: 'Lahore, Pakistan' }}</p>
</div>
</div>

<div class="info-row">
<div class="info-icon">
<i class="fa fa-envelope"></i>
</div>
<div>
<h6>Email</h6>
<p>{{ \App\Models\Setting::get('contact_email') ?: 'support@site.com' }}</p>
</div>
</div>

<div class="info-row">
<div class="info-icon">
<i class="fa fa-phone"></i>
</div>
<div>
<h6>Phone</h6>
<p>{{ \App\Models\Setting::get('contact_phone') ?: '+92 300 1234567' }}</p>
</div>
</div>


<div class="social-icons">

@php
$socials = json_decode(\App\Models\Setting::get('social_links'), true);
@endphp

@if($socials && count($socials))

@foreach($socials as $social)

<a href="{{ $social['url'] }}" target="_blank">

@if(!empty($social['icon']))
<i class="{{ $social['icon'] }}"></i>
@else
<i class="fa fa-link"></i>
@endif

</a>

@endforeach

@else

<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-instagram"></i></a>
<a href="#"><i class="fab fa-youtube"></i></a>

@endif

</div>

</div>

</div>

</div>



<!-- MAP -->
<div class="map-wrap mt-5">

<iframe
src="{{ \App\Models\Setting::get('contact_map') ?: 'https://maps.google.com/maps?q=lahore&t=&z=13&ie=UTF8&iwloc=&output=embed' }}"
width="100%"
height="340"
style="border:0;"
loading="lazy"
allowfullscreen>
</iframe>

</div>

</div>



<style>

/* HERO */
.inner-hero{
padding:80px 0;
background:
radial-gradient(circle at left,#ffffff22,transparent 30%),
linear-gradient(135deg,#4f46e5,#7c3aed,#d946ef);
color:#fff;
}

.inner-hero h1{
font-size:36px;
font-weight:600;
margin-bottom:10px;
}

.inner-hero p{
font-size:18px;
opacity:.92;
}

/* FORM CARD */
.contact-card{
background:#fff;
border-radius:16px;
padding:30px;
box-shadow:0 15px 35px rgba(0,0,0,.08);
height:100%;
}

.contact-head h4{
font-size:24px;
font-weight:600;
margin-bottom:8px;
}

.contact-head p{
color:#64748b;
margin-bottom:22px;
}

/* INPUTS */
.contact-input{
border-radius:12px;
padding:14px 16px;
border:1px solid #e5e7eb;
box-shadow:none !important;
}

.contact-input:focus{
border-color:#6366f1;
}

/* BUTTON */
.send-btn{
padding:14px;
border:none;
border-radius:12px;
font-weight:600;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
transition:.3s;
}

.send-btn:hover{
transform:translateY(-2px);
}

/* INFO CARD */
.info-card{
background:#fff;
border-radius:16px;
padding:30px;
box-shadow:0 15px 35px rgba(0,0,0,.08);
height:100%;
}

.info-card h4{
font-size:24px;
font-weight:600;
margin-bottom:5px;
}

/* INFO ROW */
.info-row{
display:flex;
gap:15px;
margin-bottom:20px;
align-items:flex-start;
}

.info-icon{
width:46px;
height:46px;
border-radius:12px;
display:flex;
align-items:center;
justify-content:center;
background:linear-gradient(135deg,#eef2ff,#f5f3ff);
color:#4f46e5;
font-size:18px;
flex-shrink:0;
}

.info-row h6{
font-weight:600;
margin-bottom:4px;
}

.info-row p{
margin:0;
color:#64748b;
}

/* SOCIAL */
.social-icons{
display:flex;
gap:10px;
margin-top:25px;
flex-wrap:wrap;
}

.social-icons a{
width:42px;
height:42px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
text-decoration:none;
background:#f1f5f9;
color:#111827;
transition:.3s;
}

.social-icons a:hover{
background:linear-gradient(135deg,#4f46e5,#d946ef);
color:#fff;
transform:translateY(-3px);
}

/* MAP */
.map-wrap{
overflow:hidden;
border-radius:16px;
box-shadow:0 15px 35px rgba(0,0,0,.08);
}

/* MOBILE */
@media(max-width:768px){

.inner-hero h1{
font-size:38px;
}

.contact-card,
.info-card{
padding:22px;
}

.contact-head h4,
.info-card h4{
font-size:24px;
}

}

</style>

@endsection