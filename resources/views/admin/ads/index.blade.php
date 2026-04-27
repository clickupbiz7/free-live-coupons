@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<div>
<h2 class="fw-bold mb-1">Ads Management</h2>
<p class="text-muted mb-0">Manage all website ads professionally</p>
</div>

<a href="{{ route('admin.ads.create') }}"
class="btn btn-primary px-4 rounded">
<i class="fa fa-plus me-2"></i>Add Ad
</a>

</div>



<div class="card border-0 shadow-lg rounded overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th style="min-width:70px;">#ID</th>
<th style="min-width:220px;">Title</th>
<th style="min-width:130px;">Network</th>
<th style="min-width:180px;">Placement</th>
<th style="min-width:110px;">Size</th>
<th style="min-width:110px;">Device</th>
<th style="min-width:100px;">Status</th>
<th style="min-width:160px;">Actions</th>
</tr>
</thead>

<tbody>

@forelse($ads as $ad)

<tr>

<td class="fw-semibold">
{{ $ad->id }}
</td>



<td>
<div class="fw-semibold text-dark">
{{ $ad->title }}
</div>

<small class="text-muted">
Priority: {{ $ad->priority ?? 1 }}
</small>
</td>



<td>

@if($ad->network == 'google')

<span class="badge bg-primary px-3 py-2 rounded">
Google
</span>

@elseif($ad->network == 'adsterra')

<span class="badge bg-success px-3 py-2 rounded">
Adsterra
</span>

@else

<span class="badge bg-warning text-dark px-3 py-2 rounded">
Monetag
</span>

@endif

</td>



<td>

<span class="badge bg-secondary px-3 py-2 rounded">
{{ ucwords(str_replace('_',' ', $ad->placement)) }}
</span>

</td>



<td class="fw-semibold">
{{ $ad->size ?: '-' }}
</td>



<td>

<span class="badge bg-light text-dark border px-3 py-2 rounded">
{{ ucfirst($ad->device ?: 'all') }}
</span>

</td>



<td>

@if($ad->status == 1)

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

<a href="{{ route('admin.ads.edit',$ad->id) }}"
class="btn btn-sm btn-warning rounded px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.ads.destroy',$ad->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-sm btn-danger rounded px-3"
onclick="return confirmDelete(this.form,'ad')">

<i class="fa fa-trash"></i>

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="8"
class="text-center py-5 text-muted fw-semibold">
No ads found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmDelete(form,type)
{
event.preventDefault();

Swal.fire({
title:'Delete Ad?',
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