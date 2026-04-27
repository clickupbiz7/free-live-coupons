@extends('frontend.layout')

@section('content')

<section class="hero-pro">
<div class="container">
<div class="hero-inner text-center">

<h1>Save More With Premium Coupons</h1>
<p>Latest deals, promo codes & top store discounts</p>

<form action="{{ route('coupons.all') }}" method="GET" class="hero-search">
<input type="text" name="search" placeholder="Search coupons, stores...">
<button type="submit">Search</button>
</form>

<div class="hero-btns">
<a href="{{ route('stores.all') }}">Browse Stores</a>
<a href="{{ route('categories.all') }}">Explore Categories</a>
<a href="{{ route('coupons.all') }}">Latest Coupons</a>
<a href="{{ route('stores.all') }}">Top Stores</a>
<a href="{{ route('faq') }}">FAQ</a>
<a href="{{ route('blogs.all') }}">Savings Tips</a>
</div>

</div>
</div>
</section>

<div class="container py-4">

@if(isset($homeTopAd) && $homeTopAd)
<div class="container py-3">
<div class="ads-box text-center">
{!! $homeTopAd->ad_code !!}
</div>
</div>
@endif

<div class="section-head">
<h2>Latest Coupons</h2>
<a href="{{ route('coupons.all') }}" class="view-all-btn">View All</a>
</div>

<div class="row g-4">

@foreach($coupons->take(8) as $c)

<div class="col-lg-3 col-md-6">

<div class="coupon-pro-card premium-coupon-card">

<div class="coupon-img-wrap">

<img src="{{ asset('uploads/coupons/'.$c->image) }}"
onerror="this.src='https://via.placeholder.com/400x250'">

{{-- VERIFIED BADGE --}}
<div class="verified-badge-new">
<span class="v-icon">✔</span>
<span class="v-text">VERIFIED</span>
</div>

{{-- LIMITED BADGE --}}
<div class="limited-ribbon">
<span>
{{ explode(' ', $c->badge)[0] ?? 'LIMITED' }}
<small>{{ explode(' ', $c->badge)[1] ?? ' ' }}</small>
</span>
</div>

</div>

<div class="coupon-content">

{{-- CATEGORY + STORE MINI CARDS --}}
<div class="meta-cards-wrap">

<div class="meta-mini-card category-mini">
<span>{{ $c->category->name ?? 'Category' }}</span>
</div>

<div class="meta-mini-card store-mini">
<span>{{ $c->store->name ?? 'Store' }}</span>
</div>

</div>

<h5>{{ \Illuminate\Support\Str::limit($c->title,36) }}</h5>

@if($c->description)
<p class="coupon-desc">
{{ \Illuminate\Support\Str::limit($c->description,55) }}
</p>
@endif

@php
$discount = explode(' ', trim($c->discount));
$left = $discount[0] ?? '20';
$right = $discount[1] ?? 'OFF';
@endphp

{{-- DISCOUNT BOX --}}
<div class="voucher-split-box">

<div class="voucher-left">
{{ $left }}
</div>

<div class="voucher-right">
{{ $right }}
</div>

</div>

<div class="expiry-wrap">

<span>
Expiry:
{{ $c->expiry_date ? date('d M',strtotime($c->expiry_date)) : 'Soon' }}
</span>

<span class="live-timer"
data-date="{{ $c->expiry_date ? \Carbon\Carbon::parse($c->expiry_date)->format('Y-m-d') : '' }}">
Loading...
</span>

</div>

{{--------- REVEAL BUTTON -------------}}

<button class="reveal-btn premium-reveal-btn"
data-bs-toggle="modal"
data-bs-target="#couponModal{{ $c->id }}">

<span class="btn-front">
@if($c->code)
Reveal Code
@else
View Deal
@endif
</span>

<span class="btn-back">

@if($c->code)

@php
$code = $c->code;
$visible = substr($code,0,3);
$hidden = str_repeat('#', max(strlen($code)-2,2));
@endphp

{{ $visible.$hidden }}

@else

Open Now

@endif

</span>

</button>

</div>
</div>
</div>

{{------------------------- MODAL ----------------------}}

