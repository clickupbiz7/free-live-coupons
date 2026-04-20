{{-- FILE: resources/views/frontend/faq.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="policy-hero">
<div class="container text-center">

<h1>FAQs</h1>
<p>Frequently Asked Questions</p>

</div>
</section>


<div class="container py-5">

<div class="policy-box">

@if(!empty($content))

{!! nl2br(e($content)) !!}

@else

<div class="faq-item">
<h3>How do coupon codes work?</h3>
<p>
Coupon codes are entered during checkout to receive discounts or special offers.
</p>
</div>

<div class="faq-item">
<h3>Are all coupons verified?</h3>
<p>
We regularly update and verify deals, but store offers may change anytime.
</p>
</div>

<div class="faq-item">
<h3>Do I need an account?</h3>
<p>
No, you can browse and use deals without creating an account.
</p>
</div>

<div class="faq-item">
<h3>How often are deals updated?</h3>
<p>
New offers and expired deals are updated frequently.
</p>
</div>

@endif

</div>

</div>



<style>

/* HERO */
.policy-hero{
padding:85px 0;
background:
radial-gradient(circle at top right,#7c3aed33,transparent 35%),
linear-gradient(135deg,#0f172a,#111827,#1e293b);
color:#fff;
}

.policy-hero h1{
font-size:56px;
font-weight:900;
margin-bottom:12px;
}

.policy-hero p{
font-size:18px;
opacity:.92;
}

/* BOX */
.policy-box{
background:#fff;
padding:45px;
border-radius:18px;
box-shadow:0 18px 40px rgba(0,0,0,.08);
line-height:1.9;
font-size:16px;
color:#374151;
word-break:break-word;
}

/* CONTENT */
.policy-box h1,
.policy-box h2,
.policy-box h3,
.policy-box h4,
.policy-box h5{
font-weight:900;
color:#111827;
margin-top:25px;
margin-bottom:12px;
line-height:1.3;
}

.policy-box h1{font-size:40px;}
.policy-box h2{font-size:32px;}
.policy-box h3{font-size:26px;}
.policy-box h4{font-size:22px;}
.policy-box h5{font-size:18px;}

.policy-box p{
margin-bottom:18px;
color:#4b5563;
}

/* FAQ BOX */
.faq-item{
padding:22px;
border:1px solid #e5e7eb;
border-radius:14px;
margin-bottom:18px;
transition:.3s;
background:#fff;
}

.faq-item:hover{
transform:translateY(-4px);
box-shadow:0 12px 25px rgba(0,0,0,.06);
border-color:#d8b4fe;
}

.faq-item h3{
font-size:22px;
margin:0 0 10px;
}

/* LIST */
.policy-box ul,
.policy-box ol{
padding-left:24px;
margin-bottom:18px;
}

.policy-box li{
margin-bottom:10px;
}

/* LINKS */
.policy-box a{
color:#4f46e5;
font-weight:700;
text-decoration:none;
}

.policy-box a:hover{
text-decoration:underline;
}

/* TABLE */
.policy-box table{
width:100%;
border-collapse:collapse;
margin:20px 0;
}

.policy-box table th,
.policy-box table td{
padding:14px;
border:1px solid #e5e7eb;
}

.policy-box table th{
background:#f8fafc;
font-weight:800;
}

/* MOBILE */
@media(max-width:768px){

.policy-hero{
padding:70px 0;
}

.policy-hero h1{
font-size:38px;
}

.policy-box{
padding:24px;
font-size:15px;
}

.policy-box h1{font-size:30px;}
.policy-box h2{font-size:26px;}
.policy-box h3{font-size:22px;}

.faq-item{
padding:18px;
}

.faq-item h3{
font-size:18px;
}

}

</style>

@endsection