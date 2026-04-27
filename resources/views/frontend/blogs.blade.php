@extends('frontend.layout')

@section('content')

{{-- HERO SECTION --}}
<section class="blog-hero">
<div class="container">

<div class="hero-content text-center">

<h1>Blogs & Saving Tips</h1>

<p>
Learn smart shopping strategies, deal hacks & money saving guides.
</p>

<form action="{{ url('/blogs') }}" method="GET" class="hero-search">

<input type="text"
name="search"
placeholder="Search blogs..."
value="{{ request('search') }}">

<button type="submit">
<i class="fa fa-search"></i>
</button>

</form>

<div class="hero-tags">
<a href="{{ url('/blogs') }}">Saving Tips</a>
<a href="{{ url('/blogs') }}">Coupon Guides</a>
<a href="{{ url('/blogs') }}">Shopping Hacks</a>
<a href="{{ url('/blogs') }}">Top Deals</a>
</div>

</div>

</div>
</section>



{{-- BLOG PAGE --}}
<section class="blog-page py-5">
<div class="container">
<div class="row g-4">

{{-- LEFT SIDE --}}
<div class="col-lg-8">

{{-- FEATURED POST --}}
@if(isset($featuredPost) && $featuredPost)

<div class="featured-blog-card mb-4">
<div class="row g-0 align-items-center">

<div class="col-md-6">
<a href="{{ route('blog.detail',$featuredPost->slug) }}">
<img src="{{ asset('uploads/blogs/'.$featuredPost->image) }}"
class="featured-img">
</a>
</div>

<div class="col-md-6">
<div class="p-4">

<span class="badge-featured">
Featured Post
</span>

<h3 class="featured-title">
<a href="{{ route('blog.detail',$featuredPost->slug) }}">
{{ $featuredPost->title }}
</a>
</h3>

<p class="featured-desc">
{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->content),140) }}
</p>

<a href="{{ route('blog.detail',$featuredPost->slug) }}"
class="btn-main">
Read Full Article
</a>

</div>
</div>

</div>
</div>

@endif



{{-- TITLE --}}
<div class="section-heading mb-4">
<h2>Latest Articles</h2>
<p>Fresh blogs updated regularly</p>
</div>



{{-- BLOG LIST --}}
@if(isset($blogs) && count($blogs))

@foreach($blogs as $blog)

<div class="blog-row-card mb-4">
<div class="row g-0 h-100">

<div class="col-md-5">
<a href="{{ route('blog.detail',$blog->slug) }}"
class="d-block h-100">

<img src="{{ asset('uploads/blogs/'.$blog->image) }}"
class="blog-row-img">

</a>
</div>

<div class="col-md-7">

<div class="blog-row-content">

@if(isset($blog->category) && $blog->category)

<span class="blog-cat">
{{ is_object($blog->category) ? $blog->category->name : $blog->category }}
</span>

@endif

<div class="blog-meta">
{{ $blog->created_at->format('d M Y') }}
</div>

<h3>
<a href="{{ route('blog.detail',$blog->slug) }}">
{{ $blog->title }}
</a>
</h3>

<p>
{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),150) }}
</p>

<a href="{{ route('blog.detail',$blog->slug) }}"
class="btn-main">
Read More
</a>

</div>

</div>

</div>
</div>

@endforeach

@endif



@if(method_exists($blogs,'links'))
<div class="mt-4">
{{ $blogs->links() }}
</div>
@endif

</div>



{{-- RIGHT SIDE --}}
<div class="col-lg-4">

<div class="sidebar-box mb-4">

<h4>Latest Posts</h4>

@if(isset($latestPosts))

@foreach($latestPosts as $item)

<a href="{{ route('blog.detail',$item->slug) }}"
class="latest-post-item">

<img src="{{ asset('uploads/blogs/'.$item->image) }}">

<div>
<h6>{{ $item->title }}</h6>
<span>{{ $item->created_at->format('d M Y') }}</span>
</div>

</a>

@endforeach

@endif

</div>



<div class="sidebar-box">

<h4>Categories</h4>

<ul class="category-list">

@if(isset($categories))

@foreach($categories as $cat)

<li>

<a href="{{ url('/blogs?category='.$cat->id) }}">
{{ $cat->name ?? $cat->category }}
</a>

<span>
{{ $cat->blogs_count ?? 0 }}
</span>

</li>

@endforeach

@endif

</ul>

</div>

</div>

</div>
</div>
</section>



<style>