<div class="modal fade" id="couponModal{{ $c->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-md">
<div class="modal-content premium-modal-wrap">

{{-- TOP IMAGE --}}
<div class="modal-top-image">

<img src="{{ asset('uploads/coupons/'.$c->image) }}"
onerror="this.src='https://via.placeholder.com/600x280'">

</div>

<div class="modal-body premium-modal-body">

<h4 class="modal-title-pro">{{ $c->title }}</h4>

<div class="voucher-split-box mt-3 mb-3">
<div class="voucher-left">{{ $left }}</div>
<div class="voucher-right">{{ $right }}</div>
</div>

@if($c->code)

<div class="code-box">{{ $c->code }}</div>

<button type="button"
class="copy-btn premium-modal-btn mt-3"
onclick="copyCouponAndOpen(this)"
data-id="{{ $c->id }}"
data-code="{{ $c->code }}"
data-link="{{ $c->affiliate_link }}">

<span class="btn-front">Copy Code</span>
<span class="btn-back">{{ $c->code }}</span>

</button>

@else

<a href="{{ $c->affiliate_link }}"
target="_blank"
class="copy-btn premium-modal-btn mt-3 text-decoration-none">

<span class="btn-front">Open Deal</span>
<span class="btn-back">Go Now</span>

</a>

@endif

{{-- SHARE --}}
<div class="share-row premium-share-row">

<a target="_blank"
href="https://facebook.com/sharer/sharer.php?u={{ url()->current() }}">
<i class="fab fa-facebook-f"></i>
</a>

<a target="_blank"
href="https://twitter.com/intent/tweet?url={{ url()->current() }}">
<i class="fab fa-x-twitter"></i>
</a>

<a target="_blank"
href="https://wa.me/?text={{ url()->current() }}">
<i class="fab fa-whatsapp"></i>
</a>

<a target="_blank"
href="https://pinterest.com/pin/create/button/?url={{ url()->current() }}">
<i class="fab fa-pinterest"></i>
</a>

</div>

<a href="{{ route('terms') }}"
class="terms-box-btn">
Terms & Conditions
</a>

</div>
</div>
</div>
</div>

@endforeach

</div>

{{------------------------- TOP CATEGORIES -----------------------}}

<div class="section-head mt-5">
<h2>Top Categories</h2>
<a href="{{ route('categories.all') }}" class="view-all-btn">View All</a>
</div>

<div class="marquee-wrap">
<div class="marquee-track">

@foreach($categories as $cat)
<a href="{{ url('category/'.$cat->slug) }}" class="slider-card">

<div class="card-icon-big">

@if($cat->icon && file_exists(public_path('uploads/categories/icons/'.$cat->icon)))

<img src="{{ asset('uploads/categories/icons/'.$cat->icon) }}"
style="max-height:90px;max-width:100%;object-fit:contain;">

@elseif($cat->image)

<img src="{{ asset('uploads/categories/'.$cat->image) }}"
style="max-height:90px;max-width:100%;object-fit:contain;">

@else

<i class="fa fa-tag"></i>

@endif

</div>

<h6>{{ $cat->name }}</h6>
<small>{{ \App\Models\Coupon::where('category_id',$cat->id)->count() }} Offers</small>

</a>
@endforeach


@foreach($categories as $cat)
<a href="{{ url('category/'.$cat->slug) }}" class="slider-card">

<div class="card-icon-big">

@if($cat->icon && file_exists(public_path('uploads/categories/icons/'.$cat->icon)))

<img src="{{ asset('uploads/categories/icons/'.$cat->icon) }}"
style="max-height:90px;max-width:100%;object-fit:contain;">

@elseif($cat->image)

<img src="{{ asset('uploads/categories/'.$cat->image) }}"
style="max-height:90px;max-width:100%;object-fit:contain;">

@else

<i class="fa fa-tag"></i>

@endif

</div>

<h6>{{ $cat->name }}</h6>
<small>{{ \App\Models\Coupon::where('category_id',$cat->id)->count() }} Offers</small>

</a>
@endforeach

</div>
</div>


{{------------------------------- TOP STORES -----------------------}}

