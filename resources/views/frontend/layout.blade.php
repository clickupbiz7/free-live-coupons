<!DOCTYPE html>
<html>
<head>
<title>{{ \App\Models\Setting::get('site_name') ?? 'Free Coupons' }}</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

@if(\App\Models\Setting::get('favicon'))
<link rel="icon" href="{{ asset(\App\Models\Setting::get('favicon')) }}">
@endif

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* ================= BODY ================= */

body{
    font-family:'Inter',sans-serif;
    background:#f8fafc;
    color:#111827;
}

/* ================= NAVBAR ================= */

.custom-navbar{
    background:#111827;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    padding:12px 0;
}

.custom-navbar .navbar-brand{
    color:#fff;
    font-size:22px;
    font-weight:700;
}

.custom-navbar .navbar-brand img{
    height:44px;
    width:auto;
}

/* MENU LINKS */
.custom-navbar .nav-link{
    color:#fff !important;
    margin-left:18px;
    font-weight:500;
    position:relative;
    transition:.3s;
}

/* TOP LINE */
.custom-navbar .nav-link::before{
    content:'';
    position:absolute;
    top:-5px;
    left:0;
    width:0;
    height:2px;
    background:#facc15;
    transition:.3s;
}

/* BOTTOM LINE */
.custom-navbar .nav-link::after{
    content:'';
    position:absolute;
    bottom:-5px;
    right:0;
    width:0;
    height:2px;
    background:#facc15;
    transition:.3s;
}

/* HOVER */
.custom-navbar .nav-link:hover{
    color:#facc15 !important;
}

.custom-navbar .nav-link:hover::before{
    width:100%;
}

.custom-navbar .nav-link:hover::after{
    width:100%;
}

/* ================= HERO ================= */

.page-hero{
    background:linear-gradient(135deg,#6366f1,#ec4899);
    padding:70px 20px;
    text-align:center;
    color:#fff;
    margin-bottom:45px;
}

.page-hero h1{
    font-size:42px;
    font-weight:700;
}

.page-hero p{
    opacity:.9;
    margin-bottom:0;
}

/* ================= COMMON PAGE SPACING ================= */

section,
.container,
.row{
    position:relative;
}

.page-box{
    padding-top:20px;
    padding-bottom:40px;
}

/* ================= BUTTON ================= */

.btn-gradient{
    background:linear-gradient(90deg,#4f46e5,#7c3aed,#ec4899);
    border:none;
    color:#fff;
}

.btn-gradient:hover{
    color:#fff;
    opacity:.95;
}

/* ================= BLOG PAGE ================= */

.blog-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    height:100%;
    display:flex;
    flex-direction:column;
    transition:.3s;
}

.blog-card:hover{
    transform:translateY(-6px);
}

.blog-img-box{
    height:220px;
    overflow:hidden;
}

.blog-img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.blog-content{
    padding:18px;
    display:flex;
    flex-direction:column;
    flex:1;
}

.blog-title{
    font-size:17px;
    font-weight:700;
    min-height:48px;
}

.blog-desc{
    font-size:14px;
    color:#64748b;
    flex:1;
}

/* ================= SLIDER ================= */

.slider-wrapper{
    overflow:hidden;
    width:100%;
    position:relative;
    margin-bottom:40px;
}

.slider-track{
    display:flex;
    gap:18px;
    width:max-content;
    animation:scrollSlider 35s linear infinite;
}

.slider-wrapper:hover .slider-track{
    animation-play-state:paused;
}

@keyframes scrollSlider{
    from{transform:translateX(0);}
    to{transform:translateX(-50%);}
}

.slider-card{
    min-width:220px;
    max-width:220px;
    background:#fff;
    border-radius:18px;
    padding:20px;
    text-align:center;
    color:#111827;
    box-shadow:0 8px 22px rgba(0,0,0,.05);
    transition:.3s;
    text-decoration:none;
}

.slider-card:hover{
    transform:translateY(-5px);
}

.card-icon-big,
.card-logo-big{
    height:90px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:12px;
}

.card-icon-big img,
.card-logo-big img{
    max-height:80px;
    max-width:100%;
}

.card-icon-big i{
    font-size:42px;
    color:#6366f1;
}

/* ================= FOOTER ================= */

.premium-footer{
    background:#0f172a;
    color:#fff;
    padding:60px 20px 20px;
    margin-top:60px;
}

.premium-footer .inner{
    max-width:1200px;
    margin:auto;
}

.premium-footer h4,
.premium-footer h5,
.premium-footer h6{
    font-weight:700;
    margin-bottom:15px;
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
    color:#fff;
    text-decoration:none;
}

.footer-links a:hover{
    color:#facc15;
}

/* NEWSLETTER */
.newsletter-box input{
    height:46px;
    border:none;
    border-radius:8px;
}

.newsletter-box button{
    height:46px;
    border:none;
    border-radius:8px;
    width:100%;
    margin-top:10px;
}

/* FOOTER BOTTOM */
.footer-bottom{
    border-top:1px solid rgba(255,255,255,.08);
    margin-top:35px;
    padding-top:18px;
}

.footer-social a{
    width:36px;
    height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#1e293b;
    border-radius:50%;
    color:#fff;
    margin-left:8px;
    text-decoration:none;
    transition:.3s;
}

.footer-social a:hover{
    background:#6366f1;
    transform:translateY(-3px);
}

/* ================= SCROLL TOP ================= */

#scrollTopBtn{
    position:fixed;
    bottom:20px;
    right:20px;
    width:42px;
    height:42px;
    border:none;
    border-radius:50%;
    background:#6366f1;
    color:#fff;
    display:none;
    z-index:999;
}

