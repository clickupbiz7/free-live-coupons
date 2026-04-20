@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Dashboard Overview</h2>
        <p class="text-muted mb-0">Monitor your website performance</p>
    </div>

    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary px-4">
        <i class="fa fa-plus me-2"></i>Add Coupon
    </a>
</div>

<!-- Stats -->
<div class="row g-4">

    <div class="col-md-3">
        <div class="card p-4">
            <small class="text-muted">Categories</small>
            <h2 class="fw-bold">{{ $categories }}</h2>
            <span class="text-primary"><i class="fa fa-folder"></i></span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <small class="text-muted">Stores</small>
            <h2 class="fw-bold">{{ $stores }}</h2>
            <span class="text-success"><i class="fa fa-store"></i></span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <small class="text-muted">Coupons</small>
            <h2 class="fw-bold">{{ $coupons }}</h2>
            <span class="text-danger"><i class="fa fa-ticket"></i></span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-4">
            <small class="text-muted">Blogs</small>
            <h2 class="fw-bold">{{ $blogs }}</h2>
            <span class="text-warning"><i class="fa fa-blog"></i></span>
        </div>
    </div>

</div>

<!-- Chart + Side -->
<div class="row g-4 mt-1">

    <div class="col-lg-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-4">Monthly Coupons</h5>
            <canvas id="couponChart" height="110"></canvas>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="card p-4 mb-4">
            <small class="text-muted">Active Coupons</small>
            <h2 class="fw-bold text-success">{{ $activeCoupons }}</h2>
        </div>

        <div class="card p-4">
            <small class="text-muted">Expired Coupons</small>
            <h2 class="fw-bold text-danger">{{ $expiredCoupons }}</h2>
        </div>

    </div>

</div>

<!-- Recent Table -->
<div class="card mt-4 p-0 overflow-hidden">

    <div class="p-4 border-bottom">
        <h5 class="fw-bold mb-0">Recent Coupons</h5>
    </div>

    <div class="table-responsive">

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
new Chart(document.getElementById('couponChart'), {
type: 'bar',
data: {
labels: {!! json_encode($months) !!},
datasets: [{
label: 'Coupons',
data: {!! json_encode($monthlyCoupons) !!},
borderRadius: 8
}]
},
options:{
plugins:{legend:{display:false}},
responsive:true
}
});
</script>

@endsection