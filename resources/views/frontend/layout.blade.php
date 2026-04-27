<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ \App\Models\Setting::get('site_name') ?? 'Free Coupons' }}</title>

@if(\App\Models\Setting::get('favicon'))
<link rel="icon" href="{{ asset(\App\Models\Setting::get('favicon')) }}">
@endif

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Inter',sans-serif;
background:#f8fafc;
color:#111827;
overflow-x:hidden;
}

/* ================= NAVBAR ================= */

.custom-navbar{
background:#0f172a;
padding:14px 0;
box-shadow:0 6px 18px rgba(0,0,0,.08);
position:sticky;
top:0;
z-index:999;
}

.navbar-brand{
font-size:24px;
font-weight:600;
color:#fff !important;
display:flex;
align-items:center;
gap:10px;
text-decoration:none;
}

.navbar-brand img{
height:44px;
width:auto;
}

.custom-navbar .nav-link{
color:#fff !important;
font-weight:600;
margin-left:18px;
position:relative;
transition:.3s;
}

.custom-navbar .nav-link:hover{
color:#facc15 !important;
}

.custom-navbar .nav-link::before{
content:'';
position:absolute;
right:0;
top:-6px;
width:0;
height:2px;
background:#facc15;
transition:.3s;
}

.custom-navbar .nav-link:hover::before{
width:100%;
}

.custom-navbar .nav-link::after{
content:'';
position:absolute;
left:0;
bottom:-6px;
width:0;
height:2px;
background:#facc15;
transition:.3s;
}

.custom-navbar .nav-link:hover::after{
width:100%;
}

@media(max-width:768px){

.navbar-brand img + .brand-text{
display:none;
}
}

/* ================= COMMON ================= */

.page-section{
padding:70px 0;
}

.btn-gradient{
background:linear-gradient(90deg,#4f46e5,#7c3aed,#ec4899);
border:none;
color:#fff;
padding:11px 20px;
border-radius:12px;
font-weight:600;
}

.btn-gradient:hover{
color:#fff;
opacity:.95;
}

/* ================= FOOTER ================= */

.premium-footer{
background:#0f172a;
color:#fff;
padding:60px 0 20px;
margin-top:70px;
}

.premium-footer h4,
.premium-footer h5,
.premium-footer h6{
font-weight:700;
margin-bottom:16px;
}

.premium-footer p,
.premium-footer small{
color:#cbd5e1;
}

.footer-links{
list-style:none;
padding:0;
margin:0;
}

.footer-links li{
margin-bottom:10px;
}

.footer-links a{
text-decoration:none;
color:#fff;
transition:.3s;
}

.footer-links a:hover{
color:#facc15;
}


.footer-bottom{
border-top:1px solid rgba(255,255,255,.08);
margin-top:35px;
padding-top:18px;
}

.footer-social a{
width:38px;
height:38px;
display:inline-flex;
align-items:center;
justify-content:center;
border-radius:50%;
background:#1e293b;
color:#fff;
text-decoration:none;
margin-left:8px;
transition:.3s;
}

.footer-social a:hover{
background:#6366f1;
transform:translateY(-3px);
}


/* yt-footer-widget CSS */

.yt-footer-widget{
margin-top:-10px;
width:100%;
max-width:300px;
height:212px;
display:block;
text-decoration:none;
background:#0b0b0c;
border-radius:18px;
overflow:hidden;
border:1px solid rgba(255,255,255,.06);
box-shadow:0 14px 35px rgba(0,0,0,.28);
transition:.3s ease;
margin-left:auto;
}

.yt-footer-widget:hover{
transform:translateY(-4px);
box-shadow:0 24px 45px rgba(0,0,0,.38);
}

.yt-footer-banner{
height:52px;
width:100%;
overflow:hidden;
position:relative;
}

.yt-footer-banner::after{
content:'';
position:absolute;
inset:0;
background:linear-gradient(to bottom,rgba(0,0,0,.05),rgba(0,0,0,.55));
}

.yt-footer-banner-img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.yt-footer-body{
height:100px;
padding:0 10px 16px;
text-align:center;
display:flex;
flex-direction:column;
align-items:center;
justify-content:flex-start;
}

.yt-footer-avatar{
margin-top:-38px;
margin-bottom:6px;
position:relative;
z-index:3;
}

.yt-footer-avatar-img,
.yt-footer-fallback{
width:74px;
height:74px;
border-radius:50%;
object-fit:cover;
background:#111;
display:flex;
align-items:center;
justify-content:center;
font-size:28px;
color:#ff2d3d;
border:4px solid #0b0b0c;
box-shadow:0 10px 20px rgba(0,0,0,.25);
}

.yt-footer-text h5{
margin:0;
font-size:16px;
font-weight:700;
line-height:1.2;
color:#fff;
}

.yt-footer-text p{
margin:4px 0 14px;
font-size:14px;
line-height:1.4;
color:#d1d5db;
}

.yt-footer-btn{
margin-top:auto;
width:100%;
padding:13px;
background:#ff2d3d;
border-radius:14px;
color:#fff;
font-size:16px;
font-weight:700;
text-align:center;
transition:.25s ease;
}

.yt-footer-widget:hover .yt-footer-btn{
background:#ff4251;
color:#111;
}

@media(max-width:991px){

.yt-footer-widget{
margin:20px auto 0;
max-width:400px;
}

}

@media(max-width:575px){

.yt-footer-widget{
height:250px;
}

.yt-footer-banner{
height:90px;
width:100%;
overflow:hidden;
position:relative;
}

.yt-footer-body{
height:160px;
}

}

/* ================= SCROLL TOP ================= */

#scrollTopBtn{
position:fixed;
right:18px;
bottom:18px;
width:45px;
height:45px;
border:none;
border-radius:50%;
background:#6366f1;
color:#fff;
display:none;
z-index:999;
}