/* HERO */
.blog-hero{
background:linear-gradient(135deg,#5b39ff,#d946ef);
padding:70px 0;
color:#fff;
}

.hero-content{
max-width:760px;
margin:auto;
}

.hero-content h1{
font-size:42px;
font-weight:800;
margin-bottom:12px;
}

.hero-content p{
opacity:.9;
margin-bottom:25px;
}

.hero-search{
display:flex;
max-width:620px;
margin:auto;
background:#fff;
border-radius:10px;
overflow:hidden;
box-shadow:0 12px 30px rgba(0,0,0,.12);
}

.hero-search input{
flex:1;
border:none;
padding:14px 20px;
outline:none;
font-size:15px;
}

.hero-search button{
width:60px;
border:none;
background:#7c3aed;
color:#fff;
}

.hero-tags{
margin-top:22px;
display:flex;
gap:10px;
justify-content:center;
flex-wrap:wrap;
}

.hero-tags a{
padding:8px 16px;
border:1px solid rgba(255,255,255,.35);
border-radius:30px;
color:#fff;
font-size:14px;
text-decoration:none;
}

.hero-tags a:hover{
background:#fff;
color:#7c3aed;
}



/* PAGE */
.blog-page{
background:#f8fafc;
}

.section-heading h2{
font-size:34px;
font-weight:800;
margin-bottom:5px;
}

.section-heading p{
color:#64748b;
margin:0;
}



/* FEATURED */
.featured-blog-card{
background:#fff;
border-radius:10px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.featured-img{
width:100%;
height:320px;
object-fit:cover;
display:block;
}

.badge-featured{
display:inline-block;
padding:8px 14px;
background:#eef2ff;
color:#4f46e5;
font-size:12px;
font-weight:700;
border-radius:30px;
margin-bottom:14px;
}

.featured-title{
font-size:30px;
font-weight:800;
margin-bottom:12px;
}

.featured-title a{
text-decoration:none;
color:#111827;
}

.featured-desc{
color:#64748b;
line-height:1.8;
margin-bottom:18px;
}



/* BLOG ROW */
.blog-row-card{
background:#fff;
border-radius:10px;
overflow:hidden;
box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.blog-row-img{
width:100%;
height:100%;
min-height:250px;
object-fit:cover;
display:block;
}

.blog-row-content{
padding:24px;
height:100%;
display:flex;
flex-direction:column;
justify-content:center;
}

.blog-cat{
display:inline-block;
padding:6px 12px;
border-radius:20px;
background:#eef2ff;
color:#4f46e5;
font-size:12px;
font-weight:700;
margin-bottom:10px;
}

.blog-meta{
font-size:13px;
color:#94a3b8;
margin-bottom:10px;
}

.blog-row-content h3{
font-size:26px;
font-weight:700;
margin-bottom:12px;
}

.blog-row-content h3 a{
text-decoration:none;
color:#111827;
}

.blog-row-content p{
color:#64748b;
line-height:1.8;
margin-bottom:18px;
}



/* BUTTON */
.btn-main{
display:inline-block;
padding:10px 18px;
border-radius:10px;
background:linear-gradient(90deg,#7c3aed,#d946ef);
color:#fff;
font-weight:600;
text-decoration:none;
}

.btn-main:hover{
color:#111;
background:#fff;
box-shadow:0 8px 25px rgba(0,0,0,.05);
opacity:.92;
}



/* SIDEBAR */
.sidebar-box{
background:#fff;
border-radius:10px;
padding:24px;
box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.sidebar-box h4{
font-size:22px;
font-weight:700;
margin-bottom:18px;
}

.latest-post-item{
display:flex;
gap:14px;
margin-bottom:10px;
text-decoration:none;
padding-bottom:14px;
border-bottom:1px solid #f1f5f9;
}

.latest-post-item:last-child{
margin-bottom:0;
padding-bottom:0;
border:none;
}

.latest-post-item img{
width:90px;
height:70px;
border-radius:12px;
object-fit:cover;
}

.latest-post-item h6{
font-size:15px;
font-weight:700;
margin-bottom:5px;
color:#111827;
}

.latest-post-item span{
font-size:12px;
color:#94a3b8;
}



/* CATEGORY */
.category-list{
list-style:none;
padding:0;
margin:0;
}

.category-list li{
display:flex;
justify-content:space-between;
padding:12px 0;
border-bottom:1px solid #f1f5f9;
}

.category-list li:last-child{
border:none;
}

.category-list a{
text-decoration:none;
font-weight:600;
color:#111827;
}

.category-list span{
padding:4px 10px;
border-radius:20px;
background:#eef2ff;
color:#4f46e5;
font-size:12px;
}



/* MOBILE */
@media(max-width:768px){

.hero-content h1{
font-size:30px;
}

.blog-row-img{
min-height:220px;
}

.featured-img{
height:240px;
}

}

</style>

@endsection