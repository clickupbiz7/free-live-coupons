@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
<div>
<h2 class="fw-bold mb-1">Dashboard Overview</h2>
<p class="text-muted mb-0">Monitor your website performance</p>
</div>

<a href="{{ route('admin.coupons.create') }}"
class="btn btn-primary px-4 rounded-1">
<i class="fa fa-plus me-2"></i>Add Coupon
</a>
</div>

<!-------------------------------- TOP STATS ---------------------------------->

<div class="row g-4">

<div class="col-md-3">
<div class="card p-4 rounded h-100">
<small class="text-muted">Categories</small>
<h2 class="fw-bold mb-1">{{ $categories }}</h2>
<span class="text-primary fs-4"><i class="fa fa-folder"></i></span>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 rounded h-100">
<small class="text-muted">Stores</small>
<h2 class="fw-bold mb-1">{{ $stores }}</h2>
<span class="text-success fs-4"><i class="fa fa-store"></i></span>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 rounded h-100">
<small class="text-muted">Coupons</small>
<h2 class="fw-bold mb-1">{{ $coupons }}</h2>
<span class="text-danger fs-4"><i class="fa fa-ticket"></i></span>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 rounded h-100">
<small class="text-muted">Blogs</small>
<h2 class="fw-bold mb-1">{{ $blogs }}</h2>
<span class="text-warning fs-4"><i class="fa fa-blog"></i></span>
</div>
</div>

</div>

<!----------------------------------- CLICK STATS ---------------------------->

<div class="row g-4 mt-1">

<div class="col-md-4">
<div class="card p-4 border-0 shadow-sm rounded h-100">
<small class="text-muted">Total Clicks</small>
<h2 class="fw-bold text-primary mb-0">{{ $totalClicks }}</h2>
</div>
</div>

<div class="col-md-4">
<div class="card p-4 border-0 shadow-sm rounded h-100">
<small class="text-muted">Today Clicks</small>
<h2 class="fw-bold text-success mb-0">{{ $todayClicks }}</h2>
</div>
</div>

<div class="col-md-4">
<div class="card p-4 border-0 shadow-sm rounded h-100">
<small class="text-muted">Last 7 Days</small>
<h2 class="fw-bold text-danger mb-0">{{ $weekClicks }}</h2>
</div>
</div>

</div>

<!---------------------------------- CHARTS ------------------------------->

<div class="row g-4 mt-1">

<div class="col-lg-8">

<div class="card p-4 border-0 shadow-sm rounded mb-4">
<h5 class="fw-bold mb-4">Monthly Coupons</h5>
<canvas id="couponChart" height="110"></canvas>
</div>

<div class="card p-4 border-0 shadow-sm rounded">
<h5 class="fw-bold mb-4">Last 7 Days Clicks</h5>
<canvas id="clickChart" height="110"></canvas>
</div>

</div>

<div class="col-lg-4">

<div class="card p-4 border-0 shadow-sm rounded mb-4">
<small class="text-muted">Active Coupons</small>
<h2 class="fw-bold text-success">{{ $activeCoupons }}</h2>
</div>

<div class="card p-4 border-0 shadow-sm rounded mb-4">
<small class="text-muted">Expired Coupons</small>
<h2 class="fw-bold text-danger">{{ $expiredCoupons }}</h2>
</div>

<div class="card p-4 border-0 shadow-sm rounded">
<h5 class="fw-bold mb-3">Top Coupons</h5>

@forelse($topCoupons as $item)
<div class="d-flex justify-content-between border-bottom py-2">
<span class="small">{{ \Illuminate\Support\Str::limit($item->title,22) }}</span>
<strong>{{ $item->total }}</strong>
</div>
@empty
<div class="text-muted">No data</div>
@endforelse

</div>

</div>

</div>

<!--------------------------------- RECENT CLICKS ----------------------------->

<div class="card mt-4 overflow-hidden rounded">

<div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">

<h5 class="fw-bold mb-0">Recent Coupon Clicks</h5>