/* ================= MOBILE ================= */

@media(max-width:991px){

.custom-navbar .nav-link{
margin-left:0;
margin-top:10px;
}

.footer-bottom{
text-align:center;
}

.footer-social{
margin-top:15px;
}

}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg custom-navbar">
<div class="container">

<a href="{{ route('home') }}" class="navbar-brand">

@if(\App\Models\Setting::get('logo'))

<img src="{{ asset(\App\Models\Setting::get('logo')) }}">

<span class="brand-text">
{{ \App\Models\Setting::get('header_site_name') ?: 'FreeLiveCoupons' }}
</span>

@else

<span>
{{ \App\Models\Setting::get('header_site_name') ?: 'FreeLiveCoupons' }}
</span>

@endif

</a>

<button class="navbar-toggler text-white border-0 shadow-none"
type="button"
data-bs-toggle="collapse"
data-bs-target="#mainMenu">

<i class="fa fa-bars"></i>

</button>


<div class="collapse navbar-collapse justify-content-end" id="mainMenu">

<ul class="navbar-nav align-items-lg-center">

<li class="nav-item">
<a class="nav-link" href="{{ route('home') }}">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('stores.all') }}">Stores</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('categories.all') }}">Categories</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('blogs.all') }}">Blogs</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('about') }}">About</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('contact') }}">Contact</a>
</li>

</ul>

</div>
</div>
</nav>

<!-- PAGE CONTENT -->
@yield('content')



<!-- FOOTER -->
@php

$ytName = trim(\App\Models\Setting::get('youtube_channel_name'));
$ytLink = trim(\App\Models\Setting::get('youtube_link'));
$ytThumb = trim(\App\Models\Setting::get('youtube_thumb'));

$videoId = '';

