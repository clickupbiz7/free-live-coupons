{{-- ==================================================== --}}
{{-- FILE: resources/views/admin/stores/index.blade.php --}}
{{-- ==================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Stores Management</h2>
        <p class="text-muted mb-0">Manage all stores professionally</p>
    </div>

    <a href="{{ route('admin.stores.create') }}" class="btn btn-primary px-4">
        <i class="fa fa-plus me-2"></i>Add Store
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th>#ID</th>
<th>Store</th>
<th>Description</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($stores as $store)
<tr>

<td>{{ $store->id }}</td>

<td>
<div class="d-flex align-items-center gap-3">

<img src="{{ $store->logo ? asset('uploads/stores/'.$store->logo) : 'https://via.placeholder.com/55' }}"
style="width:55px;height:45px;object-fit:contain;border-radius:10px;background:#fff;padding:6px;">

<div class="fw-semibold">
{{ $store->name }}
</div>

</div>
</td>

<td>
{{ \Illuminate\Support\Str::limit($store->description,55) }}
</td>

<td>
@if(($store->status ?? 1) == 1)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Inactive</span>
@endif
</td>

<td>

<a href="{{ route('admin.stores.edit',$store->id) }}"
class="btn btn-sm btn-warning rounded-pill px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.stores.destroy',$store->id) }}"
method="POST"
class="d-inline">
@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger rounded-pill px-3"
onclick="return confirm('Delete this store?')">
<i class="fa fa-trash"></i>
</button>

</form>

</td>

</tr>
@empty

<tr>
<td colspan="5" class="text-center py-5 text-muted">
No stores found
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

</div>

</div>

@endsection