/* ================= MOBILE ================= */

@media(max-width:768px){

.custom-navbar .nav-link{
    margin-left:0;
    margin-top:10px;
}

.page-hero h1{
    font-size:30px;
}

.footer-bottom{
    text-align:center;
}

.footer-social{
    margin-top:12px;
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
@else
FreeLiveCoupon
@endif

</a>

<button class="navbar-toggler text-white" data-bs-toggle="collapse" data-bs-target="#menu">
<i class="fa fa-bars"></i>
</button>

<div class="collapse navbar-collapse justify-content-end" id="menu">

<ul class="navbar-nav">
<li><a class="nav-link" href="{{ route('home') }}">Home</a></li>
<li><a class="nav-link" href="{{ route('stores.all') }}">Stores</a></li>
<li><a class="nav-link" href="{{ route('categories.all') }}">Categories</a></li>
<li><a class="nav-link" href="{{ route('blogs.all') }}">Blogs</a></li>
<li><a class="nav-link" href="{{ route('about') }}">About</a></li>
<li><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
</ul>

</div>
</div>
</nav>

@yield('content')

<!-- FOOTER -->
<footer class="premium-footer">
<div class="inner">

<div class="row gy-4">

<div class="col-md-4">
<h4>{{ \App\Models\Setting::get('site_name') }}</h4>
<p>{{ \App\Models\Setting::get('footer_desc') }}</p>

@if(\App\Models\Setting::get('footer_logo'))
<img src="{{ asset(\App\Models\Setting::get('footer_logo')) }}" style="height:55px;">
@endif
</div>

<div class="col-md-2">
<h6>Quick Links</h6>
<ul class="footer-links">
<li><a href="/">Home</a></li>
<li><a href="/stores">Stores</a></li>
<li><a href="/coupons">Coupons</a></li>
<li><a href="/categories">Categories</a></li>
<li><a href="/blogs">Blogs</a></li>
</ul>
</div>

<div class="col-md-3">
<h6>Legal</h6>
<ul class="footer-links">
<li><a href="/about">About Us</a></li>
<li><a href="/contact">Contact Us</a></li>
<li><a href="/faq">FAQ</a></li>
<li><a href="/terms-condition">Terms</a></li>
<li><a href="/privacy-policy">Privacy Policy</a></li>


</ul>
</div>

<div class="col-md-3">
<h6>Newsletter</h6>

<form class="newsletter-box">
<input type="email" class="form-control mb-2" placeholder="Your Email">

<button class="btn btn-gradient">
Subscribe
</button>
</form>

</div>

</div>

<div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">

<div>
<small>
© {{ date('Y') }} {{ \App\Models\Setting::get('site_name') }} All Rights Reserved
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

window.onscroll = function(){
btn.style.display = window.scrollY > 200 ? 'block' : 'none';
}

btn.onclick = function(){
window.scrollTo({top:0,behavior:'smooth'});
}
</script>

</body>
</html>