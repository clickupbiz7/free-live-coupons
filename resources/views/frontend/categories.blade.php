{{-- FILE: resources/views/frontend/categories.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="inner-hero">
<div class="container text-center">

<h1>All Categories</h1>
<p>Find deals by category & explore top offers</p>

</div>
</section>


<div class="container py-4">

<!-- FILTER -->
@include('frontend.partials.filter')

<!-- ALPHABET -->
@include('frontend.partials.alphabet')


<!-- GRID -->
<div class="row g-4 mt-1">

@forelse($categories as $cat)

<div class="col-lg-3 col-md-6">

<a href="{{ url('category/'.$cat->slug) }}"
class="text-decoration-none">

<div class="category-card">

<!-- ICON / IMAGE -->
<div class="icon-box">

@if($cat->icon)

<i class="{{ $cat->icon }}"></i>

@elseif($cat->image)

<img src="{{ asset('uploads/categories/'.$cat->image) }}"
class="category-img"
onerror="this.src='https://via.placeholder.com/70'">

@else

<i class="fa-solid fa-tag"></i>

@endif

</div>


<div class="category-body">

<h6>{{ $cat->name }}</h6>

<small>
{{ \App\Models\Coupon::where('category_id',$cat->id)->count() }}
Offers Available
</small>

<div class="category-btn">
Explore Deals
</div>

</div>

</div>

</a>

</div>

@empty

<div class="col-12 text-center py-5">
<h4>No Categories Found 😢</h4>
</div>

@endforelse

</div>


<!-- PAGINATION -->
<div class="mt-5">
{{ $categories->appends(request()->query())->links() }}
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

/* ALPHABET */
.alphabet-bar{
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:8px;
margin-top:18px;
}

.alphabet-btn{
padding:8px 14px;
border-radius:30px;
font-size:13px;
text-decoration:none;
color:#111;
background:#fff;
border:1px solid #e5e7eb;
transition:.3s;
font-weight:700;
}

.alphabet-btn:hover{
background:linear-gradient(135deg,#4f46e5,#d946ef);
color:#fff;
transform:translateY(-3px);
border-color:transparent;
}

.alphabet-btn.active{
background:#111827;
color:#fff;
}

.alphabet-btn.reset{
background:#ef4444;
color:#fff;
border:none;
}

/* CATEGORY CARD */
.category-card{
background:#fff;
border-radius:12px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
height:100%;
text-align:center;
}

.category-card:hover{
transform:translateY(-8px);
box-shadow:0 18px 35px rgba(0,0,0,.12);
}

/* ICON TOP */
.icon-box{
height:120px;
display:flex;
align-items:center;
justify-content:center;
background:linear-gradient(135deg,#eef2ff,#f8fafc);
border-bottom:1px solid #f1f5f9;
}

.icon-box i{
font-size:38px;
color:#4f46e5;
}

.category-img{
width:72px;
height:72px;
object-fit:cover;
border-radius:12px;
}

/* BODY */
.category-body{
padding:18px;
}

.category-body h6{
font-size:20px;
font-weight:800;
color:#111827;
margin-bottom:8px;
}

.category-body small{
display:block;
font-size:13px;
font-weight:600;
color:#64748b;
margin-bottom:15px;
}

/* BUTTON */
.category-btn{
padding:12px;
border-radius:8px;
font-weight:800;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
transition:.3s;
}

.category-card:hover .category-btn{
transform:translateY(-2px);
}

/* MOBILE */
@media(max-width:768px){

.inner-hero h1{
font-size:36px;
}

.icon-box{
height:100px;
}

.category-body h6{
font-size:18px;
}

}

</style>

@endsection