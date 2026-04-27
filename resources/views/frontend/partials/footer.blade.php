@php
use Illuminate\Support\Str;

$footerLogo = \App\Models\Setting::get('footer_logo');

$footerLogoUrl = $footerLogo
? (Str::startsWith($footerLogo,['http://','https://']) ? $footerLogo : asset($footerLogo))
: null;

$socialLinks = json_decode(\App\Models\Setting::get('social_links'), true);

$youtube = \App\Models\Setting::get('youtube_link');
$channel = \App\Models\Setting::get('youtube_channel_name') ?: 'Our YouTube Channel';
@endphp

<footer style="background:#081226;color:#fff;padding:65px 0 20px;">

<div class="container">
<div class="row gy-5">

<!-- COL 1 -->
<div class="col-md-3">

@if($footerLogoUrl)
<img src="{{ $footerLogoUrl }}" style="max-width:170px;">
@endif

<h5 class="fw-bold mt-3">
{{ \App\Models\Setting::get('site_name') }}
</h5>

<p style="color:#cbd5e1;font-size:14px;">
{{ \App\Models\Setting::get('footer_desc') }}
</p>

</div>


<!-- COL 2 -->
<div class="col-md-2">

<h5 class="mb-3">Quick Links</h5>

<ul class="list-unstyled lh-lg">
<li><a href="/" class="text-light text-decoration-none">Home</a></li>
<li><a href="/stores" class="text-light text-decoration-none">Stores</a></li>
<li><a href="/coupons" class="text-light text-decoration-none">Coupons</a></li>
<li><a href="/blogs" class="text-light text-decoration-none">Blogs</a></li>
</ul>

</div>


<!-- COL 3 -->
<div class="col-md-2">

<h5 class="mb-3">Legal</h5>

<ul class="list-unstyled lh-lg">
<li><a href="/about" class="text-light text-decoration-none">About</a></li>
<li><a href="/contact" class="text-light text-decoration-none">Contact</a></li>
<li><a href="/faq" class="text-light text-decoration-none">FAQ</a></li>
<li><a href="/privacy-policy" class="text-light text-decoration-none">Privacy</a></li>
</ul>

</div>


<!-- COL 4 YOUTUBE -->
<div class="col-md-5">

<h5 class="mb-3">Join Our Channel</h5>

<div style="
background:#0f172a;
border:1px solid rgba(255,255,255,.08);
border-radius:18px;
padding:20px;
">

<div class="d-flex align-items-center gap-3 mb-3">

<div style="
width:58px;
height:58px;
border-radius:14px;
background:#ff0000;
display:flex;
align-items:center;
justify-content:center;
font-size:24px;
">
<i class="fab fa-youtube text-white"></i>
</div>

<div>
<div class="fw-bold">{{ $channel }}</div>
<small style="color:#94a3b8;">
Latest videos, deals & updates
</small>
</div>

</div>

<a href="{{ $youtube ?: '#' }}"
target="_blank"
style="
display:block;
text-align:center;
padding:14px;
border-radius:12px;
background:linear-gradient(90deg,#4f46e5,#ec4899);
color:#fff;
text-decoration:none;
font-weight:700;
">
<i class="fab fa-youtube me-2"></i>
Subscribe Now
</a>

</div>

</div>

</div>

<hr style="border-color:#1e293b;margin:35px 0 18px;">

<div class="d-flex justify-content-between flex-wrap gap-3 align-items-center">

<p class="mb-0" style="color:#cbd5e1;">
© {{ date('Y') }} {{ \App\Models\Setting::get('site_name') }}. All Rights Reserved.
</p>

<div class="d-flex gap-2">

@if($socialLinks)
@foreach($socialLinks as $social)

<a href="{{ $social['url'] }}"
target="_blank"
style="
width:42px;
height:42px;
border-radius:50%;
background:#13203a;
display:flex;
align-items:center;
justify-content:center;
color:#fff;
text-decoration:none;
">

<i class="{{ $social['icon'] }}"></i>

</a>

@endforeach
@endif

</div>

</div>

</div>
</footer>