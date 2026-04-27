@extends('frontend.layout')

@section('content')

{{-- ================= SINGLE BLOG TOP AD ================= --}}
@if(isset($singleBlogTopAd) && $singleBlogTopAd)
<div class="container pt-4">
    <div class="ads-box text-center mb-4">
        {!! $singleBlogTopAd->ad_code !!}
    </div>
</div>
@endif

<!-- HERO -->
<section class="single-hero">
<div class="container">

<div class="text-center">

<span class="mini-badge">Blog Article</span>

<h1>{{ $blog->title }}</h1>

<div class="meta-single">
<i class="fa fa-calendar"></i>
{{ $blog->created_at->format('d M Y') }}
&nbsp; • &nbsp;
<i class="fa fa-clock"></i> 5 min read
</div>

</div>

</div>
</section>



<div class="container py-5">

<div class="row g-5">

<!-- MAIN -->
<div class="col-lg-8">

<div class="article-box">

<img src="{{ asset('uploads/blogs/'.$blog->image) }}"
class="single-img"
onerror="this.src='https://via.placeholder.com/900x450'">

<div class="article-content">
{!! $blog->content !!}
</div>

{{-- ================= SINGLE BLOG MIDDLE AD ================= --}}
@if(isset($singleBlogMiddleAd) && $singleBlogMiddleAd)
<div class="ads-box text-center my-4">
    {!! $singleBlogMiddleAd->ad_code !!}
</div>
@endif


<div class="share-box">

<h5>Share Article</h5>

<div class="share-icons">

<a href="https://facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"><i class="fab fa-facebook-f"></i></a>

<a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank"><i class="fab fa-x-twitter"></i></a>

<a href="https://wa.me/?text={{ url()->current() }}" target="_blank"><i class="fab fa-whatsapp"></i></a>

<a href="#"><i class="fab fa-pinterest"></i></a>

</div>

</div>

</div>

</div>


<!-- SIDEBAR -->
<div class="col-lg-4">

<div class="sidebar-box">

<h4>Latest Blogs</h4>

@foreach(\App\Models\Blog::latest()->where('id','!=',$blog->id)->take(4)->get() as $item)

<a href="{{ url('blog/'.$item->slug) }}" class="mini-post">

<img src="{{ asset('uploads/blogs/'.$item->image) }}"
onerror="this.src='https://via.placeholder.com/120x80'">

<div>
<h6>{{ \Illuminate\Support\Str::limit($item->title,45) }}</h6>
<small>{{ $item->created_at->format('d M Y') }}</small>
</div>

</a>

@endforeach

</div>

@if($blogSidebarAd)
<div class="sidebar-box mt-4">
{!! $blogSidebarAd->ad_code !!}
</div>
@endif

</div>

</div>



<!-- RELATED -->
<div class="mt-5">

<div class="section-head mb-4">
<h3>Related Articles</h3>
</div>

<div class="row g-4">

@foreach(\App\Models\Blog::where('id','!=',$blog->id)->latest()->take(3)->get() as $item)

<div class="col-md-4">

<div class="blog-card-pro">

<div class="blog-img-box">
<img src="{{ asset('uploads/blogs/'.$item->image) }}">
</div>

<div class="blog-content">

<h5>{{ \Illuminate\Support\Str::limit($item->title,45) }}</h5>

<a href="{{ url('blog/'.$item->slug) }}"
class="btn-main w-100 text-center">
Read More
</a>

</div>

</div>

</div>

@endforeach

</div>

</div>

</div>



<style>

/* ADS ONLY */
.ads-box{
background:#fff;
padding:18px;
border-radius:18px;
box-shadow:0 12px 28px rgba(0,0,0,.06);
overflow:hidden;
}

.ads-box iframe,
.ads-box img,
.ads-box ins{
max-width:100% !important;
display:block;
margin:auto;
}

/* HERO */
.single-hero{
padding:90px 0;
background:
radial-gradient(circle at left,#ffffff22,transparent 30%),
linear-gradient(135deg,#4f46e5,#7c3aed,#d946ef);
color:#fff;
}

.single-hero h1{
font-size:36px;
font-weight:600;
max-width:900px;
margin:auto;
line-height:1.25;
}

.meta-single{
margin-top:18px;
opacity:.9;
}

/* BOX */
.article-box,
.sidebar-box{
background:#fff;
border-radius:18px;
box-shadow:0 18px 35px rgba(0,0,0,.06);
padding:22px;
}

.single-img{
width:100%;
height:420px;
object-fit:cover;
border-radius:16px;
margin-bottom:25px;
}

/* CONTENT */
.article-content{
font-size:17px;
line-height:2;
color:#374151;
}

.article-content h1,
.article-content h2,
.article-content h3{
font-weight:900;
margin-top:28px;
margin-bottom:14px;
}

.article-content p{
margin-bottom:18px;
}

.article-content img{
max-width:100%;
height:auto;
display:block;
margin:18px auto;
border-radius:14px;
}

.article-content figure{
margin:20px 0;
}

.article-content table{
width:100%;
border-collapse:collapse;
margin:20px 0;
}

.article-content table td,
.article-content table th{
border:1px solid #e5e7eb;
padding:10px;
}

/* SHARE */
.share-box{
margin-top:35px;
padding-top:20px;
border-top:1px solid #eee;
}

.share-icons{
display:flex;
gap:10px;
margin-top:12px;
}

.share-icons a{
width:42px;
height:42px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
background:#f3f4f6;
color:#111;
text-decoration:none;
}

/* SIDEBAR */
.sidebar-box h4{
font-size:26px;
font-weight:600;
margin-bottom:20px;
}

.mini-post{
display:flex;
gap:12px;
text-decoration:none;
margin-bottom:18px;
color:#111;
}

.mini-post img{
width:100px;
height:80px;
object-fit:cover;
border-radius:10px;
}

.mini-post h6{
font-size:15px;
font-weight:600;
margin-bottom:6px;
}

/* COMMON */
.blog-card-pro{
background:#fff;
border-radius:18px;
overflow:hidden;
box-shadow:0 12px 28px rgba(0,0,0,.06);
height:100%;
}

.blog-img-box{
height:220px;
}

.blog-img-box img{
width:100%;
height:100%;
object-fit:cover;
}

.blog-content{
padding:18px;
}

.blog-content h5{
font-size:20px;
font-weight:600;
margin-bottom:15px;
}

.btn-main{
display:inline-block;
padding:12px 20px;
border-radius:12px;
font-weight:600;
text-decoration:none;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
}

.btn-main:hover{
color:#fff;
}

/* MOBILE */
@media(max-width:768px){

.single-hero h1{
font-size:34px;
}

.single-img{
height:240px;
}

.article-content{
font-size:15px;
}

.ads-box{
padding:12px;
border-radius:14px;
}

}

</style>

@endsection