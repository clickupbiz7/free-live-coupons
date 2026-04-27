{{-- FILE: resources/views/admin/coupons/index.blade.php --}}

@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<div>
<h2 class="fw-bold mb-1">Coupons Management</h2>
<p class="text-muted mb-0">
Manage all coupons in dashboard
</p>
</div>

<div class="d-flex gap-2 flex-wrap">

<a href="{{ route('admin.coupons.export') }}"
class="btn btn-success px-4 rounded">
<i class="fa fa-file-excel me-2"></i>
Export Excel
</a>

<button type="button"
class="btn btn-dark px-4 rounded"
data-bs-toggle="modal"
data-bs-target="#importModal">

<i class="fa fa-upload me-2"></i>
Import Excel
</button>

<a href="{{ route('admin.coupons.create') }}"
class="btn btn-primary px-4 rounded">
<i class="fa fa-plus me-2"></i>
Add Coupon
</a>

</div>
</div>



<div class="card border-0 shadow-lg rounded overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th style="min-width:70px;">#ID</th>
<th style="min-width:280px;">Coupon</th>
<th style="min-width:120px;">Code</th>
<th style="min-width:150px;">Expiry</th>
<th style="min-width:100px;">Type</th>
<th style="min-width:130px;">Status</th>
<th style="min-width:130px;">Featured</th>
<th style="min-width:160px;">Store</th>
<th style="min-width:160px;">Actions</th>
</tr>
</thead>

<tbody>

@forelse($coupons as $coupon)

<tr>

<td class="fw-semibold">
{{ $coupon->id }}
</td>



<td>

<div class="d-flex align-items-center gap-3">

<img src="{{ $coupon->image ? asset('uploads/coupons/'.$coupon->image) : 'https://via.placeholder.com/55' }}"
style="
width:55px;
height:45px;
object-fit:cover;
border-radius:8px;
border:1px solid #eee;">

<div>

<div class="fw-semibold text-dark">
{{ $coupon->title }}
</div>

<small class="text-muted">
{{ \Illuminate\Support\Str::limit($coupon->description,40) }}
</small>

</div>

</div>

</td>



<td>

@if($coupon->code)

<span class="badge bg-dark px-3 py-2 rounded">
{{ $coupon->code }}
</span>

@else

<span class="badge bg-secondary px-3 py-2 rounded">
No Code
</span>

@endif

</td>



{{-- EXPIRY STATUS --}}
<td>

@php
$today = \Carbon\Carbon::today();

if(!$coupon->expiry_date){
$status = 'No Date';
$type = 'secondary';
}
else{
$exp = \Carbon\Carbon::parse($coupon->expiry_date);

if($exp->lt($today)){
$status = 'Expired';
$type = 'danger';
}
elseif($exp->isToday()){
$status = 'Today';
$type = 'warning';
}
else{
$days = $today->diffInDays($exp);
$status = $days.' Days Left';
$type = 'success';
}
}
@endphp

<span class="badge bg-{{ $type }} px-3 py-2 rounded">
{{ $status }}
</span>

</td>



<td>

@if($coupon->type == 'deal')

<span class="badge bg-warning text-dark px-3 py-2 rounded">
Deal
</span>

@else

<span class="badge bg-primary px-3 py-2 rounded">
Coupon
</span>

@endif

</td>



{{-- STATUS --}}
<td>

@if(($coupon->status ?? 1) == 1)

<span class="badge bg-success px-3 py-2 rounded">
Active
</span>

@else

<span class="badge bg-danger px-3 py-2 rounded">
Inactive
</span>

@endif

</td>



{{-- FEATURED --}}
<td>

@if(($coupon->featured ?? 0) == 1)

<span class="badge bg-info text-dark px-3 py-2 rounded">
Featured
</span>

@else

<span class="badge bg-secondary px-3 py-2 rounded">
Normal
</span>

@endif

</td>



<td class="fw-semibold text-muted">
{{ $coupon->store->name ?? '-' }}
</td>



<td>

<div class="d-flex gap-2">

<a href="{{ route('admin.coupons.edit',$coupon->id) }}"
class="btn btn-sm btn-warning rounded px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.coupons.destroy',$coupon->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-sm btn-danger rounded px-3"
onclick="return confirmDelete(this.form,'coupon')">

<i class="fa fa-trash"></i>

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="9"
class="text-center py-5 text-muted fw-semibold">

No coupons found

</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="importModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content border-0 rounded-4">

<form method="POST"
action="{{ route('admin.coupons.import') }}"
enctype="multipart/form-data">

@csrf

<div class="modal-header">
<h5 class="modal-title fw-bold">
Import Coupons
</h5>

<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<label class="form-label fw-semibold">
Select Excel File
</label>

<input type="file"
name="file"
required
class="form-control">

<small class="text-muted">
Allowed: xlsx, xls, csv
</small>

</div>

<div class="modal-footer">

<button type="button"
class="btn btn-light border"
data-bs-dismiss="modal">
Cancel
</button>

<button class="btn btn-primary px-4">
Upload & Import
</button>

</div>

</form>

</div>
</div>
</div>

</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmDelete(form,type)
{
event.preventDefault();

Swal.fire({
title:'Delete Coupon?',
text:'Are you sure you want to delete this '+type+'?',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
cancelButtonColor:'#6c757d',
confirmButtonText:'Yes Delete',
cancelButtonText:'Cancel'
}).then((result)=>{

if(result.isConfirmed)
{
form.submit();
}

});

return false;
}

</script>

@endsection