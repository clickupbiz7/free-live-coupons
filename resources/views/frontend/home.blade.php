{{-- resources/views/frontend/home.blade.php --}}
@extends('frontend.layout')

@section('content')

<section class="hero-pro">
<div class="container text-center">

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
</section>



<div class="container py-5">

{{-- ================= LATEST COUPONS ================= --}}
<div class="section-head">
<h2>Latest Coupons</h2>
<a href="{{ route('coupons.all') }}">View All</a>
</div>

<div class="row g-4">

@foreach($coupons->take(8) as $c)

<div class="col-lg-3 col-md-6">

<div class="coupon-pro-card">

<div class="coupon-img-wrap">
<img loading="lazy"
src="{{ asset('uploads/coupons/'.$c->image) }}"
onerror="this.src='https://via.placeholder.com/400x250'">

<span class="verified-tag">Verified</span>
<span class="limited-tag">Limited</span>
</div>

<div class="coupon-content">

<div class="meta-line">
<span>{{ $c->category->name ?? 'Category' }}</span>
<span>{{ $c->store->name ?? 'Store' }}</span>
</div>

<h5>{{ \Illuminate\Support\Str::limit($c->title,36) }}</h5>

<p class="coupon-desc">
{{ \Illuminate\Support\Str::limit($c->description,55) }}
</p>

@php
$discount = explode(' ', trim($c->discount));
$left = $discount[0] ?? '20';
$right = $discount[1] ?? 'OFF';
@endphp

<div class="split-discount">
<div class="left">{{ $left }}</div>
<div class="right">{{ $right }}</div>
</div>

<div class="expiry-wrap">
<span>
Expiry:
{{ $c->expiry_date ? date('d M',strtotime($c->expiry_date)) : 'Soon' }}
</span>

<span class="live-timer" data-date="{{ $c->expiry_date }}">
Loading...
</span>
</div>

<button class="reveal-btn"
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
{{ $c->code ? $c->code : 'Open Now' }}
</span>

</button>

</div>
</div>
</div>



{{-- ================= MODAL ================= --}}
<div class="modal fade" id="couponModal{{ $c->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content premium-modal">

<div class="modal-body text-center p-4">

<img src="{{ asset('uploads/coupons/'.$c->image) }}"
class="modal-coupon-img">

<h4 class="mt-3 fw-bold">{{ $c->title }}</h4>

<div class="split-discount mt-3 mb-3">
<div class="left">{{ $left }}</div>
<div class="right">{{ $right }}</div>
</div>

@if($c->code)

<div class="code-box">
{{ $c->code }}
</div>

<button onclick="copyAndOpen('{{ $c->code }}','{{ $c->affiliate_link }}')"
class="copy-btn mt-3">
Copy Code & Open Store
</button>

@else

<a href="{{ $c->affiliate_link }}"
target="_blank"
rel="nofollow sponsored noopener noreferrer"
class="copy-btn mt-3 text-decoration-none">
Open Deal
</a>

@endif


<div class="share-row">

<a target="_blank" href="https://facebook.com/sharer/sharer.php?u={{ url()->current() }}">
<i class="fab fa-facebook-f"></i>
</a>

<a target="_blank" href="https://twitter.com/intent/tweet?url={{ url()->current() }}">
<i class="fab fa-x-twitter"></i>
</a>

<a target="_blank" href="https://instagram.com">
<i class="fab fa-instagram"></i>
</a>

<a target="_blank" href="https://pinterest.com/pin/create/button/?url={{ url()->current() }}">
<i class="fab fa-pinterest"></i>
</a>

<a target="_blank" href="https://wa.me/?text={{ url()->current() }}">
<i class="fab fa-whatsapp"></i>
</a>

<a target="_blank" href="https://tiktok.com">
<i class="fab fa-tiktok"></i>
</a>

<a target="_blank" href="https://youtube.com">
<i class="fab fa-youtube"></i>
</a>

</div>

<a href="{{ route('terms') }}" class="terms-link">
Terms & Conditions
</a>

</div>
</div>
</div>
</div>

@endforeach

</div>



{{-- ================= CATEGORY SLIDER ================= --}}
<div class="section-head mt-5">
<h2>Top Categories</h2>
<a href="{{ route('categories.all') }}">View All</a>
</div>

<div class="marquee-wrap">
<div class="marquee-track">

@foreach($categories as $cat)
<a href="{{ url('category/'.$cat->slug) }}" class="slider-card">

<div class="card-icon-big">
@if($cat->image)
<img loading="lazy" src="{{ asset('uploads/categories/'.$cat->image) }}">
@else
<i class="fa fa-tag"></i>
@endif
</div>

<h6>{{ $cat->name }}</h6>

