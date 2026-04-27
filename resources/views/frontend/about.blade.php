{{-- FILE: resources/views/frontend/about.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="inner-hero">
<div class="container text-center">

<h1>About Us</h1>
<p>Save more. Shop smarter. Live better.</p>

</div>
</section>


<div class="container py-5">

<!-- ABOUT SECTION -->
<div class="row align-items-center g-5 mb-5">

<div class="col-lg-6">

<div class="about-image-wrap">

<img src="{{ asset('images/about.jpg') }}"
onerror="this.src='https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=900&q=80'"
class="img-fluid about-img">

<div class="floating-badge">
<i class="fa fa-shield-check"></i> Trusted Deals
</div>

</div>

</div>


<div class="col-lg-6">

<span class="mini-tag">🔥 Free Live Coupons</span>

<h2 class="about-title">
Your Smart Savings Partner
</h2>

<p class="about-text">
We bring the latest coupon codes, verified discounts, promo deals and daily offers from trusted stores.
</p>

<p class="about-text">
Our goal is simple: help users save more money while shopping online through genuine offers.
</p>

<div class="about-points">

<div><i class="fa fa-check-circle"></i> Verified Coupons</div>
<div><i class="fa fa-check-circle"></i> Daily Fresh Deals</div>
<div><i class="fa fa-check-circle"></i> Trusted Brands</div>
<div><i class="fa fa-check-circle"></i> Fast Browsing Experience</div>

</div>

<a href="/coupons" class="hero-btn mt-4 d-inline-block">
Browse Coupons
</a>

</div>

</div>



<!-- STATS -->
<div class="row g-4 mb-5 text-center">

<div class="col-md-3 col-6">
<div class="stat-box">
<h3>500+</h3>
<p>Coupons</p>
</div>
</div>

<div class="col-md-3 col-6">
<div class="stat-box">
<h3>200+</h3>
<p>Stores</p>
</div>
</div>

<div class="col-md-3 col-6">
<div class="stat-box">
<h3>50+</h3>
<p>Categories</p>
</div>
</div>

<div class="col-md-3 col-6">
<div class="stat-box">
<h3>10K+</h3>
<p>Users</p>
</div>
</div>

</div>



<!-- FEATURES -->
<div class="text-center mb-4">
<span class="mini-tag">Why Choose Us</span>
<h2 class="section-title">Built For Smart Shoppers</h2>
</div>

<div class="row g-4">

<div class="col-lg-4 col-md-6">
<div class="feature-box">
<div class="feature-icon">
<i class="fa fa-tags"></i>
</div>
<h5>Best Deals</h5>
<p>Find premium discounts and working coupon codes daily.</p>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="feature-box">
<div class="feature-icon">
<i class="fa fa-bolt"></i>
</div>
<h5>Fast Updates</h5>
<p>Fresh offers added regularly from top stores.</p>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="feature-box">
<div class="feature-icon">
<i class="fa fa-shield-alt"></i>
</div>
<h5>Trusted Platform</h5>
<p>Only selected and verified promotions listed.</p>
</div>
</div>

</div>

</div>



<!-- CTA -->
<section class="cta-section mt-5">

<div class="container text-center">

<h2>Start Saving Today 🚀</h2>
<p>Explore top stores and latest discounts now.</p>

<a href="/coupons" class="cta-btn">
Browse Coupons
</a>

</div>

</section>



<style>

/* HERO */
.inner-hero{
padding:85px 0;
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

/* TAG */
.mini-tag{
display:inline-block;
padding:7px 14px;
border-radius:30px;
font-size:12px;
font-weight:600;
color:#4f46e5;
background:#eef2ff;
margin-bottom:15px;
}

/* ABOUT */
.about-image-wrap{
position:relative;
}

.about-img{
border-radius:18px;
box-shadow:0 18px 40px rgba(0,0,0,.12);
width:100%;
}

.floating-badge{
position:absolute;
bottom:20px;
left:20px;
background:#fff;
padding:10px 14px;
border-radius:12px;
font-weight:800;
box-shadow:0 10px 20px rgba(0,0,0,.08);
}

.about-title{
font-size:30px;
font-weight:600;
line-height:1.2;
margin-bottom:18px;
color:#111827;
}

.about-text{
font-size:16px;
color:#64748b;
line-height:1.8;
margin-bottom:14px;
}

.about-points{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:12px;
margin-top:20px;
}

.about-points div{
font-weight:700;
font-size:14px;
color:#111827;
}

.about-points i{
color:#16a34a;
margin-right:6px;
}

/* BUTTON */
.hero-btn,
.cta-btn{
padding:14px 28px;
border-radius:12px;
font-weight:600;
text-decoration:none;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
display:inline-block;
transition:.3s;
}

.hero-btn:hover,
.cta-btn:hover{
transform:translateY(-3px);
color:#fff;
}

/* STATS */
.stat-box{
background:#fff;
padding:28px 20px;
border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,.06);
height:100%;
}

.stat-box h3{
font-size:38px;
font-weight:600;
margin-bottom:8px;
background:linear-gradient(135deg,#4f46e5,#d946ef);
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}

.stat-box p{
margin:0;
font-weight:600;
color:#64748b;
}

/* TITLE */
.section-title{
font-size:30px;
font-weight:600;
margin-top:10px;
}

/* FEATURES */
.feature-box{
background:#fff;
padding:28px;
border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,.06);
height:100%;
transition:.3s;
text-align:center;
}

.feature-box:hover{
transform:translateY(-8px);
box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.feature-icon{
width:72px;
height:72px;
border-radius:18px;
margin:auto auto 18px;
display:flex;
align-items:center;
justify-content:center;
font-size:28px;
background:linear-gradient(135deg,#eef2ff,#f5f3ff);
color:#4f46e5;
}

.feature-box h5{
font-size:22px;
font-weight:600;
margin-bottom:10px;
}

.feature-box p{
color:#64748b;
margin:0;
}

/* CTA */
.cta-section{
padding:80px 0;
background:
radial-gradient(circle at left,#ffffff22,transparent 30%),
linear-gradient(135deg,#4f46e5,#7c3aed,#d946ef);
color:#fff;
}

.cta-section h2{
font-size:46px;
font-weight:600;
margin-bottom:12px;
}

.cta-section p{
font-size:18px;
opacity:.95;
margin-bottom:28px;
}

/* MOBILE */
@media(max-width:768px){

.inner-hero h1{
font-size:38px;
}

.about-title{
font-size:32px;
}

.section-title{
font-size:30px;
}

.cta-section h2{
font-size:32px;
}

.about-points{
grid-template-columns:1fr;
}

}

</style>

@endsection