<div class="section-head mt-5">
<h2>Top Stores</h2>
<a href="{{ route('stores.all') }}" class="view-all-btn">View All</a>
</div>

<div class="marquee-wrap">
<div class="marquee-track reverse-track">

@foreach($stores as $store)
<a href="{{ route('store.single',$store->slug) }}" class="store-card-pro">
<div class="store-img-edge">
<img src="{{ asset('uploads/stores/'.$store->logo) }}">
</div>
<div class="store-bottom">
<h6>{{ $store->name }}</h6>
<small>View Deals</small>
</div>
</a>
@endforeach

@foreach($stores as $store)
<a href="{{ route('store.single',$store->slug) }}" class="store-card-pro">
<div class="store-img-edge">
<img src="{{ asset('uploads/stores/'.$store->logo) }}">
</div>
<div class="store-bottom">
<h6>{{ $store->name }}</h6>
<small>View Deals</small>
</div>
</a>
@endforeach

</div>
</div>

{{-- ================= HOME MIDDLE AD ================= --}}

@if(isset($homeMiddleAd) && $homeMiddleAd)
<div class="ads-box text-center mb-4">
    {!! $homeMiddleAd->ad_code !!}
</div>
@endif

{{---------------------------- HOW IT WORKS ----------------------}}

<section class="how-work-section mt-5">

<div class="container">

<div class="how-head text-center">
<h2>How does it work?</h2>
<p>Our AI solution will help you from start to finish</p>
</div>

<div class="how-line-wrap">

<!-- Step 1 -->
<div class="how-box">
<div class="how-number">1</div>
<h4>Find Coupon</h4>
<p>Search stores, categories or latest deals.</p>
</div>

<!-- Step 2 -->
<div class="how-box">
<div class="how-number">2</div>
<h4>Copy Code</h4>
<p>Open coupon popup and copy promo code instantly.</p>
</div>

<!-- Step 3 -->
<div class="how-box">
<div class="how-number">3</div>
<h4>Save Money</h4>
<p>Use code on checkout and enjoy discount.</p>
</div>

</div>

</div>

</section>


{{--------------------------- BLOGS ----------------------------}}

<div class="section-head mt-5">
<h2>Latest Blogs</h2>
<a href="{{ route('blogs.all') }}" class="view-all-btn">View All</a>
</div>

<div class="row g-4">

@foreach($blogs as $blog)
<div class="col-lg-3 col-md-6">
<div class="blog-pro">

<img src="{{ asset('uploads/blogs/'.$blog->image) }}">

<div class="p-3">
<h6>{{ \Illuminate\Support\Str::limit($blog->title,42) }}</h6>
<p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),70) }}</p>

<a href="{{ url('/blog/'.$blog->slug) }}" class="read-btn">
Read More
</a>

</div>
</div>
</div>
@endforeach

</div>

</div>


   {{-- ================= OPEN BOTTOM AD ================= --}}
@if(isset($homeBottomAd) && $homeBottomAd)
<div class="ads-box text-center mt-5">
    {!! $homeBottomAd->ad_code !!}
</div>
@endif
 {{-- ================= Close BOTTOM AD ================= --}}

<style>
/****************************** ADS ONLY ***********************************/

.ads-box{
margin-top:0;
background:#fff;
padding:18px;
border-radius:14px;
box-shadow:0 10px 25px rgba(0,0,0,.06);
border:1px solid #ececec;
overflow:hidden;
}

.ads-box iframe,
.ads-box img,
.ads-box ins{
max-width:100% !important;
display:block;
margin:auto;
}

@media(max-width:768px){
.ads-box{
padding:0;
border-radius:12px;
}
}

/********************************** RESET *******************************/

html,body{
margin:0;
padding:0;
font-size:16px;
zoom:1 !important;
transform:none !important;
overflow-x:hidden;
}

.container{
max-width:1320px !important;
width:100%;
margin:auto;
padding-left:15px;
padding-right:15px;
}

/*********************************** HERO *********************************/