<small>
{{ \App\Models\Coupon::where('category_id',$cat->id)->count() }} Offers
</small>

</a>
@endforeach

@foreach($categories as $cat)
<a href="{{ url('category/'.$cat->slug) }}" class="slider-card">

<div class="card-icon-big">
@if($cat->image)
<img loading="lazy" src="{{ asset('uploads/categories/'.$cat->image) }}">
@else
<i class="fa fa-tag"></i>
@endif
</div>

<h6>{{ $cat->name }}</h6>

<small>
{{ \App\Models\Coupon::where('category_id',$cat->id)->count() }} Offers
</small>

</a>
@endforeach

</div>
</div>



{{-- ================= STORE SLIDER ================= --}}
<div class="section-head mt-5">
<h2>Top Stores</h2>
<a href="{{ route('stores.all') }}">View All</a>
</div>

<div class="marquee-wrap">
<div class="marquee-track reverse-track">

@foreach($stores as $store)
<a href="{{ route('store.single',$store->slug) }}" class="store-card-pro">

<div class="store-img-edge">
<img loading="lazy"
src="{{ asset('uploads/stores/'.$store->logo) }}">
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
<img loading="lazy"
src="{{ asset('uploads/stores/'.$store->logo) }}">
</div>

<div class="store-bottom">
<h6>{{ $store->name }}</h6>
<small>View Deals</small>
</div>

</a>
@endforeach

</div>
</div>



{{-- ================= BLOGS ================= --}}
<div class="section-head mt-5">
<h2>Latest Blogs</h2>
<a href="{{ route('blogs.all') }}">View All</a>
</div>

<div class="row g-4">

@foreach($blogs as $blog)
<div class="col-lg-3 col-md-6">

<div class="blog-pro">

<img loading="lazy"
src="{{ asset('uploads/blogs/'.$blog->image) }}">

<div class="p-3">
<h6>{{ \Illuminate\Support\Str::limit($blog->title,42) }}</h6>

<p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),70) }}</p>

<a href="{{ route('blog.single',$blog->slug) }}"
class="read-btn">Read More</a>

</div>
</div>
</div>
@endforeach

</div>

</div>



<style>

