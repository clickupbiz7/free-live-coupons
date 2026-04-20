{{-- FILE 1: resources/views/frontend/blogs.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="blog-hero">
<div class="container text-center">

<span class="mini-badge">Latest Articles</span>

<h1>Blogs & Saving Tips</h1>

<p>
Learn smart shopping strategies, deals hacks & money saving guides
</p>

<form method="GET" class="search-wrap mt-4">

<div class="search-box">
<input type="text"
name="search"
value="{{ request('search') }}"
placeholder="Search blogs...">

<button type="submit">
<i class="fa fa-search"></i>
</button>
</div>

</form>

<div class="hero-tags mt-4">
<a href="/blogs">Savings Tips</a>
<a href="/coupons">Coupon Guides</a>
<a href="#">Shopping Hacks</a>
<a href="/stores">Top Brands</a>
</div>

</div>
</section>



<div class="container py-5">

<!-- FEATURED -->
@if(count($blogs) > 0)

@php $featured = $blogs->first(); @endphp

<div class="featured-blog mb-5">

<div class="row align-items-center g-4">

<div class="col-lg-6">
<img src="{{ asset('uploads/blogs/'.$featured->image) }}"
class="img-fluid"
onerror="this.src='https://via.placeholder.com/700x400'">
</div>

<div class="col-lg-6">

<span class="featured-tag">Featured Post</span>

<h2>{{ $featured->title }}</h2>

<p>
{{ \Illuminate\Support\Str::limit(strip_tags($featured->content),180) }}
</p>

<div class="meta-line mb-3">
<i class="fa fa-calendar"></i>
{{ $featured->created_at->format('d M Y') }}
</div>

<a href="{{ route('blog.single',$featured->slug) }}"
class="btn-main">
Read Full Article
</a>

</div>

</div>

</div>

@endif


<!-- SECTION TITLE -->
<div class="section-head mb-4">
<h3>Latest Articles</h3>
<p>Fresh blogs updated regularly</p>
</div>


<!-- BLOG GRID -->
<div class="row g-4">

@forelse($blogs as $blog)

<div class="col-lg-4 col-md-6">

<div class="blog-card-pro">

<div class="blog-img-box">
<img src="{{ asset('uploads/blogs/'.$blog->image) }}"
onerror="this.src='https://via.placeholder.com/400x250'">
</div>

<div class="blog-content">

<div class="blog-date">
{{ $blog->created_at->format('d M Y') }}
</div>

<h5>
{{ \Illuminate\Support\Str::limit($blog->title,55) }}
</h5>

<p>
{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),100) }}
</p>

<a href="{{ route('blog.single',$blog->slug) }}"
class="btn-main w-100 text-center">
Read More
</a>

</div>

</div>

</div>

@empty

<div class="text-center py-5">
<h4>No Blogs Found 😢</h4>
</div>

@endforelse

</div>


<!-- NEWSLETTER -->
<div class="newsletter-box-pro mt-5">

<div class="row align-items-center">

<div class="col-lg-7">
<h3>Get Weekly Saving Tips</h3>
<p>Subscribe for latest blogs and premium deals.</p>
</div>

<div class="col-lg-5">
<form class="d-flex gap-2">
<input type="email" class="form-control" placeholder="Your Email">
<button class="btn-main border-0">Subscribe</button>
</form>
</div>

</div>

</div>


<!-- PAGINATION -->
<div class="mt-5">
{{ $blogs->links() }}
</div>

</div>



<style>

/* HERO */
.blog-hero{
padding:90px 0;
background:
radial-gradient(circle at top right,#7c3aed33,transparent 35%),
linear-gradient(135deg,#0f172a,#111827,#1e293b);
color:#fff;
}

.mini-badge{
display:inline-block;
padding:8px 14px;
background:#ffffff18;
border-radius:30px;
font-size:12px;
font-weight:800;
margin-bottom:18px;
}

.blog-hero h1{
font-size:60px;
font-weight:900;
margin-bottom:12px;
}

.blog-hero p{
font-size:18px;
opacity:.9;
max-width:720px;
margin:auto;
}

/* SEARCH */
.search-wrap{
max-width:620px;
margin:auto;
}

.search-box{
background:#fff;
border-radius:60px;
padding:8px;
display:flex;
box-shadow:0 18px 35px rgba(0,0,0,.18);
}

.search-box input{
border:none;
outline:none;
padding:12px 18px;
flex:1;
border-radius:50px;
}

.search-box button{
width:54px;
border:none;
border-radius:50%;
background:linear-gradient(135deg,#4f46e5,#d946ef);
color:#fff;
}

/* TAGS */
.hero-tags{
display:flex;
gap:10px;
justify-content:center;
flex-wrap:wrap;
}

.hero-tags a{
padding:8px 14px;
background:#ffffff14;
color:#fff;
text-decoration:none;
border-radius:30px;
font-size:13px;
}

/* FEATURED */
.featured-blog{
background:#fff;
padding:24px;
border-radius:20px;
box-shadow:0 18px 35px rgba(0,0,0,.07);
}

.featured-blog img{
border-radius:18px;
height:340px;
width:100%;
object-fit:cover;
}

.featured-tag{
font-size:12px;
font-weight:800;
color:#4f46e5;
background:#eef2ff;
padding:6px 12px;
border-radius:30px;
display:inline-block;
margin-bottom:14px;
}

.featured-blog h2{
font-size:38px;
font-weight:900;
margin-bottom:15px;
}

.featured-blog p{
color:#64748b;
line-height:1.8;
}

.meta-line{
font-size:14px;
color:#64748b;
}

/* HEAD */
.section-head h3{
font-size:34px;
font-weight:900;
margin-bottom:6px;
}

.section-head p{
color:#64748b;
}

/* CARD */
.blog-card-pro{
background:#fff;
border-radius:18px;
overflow:hidden;
box-shadow:0 12px 28px rgba(0,0,0,.06);
transition:.3s;
height:100%;
}

.blog-card-pro:hover{
transform:translateY(-8px);
}

.blog-img-box{
height:240px;
overflow:hidden;
}

.blog-img-box img{
width:100%;
height:100%;
object-fit:cover;
}

.blog-content{
padding:20px;
display:flex;
flex-direction:column;
height:calc(100% - 240px);
}

.blog-date{
font-size:13px;
font-weight:700;
color:#6366f1;
margin-bottom:10px;
}

.blog-content h5{
font-size:22px;
font-weight:800;
margin-bottom:12px;
line-height:1.4;
}

.blog-content p{
color:#64748b;
line-height:1.8;
flex:1;
}

/* BTN */
.btn-main{
display:inline-block;
padding:13px 22px;
border-radius:12px;
font-weight:800;
text-decoration:none;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
}

.btn-main:hover{
color:#fff;
}

/* NEWSLETTER */
.newsletter-box-pro{
background:#fff;
padding:35px;
border-radius:20px;
box-shadow:0 18px 35px rgba(0,0,0,.06);
}

.newsletter-box-pro h3{
font-size:32px;
font-weight:900;
margin-bottom:8px;
}

.newsletter-box-pro p{
color:#64748b;
margin:0;
}

/* MOBILE */
@media(max-width:768px){

.blog-hero h1{
font-size:38px;
}

.featured-blog h2{
font-size:28px;
}

.section-head h3{
font-size:28px;
}

.blog-content h5{
font-size:20px;
}

.newsletter-box-pro h3{
font-size:26px;
}

}

</style>

@endsection