.hero-pro{
padding:150px 0 !important;
background:
radial-gradient(circle at left,#ffffff22,transparent 30%),
linear-gradient(135deg,#4f46e5,#7c3aed,#d946ef);
color:#fff;
}

.hero-inner{
max-width:900px;
margin:auto;
}

.hero-pro h1{
font-size:36px;
font-weight:600;
margin-bottom:15px;
}

.hero-pro p{
font-size:18px;
opacity:.92;
}

.hero-search{
margin-top:25px;
display:flex;
justify-content:center;
gap:10px;
flex-wrap:wrap;
}

.hero-search input{
width:520px;
padding:15px;
border:none;
border-radius:10px;
}

.hero-search button{
padding:15px 28px;
border-radius:10px;
font-weight:600;
background: rgba(255,255,255,.08);
border:1px solid rgba(255,255,255,.12);
color:#fff;
}

.hero-search button:hover{
background:#fff !important;
color:#111;
}


.hero-btns{
display:flex;
flex-wrap:wrap;
gap:8px;
justify-content:center;
margin-top:30px;
}

.hero-btns a{
padding:11px 18px;
border-radius:10px;
text-decoration:none;
font-weight:600;
color:#fff;
background:rgba(255,255,255,.08);
border:1px solid rgba(255,255,255,.12);
}

.hero-btns a:hover{
background:#fff;
color:#111;
}

/********************************** Section 1 *********************************/

.section-head{
display:flex;
justify-content:space-between;
align-items:center;
gap:20px;
margin-bottom:22px;
flex-wrap:wrap;
}

.section-head h2{
font-size:26px;
font-weight:600;
margin:0;
}

.view-all-btn{
font-weight:600;
text-decoration:none;
color:#2563eb;
white-space:nowrap;
}

/********************************** Lastest COUPON *******************************/
.premium-coupon-card{
background:#fff;
border-radius:18px;
overflow:hidden;
box-shadow:0 12px 30px rgba(0,0,0,.08);
border:1px solid #ececec;
height:auto;
transition:.3s;
}

.premium-coupon-card:hover{
transform:translateY(-8px);
box-shadow:0 18px 40px rgba(0,0,0,.14);
}

.coupon-img-wrap{
height:185px;
position:relative;
overflow:hidden;
}

.coupon-img-wrap img{
width:100%;
height:100%;
object-fit:cover;
}

/************************************ VERIFIED **********************************/
.verified-badge-new{
position:absolute;
top:12px;
left:12px;
display:flex;
align-items:center;
z-index:5;
}

.v-icon{
width:28px;
height:28px;
border-radius:50%;
background:#0ea5e9;
color:#fff;
display:flex;
align-items:center;
justify-content:center;
font-size:13px;
font-weight:700;
}

.v-text{
height:28px;
padding:0 12px;
background:#111;
color:#fff;
display:flex;
align-items:center;
font-size:11px;
font-weight:800;
letter-spacing:.8px;
border-radius:20px;
margin-left:4px;
}

/**************************************** LIMITED ********************************/
.limited-ribbon{
position:absolute;
top:-2px;
right:14px;
background:#ef4444;
color:#fff;
padding:10px 10px 12px;
font-size:11px;
font-weight:800;
border-radius:0 0 8px 8px;
// box-shadow:0 8px 18px rgba(0,0,0,.18);
z-index:5;
}

.limited-ribbon:before{
content:'';
position:absolute;
top:0;
left:-6px;
border-right:6px solid #b91c1c;
border-top:6px solid transparent;
}

.limited-ribbon:after{
content:'';
position:absolute;
top:0;
right:-6px;
border-left:6px solid #b91c1c;
border-top:6px solid transparent;
}

.limited-ribbon span{
display:flex;
flex-direction:column;
align-items:center;
justify-content:center;
gap:4px;
transform:rotate(-360deg);
transform-origin:center;
line-height:1;
margin-top:25px;
white-space:normal;
text-align:center;
}

.limited-ribbon small{
font-size:11px;
text-align:center;
font-weight:700;
}

/************************************* CONTENT *******************************/
.coupon-content{
padding:14px;
}

.meta-cards-wrap{
display:flex;
gap:6px;
margin-bottom:12px;
}

.meta-mini-card{
flex:1;
min-height:20px;
border-radius:6px;
padding:6px;
display:flex;
align-items:center;
justify-content:center;
text-align:center;
font-size:11px;
font-weight:600;
line-height:1.2;
overflow:hidden;
}

.category-mini{
background:linear-gradient(135deg,#2563eb,#1d4ed8);
color:#fff;
box-shadow:0 8px 18px rgba(37,99,235,.18);
}

.store-mini{
background:linear-gradient(135deg,#ffffff,#f5f5f5);
color:#111;
border:1px solid #e5e7eb;
box-shadow:0 8px 18px rgba(0,0,0,.05);
}

.coupon-content h5{
font-size:17px;
font-weight:600;
line-height:1.35;
margin-bottom:8px;
min-height:auto;
}

.coupon-desc{
font-size:13px;
color:#6b7280;
margin-bottom:12px;
line-height:1.5;
}

/****************************** DISCOUNT VOUCHER ********************************/
.voucher-split-box{
display:grid;
grid-template-columns:1fr 2fr;
border-radius:10px;
overflow:hidden;
margin-bottom:12px;
box-shadow:0 10px 22px rgba(0,0,0,.08);
}

.voucher-left{
background:linear-gradient(135deg,#7c3aed,#d946ef);
color:#fff;
padding:8px 10px;
font-size:22px;
font-weight:600;
text-align:center;
letter-spacing:.5px;
}

.voucher-right{
background:#fff7ed;
color:#111;
padding:8px 10px;
display:flex;
align-items:center;
justify-content:center;
font-size:16px;
font-weight:600;
border-left:2px dashed rgba(0,0,0,.15);
}


/**************************** EXPIRY & Live Time *********************************/
.expiry-wrap{
display:flex;
justify-content:space-between;
gap:10px;
font-size:12px;
font-weight:700;
color:#6b7280;
margin-bottom:14px;
}

.live-timer{
color:#dc2626;
}

/******************************** REVEAL BUTTON *********************************/
.premium-reveal-btn{
width:100%;
height:52px;
border:none;
border-radius:14px;
position:relative;
overflow:hidden;
cursor:pointer;
background:#111;
box-shadow:0 10px 22px rgba(0,0,0,.08);
}

.premium-reveal-btn:before,
.premium-reveal-btn:after{
content:'';
position:absolute;
top:50%;
transform:translateY(-50%);
width:16px;
height:16px;
background:#fff;
border-radius:50%;
z-index:3;
}

.premium-reveal-btn:before{
left:-8px;
}

.premium-reveal-btn:after{
right:-8px;
}

.premium-reveal-btn .btn-front,
.premium-reveal-btn .btn-back{
position:absolute;
inset:0;
display:flex;
align-items:center;
justify-content:center;
font-size:16px;
font-weight:700;
transition:.45s ease;
}

.premium-reveal-btn .btn-front{
background:linear-gradient(135deg,#111827,#374151);
color:#fff;
z-index:2;
letter-spacing:.4px;
}

.premium-reveal-btn .btn-back{
background:linear-gradient(135deg,#7c3aed,#d946ef);
color:#fff;
}

.premium-reveal-btn:hover .btn-front{
transform:translateX(100%);
}

/* MOBILE */
@media(max-width:768px){

.coupon-img-wrap{
height:250px;
}

.meta-cards-wrap{
flex-direction:row;
}

.meta-mini-card{
min-height:25px;
font-size:11px;
}

.voucher-left{
font-size:18px;
}

.voucher-right{
font-size:14px;
}

.premium-reveal-btn{
height:48px;
}

}

/************************************ SLIDER ***********************************/
.marquee-wrap{
overflow:hidden;
cursor:grab;
}

.marquee-track{
display:flex;
gap:18px;
width:max-content;
animation:scrollLeft 35s linear infinite;
}

.reverse-track{
animation:scrollRight 35s linear infinite;
}

.marquee-wrap:hover .marquee-track{
animation-play-state:paused;
}

.slider-card,
.store-card-pro{
min-width:240px;
background:#fff;
border-radius:14px;
text-decoration:none;
color:#111;
box-shadow:0 10px 25px rgba(0,0,0,.06);
overflow:hidden;
flex-shrink:0;
}

.slider-card{
padding:18px;
text-align:center;
}

.card-icon-big{
height:90px;
display:flex;
align-items:center;
justify-content:center;
margin-bottom:12px;
}

.card-icon-big img{
max-height:90px;
max-width:100%;
}

.store-img-edge{
height:170px;
}

.store-img-edge img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.store-bottom{
padding:14px;
text-align:center;
}

/******************************** hOW ITS wORK ***********************************/

.how-work-section{
padding:85px 0;
background:linear-gradient(135deg,#050b18,#0b1430,#111c42,#050b18);
border-radius:28px;
overflow:hidden;
position:relative;
width:100%;
box-shadow:0 25px 60px rgba(0,0,0,.18);
}

/* Voucher Side Cut Design */
.how-work-section::before,
.how-work-section::after{
content:"";
position:absolute;
top:50%;
transform:translateY(-50%);
width:46px;
height:46px;
background:#f5f7fb;
border-radius:50%;
z-index:5;
}

.how-work-section::before{
left:-23px;
}

.how-work-section::after{
right:-23px;
}

/* Light Glow */
.how-work-section .glow-1,
.how-work-section .glow-2{
position:absolute;
border-radius:50%;
filter:blur(70px);
opacity:.22;
pointer-events:none;
}

.how-work-section .glow-1{
width:220px;
height:220px;
background:#6366f1;
top:-70px;
left:-40px;
}

.how-work-section .glow-2{
width:240px;
height:240px;
background:#06b6d4;
bottom:-90px;
right:-50px;
}

.how-work-section .container{
max-width:100% !important;
padding-left:50px;
padding-right:50px;
position:relative;
z-index:2;
}

.how-head{
margin-bottom:65px;
text-align:center;
}

.how-head h2{
font-size:40px;
font-weight:800;
color:#fff;
margin-bottom:10px;
letter-spacing:-0.5px;
}

.how-head p{
font-size:18px;
color:rgba(255,255,255,.72);
margin:0;
}

.how-line-wrap{
display:flex;
justify-content:space-between;
align-items:flex-start;
gap:30px;
position:relative;
}

/* Dotted Line */
.how-line-wrap::before{
content:"";
position:absolute;
top:28px;
left:13%;
right:13%;
height:3px;
background-image:linear-gradient(
90deg,
rgba(255,255,255,.75) 30%,
transparent 30%
);
background-size:18px 3px;
background-repeat:repeat-x;
z-index:0;
opacity:.7;
}

.how-box{
width:33.33%;
text-align:center;
position:relative;
z-index:2;
padding:0 10px;
transition:.35s;
}

.how-box:hover{
transform:translateY(-8px);
}

.how-number{
width:62px;
height:62px;
line-height:62px;
margin:0 auto 24px;
border-radius:50%;
background:#fff;
font-size:24px;
font-weight:900;
color:#243b63;
box-shadow:0 10px 25px rgba(255,255,255,.18);
}

.how-box h4{
font-size:22px;
font-weight:700;
color:#fff;
margin-bottom:12px;
}

.how-box p{
font-size:16px;
line-height:1.8;
color:rgba(255,255,255,.74);
max-width:300px;
margin:auto;
}

/* MOBILE */
@media(max-width:991px){

.how-work-section{
padding:65px 25px;
border-radius:22px;
}

.how-head h2{
font-size:32px;
}

.how-line-wrap{
flex-direction:column;
gap:40px;
}

.how-line-wrap::before{
display:none;
}

.how-box{
width:100%;
}

.how-work-section::before,
.how-work-section::after{
display:none;
}

}

@media(max-width:576px){

.how-head h2{
font-size:28px;
}

.how-head p{
font-size:16px;
}

.how-number{
width:56px;
height:56px;
line-height:56px;
font-size:22px;
}

.how-box h4{
font-size:20px;
}

}

/* BLOG */
.blog-pro{
// background:#fff;
border-radius:14px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.07);
height:100%;
}

.blog-pro img{
width:100%;
height:200px;
object-fit:cover;
}

/******************************* PREMIUM MODAL CSS ************************/
.premium-modal-wrap{
border:none;
border-radius:22px;
overflow:hidden;
box-shadow:0 25px 60px rgba(0,0,0,.18);
background:#fff;
}

.modal-top-image{
width:100%;
height:180px;
overflow:hidden;
border-radius:22px 22px 0 0;
background:#f8fafc;
}

.modal-top-image img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.premium-modal-body{
padding:16px;
text-align:center;
}

.modal-title-pro{
font-size:16px;
font-weight:700;
line-height:1.35;
margin:0 0 10px;
color:#111827;
}

.premium-modal-btn{
width:100%;
height:54px;
border:none;
border-radius:16px;
position:relative;
overflow:hidden;
cursor:pointer;
display:block;
padding:0;
background:#111827;
box-shadow:0 12px 24px rgba(0,0,0,.08);
}

.premium-modal-btn:before,
.premium-modal-btn:after{
content:'';
position:absolute;
top:50%;
transform:translateY(-50%);
width:16px;
height:16px;
background:#fff;
border-radius:50%;
z-index:3;
}

.premium-modal-btn:before{left:-8px;}
.premium-modal-btn:after{right:-8px;}

.premium-modal-btn .btn-front,
.premium-modal-btn .btn-back{
position:absolute;
inset:0;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
font-weight:600;
transition:.45s ease;
}

.premium-modal-btn .btn-front{
background:linear-gradient(135deg,#111827,#374151);
color:#fff;
z-index:2;
}

.premium-modal-btn .btn-back{
background:linear-gradient(135deg,#7c3aed,#d946ef);
color:#fff;
}

.premium-modal-btn:hover .btn-front{
transform:translateX(100%);
}

.premium-share-row{
display:flex;
justify-content:center;
gap:12px;
margin-top:18px;
margin-bottom:14px;
flex-wrap:wrap;
}

.premium-share-row a{
width:42px;
height:42px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
background:#f8fafc;
border:1px solid #e5e7eb;
color:#111827;
text-decoration:none;
box-shadow:0 6px 14px rgba(0,0,0,.05);
transition:.25s;
}

.premium-share-row a:hover{
transform:translateY(-3px);
}

.terms-box-btn{
display:block;
width:100%;
padding:8px 16px;
border-radius:10px;
background:#f8fafc;
border:1px solid #eef2f7;
box-shadow:0 8px 18px rgba(0,0,0,.04);
font-size:11px;
font-weight:700;
color:#111827;
text-decoration:none;
}

.code-box{
padding:10px;
font-size:20px;
font-weight:600;
border:2px dashed #111827;
border-radius:10px;
letter-spacing:2px;
margin-top:6px;
}

@media(max-width:768px){

.modal-top-image{
height:150px;
}

.premium-modal-body{
padding:16px;
}

.modal-title-pro{
font-size:20px;
}

.premium-modal-btn{
height:50px;
}

.premium-share-row a{
width:38px;
height:38px;
}

.terms-box-btn{
font-size:12px;
padding:8px 12px;
}
}



.read-btn,.copy-btn{
display:block;
width:100%;
padding:12px;
border:none;
border-radius:8px;
text-align:center;
font-weight:600;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
text-decoration:none;
}

.read-btn:hover{
font-weight:600;
color:#111;
background:#fff;
box-shadow:0 10px 25px rgba(0,0,0,.07);
}


@keyframes scrollLeft{
0%{transform:translateX(0);}
100%{transform:translateX(-50%);}
}

@keyframes scrollRight{
0%{transform:translateX(-50%);}
100%{transform:translateX(0);}
}

@media(max-width:768px){

.hero-pro{
padding:70px 0;
}

.hero-pro h1{
font-size:25px;
}

.hero-search input{
width:70%;
}

.hero-btns a{
font-size:13px;
padding:10px 14px;
}

.section-head h2{
font-size:26px;
}

.slider-card,
.store-card-pro{
min-width:180px;
}

}

</style>


<script>

function copyCouponAndOpen(btn)
{
var code = btn.getAttribute("data-code") || "";
var link = btn.getAttribute("data-link") || "";
var coupon = btn.getAttribute("data-id") || "";

if(coupon != ''){
fetch('/track-click/' + coupon);
}

copyNow(code);

showCopyToast();

if(link !== ''){
setTimeout(function(){

var newTab = window.open(link,'_blank');

if(!newTab){
window.location.href = link;
}

},1500);
}

return false;
}

/* COPY */
function copyNow(text)
{
if(navigator.clipboard && window.isSecureContext){

navigator.clipboard.writeText(text).catch(function(){
fallbackCopy(text);
});

}else{
fallbackCopy(text);
}
}

function fallbackCopy(text)
{
var ta = document.createElement("textarea");
ta.value = text;
document.body.appendChild(ta);
ta.focus();
ta.select();

try{
document.execCommand("copy");
}catch(e){}

document.body.removeChild(ta);
}

/* TOAST */
function showCopyToast()
{
var old = document.getElementById("copyToast");
if(old){ old.remove(); }

var toast = document.createElement("div");
toast.id = "copyToast";
toast.innerHTML = "✅ Code Copied";

toast.style.position = "fixed";
toast.style.top = "15px";
toast.style.right = "15px";
toast.style.background = "#111827";
toast.style.color = "#fff";
toast.style.padding = "12px 16px";
toast.style.borderRadius = "10px";
toast.style.fontWeight = "700";
toast.style.zIndex = "999999";

document.body.appendChild(toast);

setTimeout(function(){
toast.remove();
},1700);
}


/* ==================================== */
/* TIMER */
/* ==================================== */

function updateCouponTimers(){

document.querySelectorAll('.live-timer').forEach(function(el){

var date = el.getAttribute('data-date');

if(!date){
el.innerHTML = 'Soon';
return;
}

var end = new Date(date + "T23:59:59").getTime();
var now = new Date().getTime();

var diff = end - now;

if(diff <= 0){
el.innerHTML = 'Expired';
return;
}

var days = Math.floor(diff / (1000*60*60*24));
var hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));

if(days > 0){
el.innerHTML = days + 'd ' + hours + 'h left';
}else{
el.innerHTML = hours + 'h left';
}

});

}

updateCouponTimers();
setInterval(updateCouponTimers,60000);


/* ==================================== */
/* MANUAL DRAG / SWIPE SLIDER */
/* CATEGORY + STORE */
/* ==================================== */

document.querySelectorAll('.marquee-wrap').forEach(function(wrapper){

let isDown = false;
let startX = 0;
let scrollLeft = 0;

/* Desktop Drag */

wrapper.addEventListener('mousedown', function(e){

isDown = true;
wrapper.style.cursor = 'grabbing';

startX = e.pageX - wrapper.offsetLeft;
scrollLeft = wrapper.scrollLeft;

});

wrapper.addEventListener('mouseleave', function(){

isDown = false;
wrapper.style.cursor = 'grab';

});

wrapper.addEventListener('mouseup', function(){

isDown = false;
wrapper.style.cursor = 'grab';

});

wrapper.addEventListener('mousemove', function(e){

if(!isDown) return;

e.preventDefault();

const x = e.pageX - wrapper.offsetLeft;
const walk = (x - startX) * 2.2;

wrapper.scrollLeft = scrollLeft - walk;

});


/* Mobile Swipe */

wrapper.addEventListener('touchstart', function(e){

startX = e.touches[0].pageX - wrapper.offsetLeft;
scrollLeft = wrapper.scrollLeft;

},{passive:true});

wrapper.addEventListener('touchmove', function(e){

const x = e.touches[0].pageX - wrapper.offsetLeft;
const walk = (x - startX) * 2;

wrapper.scrollLeft = scrollLeft - walk;

},{passive:true});


/* Mouse Wheel Horizontal */

wrapper.addEventListener('wheel', function(e){

if(Math.abs(e.deltaY) > 0){

e.preventDefault();
wrapper.scrollLeft += e.deltaY;

}

},{passive:false});


/* Pause Animation while Dragging */

wrapper.addEventListener('mouseenter', function(){

let track = wrapper.querySelector('.marquee-track');
if(track){
track.style.animationPlayState = 'paused';
}

});

wrapper.addEventListener('mouseleave', function(){

let track = wrapper.querySelector('.marquee-track');
if(track){
track.style.animationPlayState = 'running';
}

});

});

</script>
@endsection