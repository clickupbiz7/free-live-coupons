@php
use Illuminate\Support\Str;

$footerLogo = \App\Models\Setting::get('footer_logo');

$footerLogoUrl = $footerLogo
? (Str::startsWith($footerLogo,['http://','https://']) ? $footerLogo : asset($footerLogo))
: null;

$socialLinks = json_decode(\App\Models\Setting::get('social_links'), true);
@endphp

<footer style="background:#081226; color:#fff; padding:60px 0 20px;">

<div class="container">
<div class="row gy-4">

<!-- Col 1 -->
<div class="col-md-3">

@if($footerLogoUrl)
<img src="{{ $footerLogoUrl }}"
style="max-width:170px; max-height:90px; width:auto;">
@endif

<h6 class="mt-3 fw-bold">
{{ \App\Models\Setting::get('site_name') }}
</h6>

<p style="color:#cbd5e1; font-size:14px;">
{{ \App\Models\Setting::get('footer_desc') }}
</p>

</div>

<!-- Col 2 -->
<div class="col-md-3">

<h5 class="mb-3">Quick Links</h5>

<ul class="list-unstyled">
<li><a href="/" class="text-light">Home</a></li>
<li><a href="/stores" class="text-light">Stores</a></li>
<li><a href="/coupons" class="text-light">Coupons</a></li>
<li><a href="/categories" class="text-light">Categories</a></li>
</ul>

</div>

<!-- Col 3 -->
<div class="col-md-3">

<h5 class="mb-3">Legal</h5>

<ul class="list-unstyled">
<li><a href="/privacy-policy" class="text-light">Privacy Policy</a></li>
<li><a href="/terms-condition" class="text-light">Terms</a></li>
<li><a href="/faq" class="text-light">FAQ</a></li>
</ul>

</div>

<!-- Col 4 -->
<div class="col-md-3">

<h5 class="mb-3">Follow Us</h5>

<div class="d-flex flex-wrap">

@if($socialLinks)

@foreach($socialLinks as $social)

<a href="{{ $social['url'] }}"
target="_blank"
class="text-light me-3 mb-2 fs-5">

<i class="{{ $social['icon'] }}"></i>

</a>

@endforeach

@endif

</div>

</div>

</div>

<hr style="border-color:#334155; margin:30px 0 15px;">

<p class="mb-0 text-center" style="color:#cbd5e1;">
© {{ date('Y') }} {{ \App\Models\Setting::get('site_name') }}
</p>

</div>
</footer>