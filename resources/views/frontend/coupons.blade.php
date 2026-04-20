{{-- resources/views/frontend/coupons.blade.php --}}
@extends('frontend.layout')

@section('content')

<section class="inner-hero">
<div class="container text-center">
<h1>All Coupons</h1>
<p>Browse latest deals & premium promo codes</p>
</div>
</section>

<div class="container py-4">

@include('frontend.partials.filter')
@include('frontend.partials.alphabet')

<div class="row g-4 mt-1">

@forelse($coupons as $c)

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



{{-- MODAL --}}
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
<a target="_blank" href="https://facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fab fa-facebook-f"></i></a>
<a target="_blank" href="https://twitter.com/intent/tweet?url={{ url()->current() }}"><i class="fab fa-x-twitter"></i></a>
<a target="_blank" href="https://instagram.com"><i class="fab fa-instagram"></i></a>
<a target="_blank" href="https://pinterest.com/pin/create/button/?url={{ url()->current() }}"><i class="fab fa-pinterest"></i></a>
<a target="_blank" href="https://wa.me/?text={{ url()->current() }}"><i class="fab fa-whatsapp"></i></a>
<a target="_blank" href="https://youtube.com"><i class="fab fa-youtube"></i></a>
</div>

<a href="{{ route('terms') }}" class="terms-link">
Terms & Conditions
</a>

</div>
</div>
</div>
</div>

@empty

<div class="col-12 text-center py-5">
<h4>No Coupons Found 😢</h4>
</div>

@endforelse

</div>

<div class="mt-5">
{{ $coupons->appends(request()->query())->links() }}
</div>

</div>



<style>

/* HERO */
.inner-hero{
padding:75px 0;
background:
radial-gradient(circle at top right,#7c3aed33,transparent 35%),
linear-gradient(135deg,#0f172a,#111827,#1e293b);
color:#fff;
}

.inner-hero h1{
font-size:52px;
font-weight:900;
margin-bottom:10px;
}

.inner-hero p{
font-size:18px;
opacity:.92;
}

/* FILTER */
.filter-bar .form-control{
border-radius:10px;
padding:12px;
}

/* ALPHABET FIX */
.alphabet-bar{
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:8px;
margin-top:18px;
margin-bottom:18px;
}

.alphabet-bar a{
padding:8px 14px;
border-radius:30px;
font-size:13px;
text-decoration:none;
color:#111827;
background:#ffffff;
border:1px solid #e5e7eb;
transition:.3s;
font-weight:700;
line-height:1;
display:inline-block;
min-width:38px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,.04);
}

.alphabet-bar a:hover{
background:linear-gradient(135deg,#4f46e5,#d946ef);
color:#fff;
border-color:transparent;
transform:translateY(-3px);
}

.alphabet-bar a.active{
background:#111827;
color:#fff;
border-color:#111827;
}

.alphabet-bar a.reset{
background:#ef4444;
color:#fff;
border:none;
}

/* CARD */
.coupon-pro-card{
background:#fff;
border-radius:12px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
height:100%;
border:1px solid #ececec;
}

.coupon-pro-card:hover{
transform:translateY(-8px);
box-shadow:0 18px 35px rgba(0,0,0,.10);
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

.coupon-content{
padding:14px;
}

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
line-height:1.35;
min-height:42px;
margin-bottom:6px;
}

.coupon-desc{
font-size:13px;
color:#6b7280;
line-height:1.4;
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

.btn-front,.btn-back{
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

.premium-modal{
border-radius:14px;
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

.copy-btn{
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

@media(max-width:768px){
.inner-hero h1{
font-size:36px;
}
}

</style>



<script>

function copyAndOpen(code,link){
navigator.clipboard.writeText(code).catch(()=>{});

if(link && link!=''){
setTimeout(function(){
window.open(link,'_blank');
},300);
}
}

/* TIMER */
function updateCouponTimers(){

document.querySelectorAll('.live-timer').forEach(function(el){

let date = el.getAttribute('data-date');

if(!date){
el.innerHTML='Soon';
return;
}

let end = new Date(date + ' 23:59:59').getTime();
let now = new Date().getTime();

let diff = end - now;

if(diff <= 0){
el.innerHTML='Expired';
return;
}

let d = Math.floor(diff/(1000*60*60*24));
let h = Math.floor((diff%(1000*60*60*24))/(1000*60*60));

el.innerHTML = d+'d '+h+'h left';

});

}

updateCouponTimers();
setInterval(updateCouponTimers,60000);

</script>

@endsection