@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<div>
<h2 class="fw-bold mb-1">Stores Management</h2>
<p class="text-muted mb-0">
Manage all stores professionally
</p>
</div>

<div class="d-flex gap-2 flex-wrap">

<a href="{{ route('admin.stores.export') }}"
class="btn btn-success px-4 rounded">
<i class="fa fa-file-excel me-2"></i>
Export Excel
</a>

<button type="button"
class="btn btn-dark px-4 rounded"
data-bs-toggle="modal"
data-bs-target="#importStoreModal">

<i class="fa fa-upload me-2"></i>
Import Excel
</button>

<a href="{{ route('admin.stores.create') }}"
class="btn btn-primary px-4 rounded">
<i class="fa fa-plus me-2"></i>Add Store
</a>

</div>

</div>



<div class="card border-0 shadow-lg rounded overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th style="min-width:70px;">#ID</th>
<th style="min-width:260px;">Store</th>
<th>Description</th>
<th style="min-width:130px;">Status</th>
<th style="min-width:170px;">Actions</th>
</tr>
</thead>

<tbody>

@forelse($stores as $store)

<tr>

<td class="fw-semibold">
{{ $store->id }}
</td>



<td>

<div class="d-flex align-items-center gap-3">

<img src="{{ $store->logo ? asset('uploads/stores/'.$store->logo) : 'https://via.placeholder.com/55' }}"
style="
width:55px;
height:45px;
object-fit:contain;
border-radius:6px;
background:#fff;
padding:6px;
border:1px solid #eee;">

<div>

<div class="fw-semibold text-dark">
{{ $store->name }}
</div>

<small class="text-muted">
Slug: {{ $store->slug }}
</small>

</div>

</div>

</td>



<td class="text-muted">
{{ \Illuminate\Support\Str::limit($store->description,55) ?: 'No description added' }}
</td>



<td>

@if(($store->status ?? 1) == 1)

<span class="badge bg-success px-3 py-2 rounded">
Active
</span>

@else

<span class="badge bg-danger px-3 py-2 rounded">
Inactive
</span>

@endif

</td>



<td>

<div class="d-flex gap-2">

<a href="{{ route('admin.stores.edit',$store->id) }}"
class="btn btn-sm btn-warning rounded px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.stores.destroy',$store->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-sm btn-danger rounded px-3"
onclick="return confirmDelete(this.form,'store')">

<i class="fa fa-trash"></i>

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="5"
class="text-center py-5 text-muted fw-semibold">

No stores found

</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="importStoreModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content border-0 rounded-4">

<form method="POST"
action="{{ route('admin.stores.import') }}"
enctype="multipart/form-data">

@csrf

<div class="modal-header">
<h5 class="modal-title fw-bold">
Import Stores
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
title:'Delete Store?',
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