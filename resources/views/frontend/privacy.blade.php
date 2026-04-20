{{-- FILE: resources/views/frontend/privacy.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="policy-hero">
<div class="container text-center">

<h1>Privacy Policy</h1>
<p>Your privacy matters to us</p>

</div>
</section>


<div class="container py-5">

<div class="policy-box">

@if(!empty($content))

{!! nl2br(e($content)) !!}

@else

<h2>Privacy Policy</h2>

<p>
We value your privacy and are committed to protecting your personal information.
</p>

<p>
Information collected may include name, email address, browser data and usage analytics to improve our services.
</p>

<p>
We do not sell personal data to third parties.
</p>

<p>
By using this website, you agree to this privacy policy.
</p>

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

/* HEADINGS */
.policy-box h1,
.policy-box h2,
.policy-box h3,
.policy-box h4,
.policy-box h5{
font-weight:900;
color:#111827;
margin-top:28px;
margin-bottom:15px;
line-height:1.3;
}

.policy-box h1{font-size:40px;}
.policy-box h2{font-size:32px;}
.policy-box h3{font-size:26px;}
.policy-box h4{font-size:22px;}
.policy-box h5{font-size:18px;}

/* TEXT */
.policy-box p{
margin-bottom:18px;
color:#4b5563;
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

/* BLOCKQUOTE */
.policy-box blockquote{
padding:18px;
border-left:4px solid #4f46e5;
background:#f8fafc;
border-radius:10px;
margin:20px 0;
}

/* IMAGE */
.policy-box img{
max-width:100%;
height:auto;
border-radius:12px;
margin:15px 0;
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

}

</style>

@endsection