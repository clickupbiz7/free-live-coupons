{{-- ==================================================== --}}
{{-- FILE: resources/views/admin/categories/index.blade.php --}}
{{-- ==================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Categories Management</h2>
        <p class="text-muted mb-0">Manage all categories professionally</p>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary px-4">
        <i class="fa fa-plus me-2"></i>Add Category
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th>#ID</th>
<th>Category</th>
<th>Icon / Image</th>
<th>Offers</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($categories as $cat)
<tr>

<td>{{ $cat->id }}</td>

<td class="fw-semibold">
{{ $cat->name }}
</td>

<td>
@if($cat->icon)

<i class="{{ $cat->icon }}"
style="font-size:26px;color:#4f46e5;"></i>

@elseif($cat->image)

<img src="{{ asset('uploads/categories/'.$cat->image) }}"
style="width:55px;height:45px;object-fit:cover;border-radius:10px;">

@else

<i class="fa-solid fa-tag text-secondary"></i>

@endif
</td>

<td>
<span class="badge bg-success">
{{ \App\Models\Coupon::where('category_id',$cat->id)->count() }} Offers
</span>
</td>

<td>

<a href="{{ route('admin.categories.edit',$cat->id) }}"
class="btn btn-sm btn-warning rounded-pill px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.categories.destroy',$cat->id) }}"
method="POST"
class="d-inline">
@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger rounded-pill px-3"
onclick="return confirm('Delete this category?')">
<i class="fa fa-trash"></i>
</button>

</form>

</td>

</tr>
@empty

<tr>
<td colspan="5" class="text-center py-5 text-muted">
No categories found
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

</div>

</div>

@endsection