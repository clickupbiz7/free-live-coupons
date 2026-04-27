@extends('frontend.layout')

@section('content')

<section class="inner-hero">
<div class="container text-center">

<div class="store-hero-logo">
<img src="{{ asset('uploads/stores/'.$store->logo) }}"
onerror="this.src='https://via.placeholder.com/120'">
</div>

<h1>{{ $store->name }}</h1>
<p>{{ $coupons->count() }} Coupons Available</p>

</div>
</section>

<div class="container py-4">

@include('frontend.partials.filter')
@include('frontend.partials.alphabet')

<div class="row g-4 mt-1">

@forelse($coupons as $c)

<div class="col-lg-3 col-md-6">

<div class="coupon-pro-card premium-coupon-card">

<div class="coupon-img-wrap">

<img loading="lazy"
src="{{ asset('uploads/coupons/'.$c->image) }}"
onerror="this.src='https://via.placeholder.com/400x250'">

<div class="verified-badge-new">
<span class="v-icon">✔</span>
<span class="v-text">VERIFIED</span>
</div>

<div class="limited-ribbon">
<span>
{{ explode(' ', $c->badge ?? 'LIMITED OFFER')[0] ?? 'LIMITED' }}
<small>{{ explode(' ', $c->badge ?? 'LIMITED OFFER')[1] ?? 'OFFER' }}</small>
</span>
</div>

</div>

<div class="coupon-content">

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

<div class="voucher-split-box">
<div class="voucher-left">{{ $left }}</div>
<div class="voucher-right">{{ $right }}</div>
</div>

<div class="expiry-wrap">

<span>
Expiry:
{{ $c->expiry_date ? date('d M',strtotime($c->expiry_date)) : 'Soon' }}
</span>

<span class="live-timer"
data-date="{{ $c->expiry_date }}">
Loading...
</span>

</div>

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

{{-- PREMIUM MODAL --}}
<div class="modal fade" id="couponModal{{ $c->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-md">
<div class="modal-content premium-modal-wrap">

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
data-code="{{ $c->code }}"
data-link="{{ $c->affiliate_link }}">
<span class="btn-front">Copy Code & Open Store</span>
<span class="btn-back">{{ $c->code }}</span>

</button>

@else

<a href="{{ $c->affiliate_link }}"
target="_blank"
rel="nofollow sponsored noopener noreferrer"
class="copy-btn premium-modal-btn mt-3 text-decoration-none">

<span class="btn-front">Open Deal</span>
<span class="btn-back">Go Now</span>

</a>

@endif

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

<a href="{{ route('terms') }}" class="terms-box-btn">
Terms & Conditions
</a>

</div>
</div>
</div>
</div>

@empty

<div class="col-12 text-center py-5">
<h4>No Coupons Found</h4>
</div>

@endforelse

</div>

@if(method_exists($coupons,'links'))
<div class="mt-5">
{{ $coupons->appends(request()->query())->links() }}
</div>
@endif

</div>

<style>

/* HERO */
.inner-hero{
padding:50px 0;
background:
radial-gradient(circle at left,#ffffff22,transparent 30%),
linear-gradient(135deg,#4f46e5,#7c3aed,#d946ef);
color:#fff;
}

.store-hero-logo{
width:110px;
height:110px;
margin:auto;
background:#fff;
border-radius:18px;
display:flex;
align-items:center;
justify-content:center;
padding:12px;
box-shadow:0 10px 25px rgba(0,0,0,.12);
margin-bottom:18px;
}

.store-hero-logo img{
max-width:100%;
max-height:100%;
object-fit:contain;
}

.inner-hero h1{
font-size:36px;
font-weight:700;
margin-bottom:10px;
}

.inner-hero p{
font-size:18px;
opacity:.92;
}

/* ALPHABET */
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
background:#fff;
border:1px solid #e5e7eb;
font-weight:700;
box-shadow:0 4px 10px rgba(0,0,0,.04);
transition:.3s;
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

/* PREMIUM CARD */
.premium-coupon-card{
background:#fff;
border-radius:18px;
overflow:hidden;
box-shadow:0 12px 30px rgba(0,0,0,.08);
border:1px solid #ececec;
transition:.3s;
height:auto;
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
display:block;
}

/* VERIFIED */
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
font-weight:800;
box-shadow:0 4px 10px rgba(0,0,0,.18);
}

.v-text{
height:28px;
padding:0 12px;
background:#111827;
color:#fff;
display:flex;
align-items:center;
font-size:11px;
font-weight:800;
letter-spacing:.8px;
border-radius:20px;
margin-left:6px;
}

/* LIMITED */
.limited-ribbon{
position:absolute;
top:-2px;
right:14px;
background:#ef4444;
color:#fff;
padding:10px 10px 12px;
font-size:11px;
font-weight:600;
border-radius:0 0 8px 8px;
box-shadow:0 8px 18px rgba(0,0,0,.18);
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
gap:2px;
transform:rotate(-360deg);
transform-origin:center;
line-height:1;
margin-top:30px;
text-align:center;
}

.limited-ribbon span small{
font-size:11px;
font-weight:700;
}

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
padding:8px;
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
}