<div class="d-flex gap-2">

<form method="GET">
<select name="range"
class="form-select form-select-sm"
onchange="this.form.submit()">

<option value="all" {{ $range=='all'?'selected':'' }}>All Time</option>
<option value="today" {{ $range=='today'?'selected':'' }}>Today</option>
<option value="3days" {{ $range=='3days'?'selected':'' }}>Last 3 Days</option>
<option value="week" {{ $range=='week'?'selected':'' }}>Week</option>
<option value="month" {{ $range=='month'?'selected':'' }}>Month</option>
<option value="year" {{ $range=='year'?'selected':'' }}>Year</option>

</select>
</form>

<!-- UPDATED REFRESH BUTTON -->
<a href="#"
   class="btn btn-dark btn-sm"
   data-bs-toggle="modal"
   data-bs-target="#clearClicksModal"
   title="Clear Click Data">
   <i class="fa fa-rotate-right"></i>
</a>


</div>

</div>

<div class="table-responsive p-1">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">
<tr>
<th>Coupon</th>
<th>IP</th>
<th>Date</th>
<th>Time</th>
</tr>
</thead>

<tbody>

@forelse($recentClicks as $click)

<tr>
<td>{{ $click->title ?? 'Deleted Coupon' }}</td>
<td>{{ $click->ip ?? '-' }}</td>
<td>{{ date('d M Y', strtotime($click->created_at)) }}</td>
<td>{{ date('h:i A', strtotime($click->created_at)) }}</td>
</tr>

@empty

<tr>
<td colspan="4" class="text-center py-4 text-muted">
No clicks found
</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>


<!-------------------------- MODERN MODAL ADD KARO -------------------------------->

<div class="modal fade" id="clearClicksModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">
          <i class="fa fa-triangle-exclamation text-danger me-2"></i>
          Clear Click Data
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body pt-2">
        <p class="text-muted mb-0">
          Are you sure you want to delete all coupon click records?
          This action cannot be undone.
        </p>
      </div>

      <div class="modal-footer border-0 pt-0">

        <button type="button"
                class="btn btn-light px-4"
                data-bs-dismiss="modal">
          Cancel
        </button>

        <a href="{{ route('admin.clear.clicks') }}"
           class="btn btn-danger px-4">
           Yes, Clear All
        </a>

      </div>

    </div>
  </div>
</div>



<!----------------------------- RECENT COUPONS ------------------------------>

<div class="card mt-4 border-0 shadow-sm rounded overflow-hidden">

<div class="p-4 border-bottom">
<h5 class="fw-bold mb-0">Recent Coupons</h5>
</div>

<div class="table-responsive p-1">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">
<tr>
<th>Title</th>
<th>Code</th>
<th>Discount</th>
<th>Expiry</th>
</tr>
</thead>

<tbody>

@foreach($recentCoupons as $coupon)
<tr>
<td>{{ $coupon->title }}</td>
<td><span class="badge bg-dark">{{ $coupon->code }}</span></td>
<td>{{ $coupon->discount }}</td>
<td>{{ $coupon->expiry_date }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* REFRESH BUTTON WORKING */
function refreshDashboard(){
let icon = document.getElementById('refreshIcon');
icon.classList.add('fa-spin');

setTimeout(function(){
window.location.href = window.location.href;
},400);
}

new Chart(document.getElementById('couponChart'), {
type:'bar',
data:{
labels:{!! json_encode($months) !!},
datasets:[{
label:'Coupons',
data:{!! json_encode($monthlyCoupons) !!},
borderRadius:8
}]
},
options:{
plugins:{legend:{display:false}},
responsive:true
}
});

new Chart(document.getElementById('clickChart'), {
type:'line',
data:{
labels:{!! json_encode($clickDays) !!},
datasets:[{
label:'Clicks',
data:{!! json_encode($clickCounts) !!},
tension:.4,
fill:false
}]
},
options:{
plugins:{legend:{display:false}},
responsive:true
}
});

</script>

@endsection