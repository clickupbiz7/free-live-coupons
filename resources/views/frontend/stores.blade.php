{{-- FILE: resources/views/frontend/stores.blade.php --}}
@extends('frontend.layout')

@section('content')

<!-- HERO -->
<section class="inner-hero">
<div class="container text-center">
<h1>All Stores</h1>
<p>Explore top brands & active discounts</p>
</div>
</section>


<div class="container py-4">

<!-- FILTER -->
@include('frontend.partials.filter')

<!-- ALPHABET -->
@include('frontend.partials.alphabet')


<!-- STORES GRID -->
<div class="row g-4 mt-1">

@forelse($stores as $store)

<div class="col-lg-3 col-md-6">

<a href="{{ route('store.single',$store->slug) }}"
class="store-card-pro">

<div class="store-img-edge">

<img src="{{ asset('uploads/stores/'.$store->logo) }}"
onerror="this.src='https://via.placeholder.com/400x250'">

<span class="store-badge">Verified</span>

</div>

<div class="store-bottom">

<h6>{{ $store->name }}</h6>

<small>
{{ \App\Models\Coupon::where('store_id',$store->id)->count() }}
Coupons Available
</small>

<div class="store-btn">
View Deals
</div>

</div>

</a>

</div>

@empty

<div class="col-12 text-center py-5">
<h4>No Stores Found 😢</h4>
</div>

@endforelse

</div>


<!-- PAGINATION -->
<div class="mt-5">
{{ $stores->appends(request()->query())->links() }}
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

/* STORE CARD */
.store-card-pro{
background:#fff;
border-radius:12px;
overflow:hidden;
display:block;
text-decoration:none;
color:#111;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
height:100%;
}

.store-card-pro:hover{
transform:translateY(-8px);
box-shadow:0 20px 35px rgba(0,0,0,.12);
color:#111;
}

/* IMAGE FULL TOUCH */
.store-img-edge{
height:210px;
width:100%;
position:relative;
overflow:hidden;
}

.store-img-edge img{
width:100%;
height:100%;
object-fit:cover;
display:block;
transition:.4s;
}

.store-card-pro:hover .store-img-edge img{
transform:scale(1.05);
}

/* BADGE */
.store-badge{
position:absolute;
top:12px;
left:12px;
padding:6px 12px;
font-size:11px;
font-weight:700;
color:#fff;
background:#16a34a;
border-radius:30px;
}

/* CONTENT */
.store-bottom{
padding:16px;
text-align:center;
}

.store-bottom h6{
font-size:20px;
font-weight:800;
margin-bottom:6px;
}

.store-bottom small{
display:block;
font-size:13px;
color:#64748b;
margin-bottom:14px;
font-weight:600;
}

/* BUTTON */
.store-btn{
padding:12px;
border-radius:8px;
font-weight:800;
color:#fff;
background:linear-gradient(135deg,#4f46e5,#d946ef);
transition:.3s;
}

.store-card-pro:hover .store-btn{
transform:translateY(-2px);
}

/* MOBILE */
@media(max-width:768px){

.inner-hero h1{
font-size:36px;
}

.store-img-edge{
height:180px;
}

.store-bottom h6{
font-size:18px;
}

}

</style>

@endsection