/* HERO */
.hero-pro{
padding:110px 0;
background:
radial-gradient(circle at top right,#7c3aed33,transparent 35%),
radial-gradient(circle at left,#2563eb22,transparent 30%),
linear-gradient(135deg,#0f172a,#111827,#1e293b);
color:#fff;
}

.hero-pro h1{
font-size:60px;
font-weight:900;
margin-bottom:15px;
}

.hero-pro p{
font-size:20px;
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
border:none;
border-radius:10px;
font-weight:800;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
}

.hero-btns{
display:flex;
flex-wrap:wrap;
gap:12px;
justify-content:center;
margin-top:30px;
}

.hero-btns a{
padding:11px 18px;
border-radius:40px;
text-decoration:none;
font-weight:700;
color:#fff;
background:rgba(255,255,255,.08);
border:1px solid rgba(255,255,255,.12);
transition:.3s;
}

.hero-btns a:hover{
transform:translateY(-4px);
background:#fff;
color:#111;
}

/* HEAD */
.section-head{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:22px;
}

.section-head h2{
font-size:30px;
font-weight:800;
}

/* COUPON */
.coupon-pro-card{
background:#fff;
border-radius:12px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.06);
transition:.3s;
height:100%;
border:1px solid #ececec;
}

.coupon-pro-card:hover{
transform:translateY(-8px);
}

.coupon-img-wrap{
height:160px;
position:relative;
overflow:hidden;
}

.coupon-img-wrap img{
width:100%;
height:100%;
object-fit:cover;
}

.verified-tag,.limited-tag{
position:absolute;
top:10px;
padding:5px 10px;
font-size:11px;
font-weight:700;
color:#fff;
border-radius:20px;
}

.verified-tag{left:10px;background:#16a34a;}
.limited-tag{right:10px;background:#dc2626;}

.coupon-content{padding:14px;}

.meta-line{
display:flex;
justify-content:space-between;
font-size:11px;
font-weight:700;
color:#64748b;
margin-bottom:8px;
}

.coupon-content h5{
font-size:16px;
font-weight:800;
min-height:42px;
margin-bottom:6px;
}

.coupon-desc{
font-size:13px;
color:#6b7280;
min-height:34px;
margin-bottom:10px;
}

.split-discount{
display:grid;
grid-template-columns:1fr 1fr;
overflow:hidden;
border-radius:10px;
margin-bottom:10px;
}

.split-discount .left{
background:#dc2626;
color:#fff;
padding:10px;
text-align:center;
font-size:22px;
font-weight:900;
}

.split-discount .right{
background:#111827;
color:#fff;
padding:10px;
display:flex;
justify-content:center;
align-items:center;
font-size:14px;
font-weight:700;
}

.expiry-wrap{
display:flex;
justify-content:space-between;
font-size:12px;
font-weight:600;
margin-bottom:12px;
color:#6b7280;
}

.live-timer{
color:#dc2626;
font-weight:800;
}

/* FULL SLIDE BUTTON */
.reveal-btn{
width:100%;
height:46px;
border:none;
border-radius:10px;
position:relative;
overflow:hidden;
font-weight:800;
cursor:pointer;
background:#111827;
}

.btn-front,
.btn-back{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
display:flex;
justify-content:center;
align-items:center;
transition:.45s ease;
}

.btn-front{
background:linear-gradient(135deg,#4f46e5,#d946ef);
color:#fff;
z-index:2;
}

.btn-back{
background:#111827;
color:#fff;
z-index:1;
}

.reveal-btn:hover .btn-front{
transform:translateX(100%);
}

/* SLIDERS */
.marquee-wrap{
overflow:hidden;
position:relative;
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

.slider-card{
min-width:240px;
background:#fff;
border-radius:14px;
padding:18px;
text-decoration:none;
color:#111;
box-shadow:0 10px 25px rgba(0,0,0,.06);
text-align:center;
flex-shrink:0;
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

/* STORE */
.store-card-pro{
min-width:240px;
background:#fff;
border-radius:14px;
padding:0;
overflow:hidden;
text-decoration:none;
color:#111;
box-shadow:0 10px 25px rgba(0,0,0,.06);
text-align:center;
flex-shrink:0;
}

.store-img-edge{
height:170px;
width:100%;
overflow:hidden;
margin:0;
border-radius:14px 14px 0 0;
}

.store-img-edge img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.store-bottom{
padding:14px;
}

/* BLOG */
.blog-pro{
background:#fff;
border-radius:12px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.07);
height:100%;
}

.blog-pro img{
width:100%;
height:200px;
object-fit:cover;
}

.read-btn,.copy-btn{
display:block;
width:100%;
padding:12px;
border:none;
border-radius:8px;
text-align:center;
font-weight:700;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
text-decoration:none;
}

.modal-coupon-img{
height:120px;
object-fit:contain;
}

.code-box{
padding:12px;
font-size:24px;
font-weight:800;
border:2px dashed #111;
border-radius:10px;
letter-spacing:2px;
}

.share-row{
display:flex;
flex-wrap:wrap;
gap:10px;
justify-content:center;
margin-top:18px;
}

.share-row a{
width:42px;
height:42px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
background:#f1f5f9;
color:#111;
text-decoration:none;
}

.terms-link{
display:inline-block;
margin-top:18px;
font-size:14px;
font-weight:700;
text-decoration:none;
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
.hero-pro h1{font-size:38px;}
.hero-search input{width:100%;}
.hero-btns a{font-size:13px;padding:10px 14px;}
.slider-card,.store-card-pro{min-width:180px;}
}

</style>



<script>

function copyAndOpen(code,link){

if(navigator.clipboard){
navigator.clipboard.writeText(code);
}else{
let temp=document.createElement("input");
temp.value=code;
document.body.appendChild(temp);
temp.select();
document.execCommand("copy");
temp.remove();
}

if(link && link!=''){
window.open(link,'_blank');
}

}

/* TIMER */
function updateCouponTimers(){

document.querySelectorAll('.live-timer').forEach(function(el){

let date=el.getAttribute('data-date');

if(!date){
el.innerHTML='Soon';
return;
}

let end=new Date(date+' 23:59:59').getTime();
let now=new Date().getTime();
let diff=end-now;

if(diff<=0){
el.innerHTML='Expired';
return;
}

let d=Math.floor(diff/(1000*60*60*24));
let h=Math.floor((diff%(1000*60*60*24))/(1000*60*60));

el.innerHTML=d+'d '+h+'h left';

});

}

updateCouponTimers();
setInterval(updateCouponTimers,60000);


/* DRAG SLIDER */
document.querySelectorAll('.marquee-wrap').forEach(function(slider){

let isDown=false,startX,scrollLeft;

slider.addEventListener('mousedown',e=>{
isDown=true;
startX=e.pageX-slider.offsetLeft;
scrollLeft=slider.scrollLeft;
slider.style.cursor='grabbing';
});

slider.addEventListener('mouseleave',()=>isDown=false);
slider.addEventListener('mouseup',()=>isDown=false);

slider.addEventListener('mousemove',e=>{
if(!isDown) return;
e.preventDefault();

const x=e.pageX-slider.offsetLeft;
const walk=(x-startX)*2;
slider.scrollLeft=scrollLeft-walk;
});

});

</script>

@endsection