.store-mini{
background:linear-gradient(135deg,#fff,#f5f5f5);
color:#111827;
border:1px solid #e5e7eb;
}

.coupon-content h5{
font-size:16px;
font-weight:600;
line-height:1.35;
margin-bottom:8px;
}

.coupon-desc{
font-size:13px;
color:#6b7280;
line-height:1.5;
margin-bottom:12px;
}

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
padding:10px 10px;
font-size:20px;
font-weight:600;
text-align:center;
}

.voucher-right{
background:#fff7ed;
color:#111827;
padding:10px 10px;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
font-weight:600;
border-left:2px dashed rgba(0,0,0,.15);
}

.expiry-wrap{
display:flex;
justify-content:space-between;
gap:10px;
font-size:11px;
font-weight:600;
color:#6b7280;
margin-bottom:14px;
}

.live-timer{
color:#dc2626;
}

/* BUTTON */
.premium-reveal-btn{
width:100%;
height:54px;
border:none;
border-radius:10px;
position:relative;
overflow:hidden;
cursor:pointer;
background:#111827;
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

.premium-reveal-btn:before{left:-8px;}
.premium-reveal-btn:after{right:-8px;}

.premium-reveal-btn .btn-front,
.premium-reveal-btn .btn-back{
position:absolute;
inset:0;
display:flex;
align-items:center;
justify-content:center;
font-size:16px;
font-weight:600;
transition:.45s ease;
}

.premium-reveal-btn .btn-front{
background:linear-gradient(135deg,#111827,#374151);
color:#fff;
z-index:2;
}

.premium-reveal-btn .btn-back{
background:linear-gradient(135deg,#7c3aed,#d946ef);
color:#fff;
}

.premium-reveal-btn:hover .btn-front{
transform:translateX(100%);
}

/* MODAL */
.premium-modal-wrap{
border:none;
border-radius:22px;
overflow:hidden;
box-shadow:0 25px 60px rgba(0,0,0,.18);
background:#fff;
}

.modal-top-image{
height:180px;
overflow:hidden;
}

.modal-top-image img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.premium-modal-body{
padding:22px;
text-align:center;
}

.modal-title-pro{
font-size:20px;
font-weight:600;
margin-bottom:10px;
color:#111827;
}

.premium-modal-btn{
width:100%;
height:54px;
border:none;
border-radius:10px;
position:relative;
overflow:hidden;
display:block;
padding:0;
text-decoration:none;
background:#111827;
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
font-size:16px;
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

.code-box{
padding:12px;
font-size:20px;
font-weight:600;
border:2px dashed #111827;
border-radius:12px;
letter-spacing:2px;
margin-top:6px;
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
}

.terms-box-btn{
display:block;
width:100%;
padding:8px 16px;
border-radius:10px;
background:#f8fafc;
border:1px solid #eef2f7;
font-size:13px;
font-weight:600;
color:#111827;
text-decoration:none;
}

@media(max-width:768px){

.inner-hero h1{font-size:30px;}
.store-hero-logo{width:90px;height:90px;}

.coupon-img-wrap{height:170px;}
.modal-top-image{height:180px;}
.modal-title-pro{font-size:20px;}

}
</style>



<script>

function copyCouponAndOpen(btn)
{
var code = btn.getAttribute("data-code") || "";
var link = btn.getAttribute("data-link") || "";

/* COPY */
copyNow(code);

/* TOAST */
showCopyToast();

/* REDIRECT AFTER 1.5 SEC */
if(link !== ""){
setTimeout(function(){

var newTab = window.open(link, "_blank");

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
toast.style.fontSize = "14px";
toast.style.zIndex = "999999";
toast.style.boxShadow = "0 10px 25px rgba(0,0,0,.15)";
toast.style.opacity = "0";
toast.style.transition = ".3s";

document.body.appendChild(toast);

setTimeout(function(){
toast.style.opacity = "1";
},100);

setTimeout(function(){
toast.style.opacity = "0";

setTimeout(function(){
toast.remove();
},300);

},1700);
}

</script>

@endsection