if($ytLink){

    if(preg_match('/youtu\.be\/([^\?\&]+)/', $ytLink, $m)){
        $videoId = $m[1];
    }
    elseif(preg_match('/v=([^\&]+)/', $ytLink, $m)){
        $videoId = $m[1];
    }
    elseif(preg_match('/embed\/([^\?\&]+)/', $ytLink, $m)){
        $videoId = $m[1];
    }
}

$autoThumb = $videoId
? 'https://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg'
: '';

$finalThumb = $ytThumb
? asset('uploads/settings/'.$ytThumb)
: $autoThumb;

$finalTitle = $ytName ?: 'My Channel';

@endphp



<footer class="premium-footer">
<div class="container">

<div class="row gy-4">

{{-- COLUMN 1 --}}
<div class="col-lg-4 col-md-6">

<h4>
{{ \App\Models\Setting::get('site_name') ?? 'FreeLiveCoupon' }}
</h4>

<p>
{{ \App\Models\Setting::get('footer_desc') ?? 'Best coupon deals, discount codes and saving tips daily.' }}
</p>

@if(\App\Models\Setting::get('footer_logo'))
<img src="{{ asset(\App\Models\Setting::get('footer_logo')) }}"
style="height:55px;">
@endif

</div>


{{-- COLUMN 2 --}}
<div class="col-lg-2 col-md-6">

<h6>Quick Links</h6>

<ul class="footer-links">
<li><a href="{{ route('home') }}">Home</a></li>
<li><a href="{{ route('stores.all') }}">Stores</a></li>
<li><a href="{{ route('coupons.all') }}">Coupons</a></li>
<li><a href="{{ route('categories.all') }}">Categories</a></li>
<li><a href="{{ route('blogs.all') }}">Blogs</a></li>
</ul>

</div>


{{-- COLUMN 3 --}}
<div class="col-lg-2 col-md-6">

<h6>Legal</h6>

<ul class="footer-links">
<li><a href="{{ route('about') }}">About</a></li>
<li><a href="{{ route('contact') }}">Contact</a></li>
<li><a href="/faq">FAQ</a></li>
<li><a href="/terms-condition">Terms</a></li>
<li><a href="/privacy-policy">Privacy Policy</a></li>
</ul>

</div>


{{-- COLUMN 4 --}}
<div class="col-lg-4 col-md-6">

@if($ytLink)

<a href="{{ $ytLink }}"
target="_blank"
class="yt-footer-widget">

@if($finalThumb)
<div class="yt-footer-banner">
<img src="{{ $finalThumb }}"
class="yt-footer-banner-img">
</div>
@endif

<div class="yt-footer-body">

<div class="yt-footer-avatar">

@if($finalThumb)

<img src="{{ $finalThumb }}"
class="yt-footer-avatar-img">

@else

<div class="yt-footer-fallback">
<i class="fab fa-youtube"></i>
</div>

@endif

</div>

<div class="yt-footer-text">

<h5>{{ $finalTitle }}</h5>

<p>
Exclusive deals & latest updates
</p>

</div>

<div class="yt-footer-btn">
▶︎ Subscribe Now
</div>

</div>

</a>

@endif

</div>

</div>


<div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">

<div>
<small>
© {{ date('Y') }}
{{ \App\Models\Setting::get('site_name') ?? 'FreeLiveCoupon' }}
All Rights Reserved
</small>
</div>

<div class="footer-social">

@php
$socials = json_decode(\App\Models\Setting::get('social_links'), true);
@endphp

@if($socials)

@foreach($socials as $item)

<a href="{{ $item['url'] }}" target="_blank">
<i class="{{ $item['icon'] }}"></i>
</a>

@endforeach

@endif

</div>

</div>

</div>
</footer>
<button id="scrollTopBtn">
<i class="fa fa-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let btn = document.getElementById('scrollTopBtn');

window.onscroll = function()
{
btn.style.display = window.scrollY > 200 ? 'block' : 'none';
}

btn.onclick = function()
{
window.scrollTo({
top:0,
behavior:'smooth'
});
}
</script>

</body>
</html>