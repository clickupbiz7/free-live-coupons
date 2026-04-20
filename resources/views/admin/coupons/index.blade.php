{{-- ==================================================== --}}
{{-- FILE: resources/views/admin/coupons/index.blade.php --}}
{{-- ==================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Coupons Management</h2>
        <p class="text-muted mb-0">Manage all coupons in dashboard</p>
    </div>

    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary px-4">
        <i class="fa fa-plus me-2"></i>Add Coupon
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th>#ID</th>
<th>Coupon</th>
<th>Code</th>
<th>Discount</th>
<th>Type</th>
<th>Store</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($coupons as $coupon)
<tr>

<td>{{ $coupon->id }}</td>

<td>
<div class="d-flex align-items-center gap-3">

<img src="{{ $coupon->image ? asset('uploads/coupons/'.$coupon->image) : 'https://via.placeholder.com/55' }}"
style="width:55px;height:45px;object-fit:cover;border-radius:10px;">

<div>
<div class="fw-semibold">{{ $coupon->title }}</div>
<small class="text-muted">
{{ \Illuminate\Support\Str::limit($coupon->description,40) }}
</small>
</div>

</div>
</td>

<td>
<span class="badge bg-dark px-3 py-2">
{{ $coupon->code }}
</span>
</td>

<td>
<span class="badge bg-success px-3 py-2">
{{ $coupon->discount }}
</span>
</td>

<td>
@if($coupon->type == 'deal')
<span class="badge bg-warning text-dark">Deal</span>
@else
<span class="badge bg-primary">Coupon</span>
@endif
</td>

<td>{{ $coupon->store->name ?? '-' }}</td>

<td>

<a href="{{ route('admin.coupons.edit',$coupon->id) }}"
class="btn btn-sm btn-warning rounded-pill px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.coupons.destroy',$coupon->id) }}"
method="POST"
class="d-inline">
@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger rounded-pill px-3"
onclick="return confirm('Delete this coupon?')">
<i class="fa fa-trash"></i>
</button>

</form>

</td>

</tr>
@empty

<tr>
<td colspan="7" class="text-center py-5 text-muted">
No coupons found
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

</div>

</div>

@endsection