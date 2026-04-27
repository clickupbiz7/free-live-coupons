{{-- FILE: resources/views/admin/categories/index.blade.php --}}

@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<div>
<h2 class="fw-bold mb-1">Categories Management</h2>
<p class="text-muted mb-0">Manage all categories professionally</p>
</div>

<div class="d-flex gap-2 flex-wrap">

<a href="{{ route('admin.categories.export') }}"
class="btn btn-success px-4 rounded">
<i class="fa fa-file-excel me-2"></i>
Export Excel
</a>

<button type="button"
class="btn btn-dark px-4 rounded"
data-bs-toggle="modal"
data-bs-target="#importCategoryModal">

<i class="fa fa-upload me-2"></i>
Import Excel
</button>

<a href="{{ route('admin.categories.create') }}"
class="btn btn-primary px-4 rounded">
<i class="fa fa-plus me-2"></i>Add Category
</a>

</div>


</div>



<div class="card border-0 shadow-lg rounded overflow-hidden">

<div class="table-responsive">

<table class="table align-middle mb-0 table-hover">

<thead class="table-dark">
<tr>
<th style="min-width:70px;">#ID</th>
<th style="min-width:260px;">Category</th>
<th style="min-width:170px;" class="text-center">Icon / Image</th>
<th style="min-width:130px;" class="text-center">Offers</th>
<th style="min-width:170px;" class="text-center">Actions</th>
</tr>
</thead>

<tbody>

@forelse($categories as $category)

<tr>

<td class="fw-semibold">
{{ $category->id }}
</td>



<td>
<div class="fw-semibold text-dark">
{{ $category->name }}
</div>
</td>



<td class="text-center">

<div class="cat-icon-box">

@if($category->icon && file_exists(public_path('uploads/categories/icons/'.$category->icon)))

<img src="{{ asset('uploads/categories/icons/'.$category->icon) }}"
class="cat-icon-img">

@elseif($category->image)

<img src="{{ asset('uploads/categories/'.$category->image) }}"
class="cat-icon-img">

@else

<div class="cat-empty-icon">
<i class="fa fa-image"></i>
</div>

@endif

</div>

</td>



<td class="text-center">

<span class="badge bg-success px-3 py-2 rounded">

{{ \App\Models\Coupon::where('category_id',$category->id)->count() }}
Offers

</span>

</td>



<td class="text-center">

<div class="d-flex justify-content-center gap-2">

<a href="{{ route('admin.categories.edit',$category->id) }}"
class="btn btn-sm btn-warning rounded px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.categories.destroy',$category->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-sm btn-danger rounded px-3"
onclick="return confirmDelete(this.form,'category')">

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

No categories found

</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="importCategoryModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content border-0 rounded-4">

<form method="POST"
action="{{ route('admin.categories.import') }}"
enctype="multipart/form-data">

@csrf

<div class="modal-header">
<h5 class="modal-title fw-bold">
Import Categories
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



<style>

.cat-icon-box{
width:64px;
height:64px;
display:flex;
align-items:center;
justify-content:center;
margin:auto;
background:#f8fafc;
border-radius:14px;
border:1px solid #eef2f7;
overflow:hidden;
}

.cat-icon-img{
width:46px;
height:46px;
object-fit:contain;
display:block;
}

.cat-empty-icon{
font-size:20px;
color:#94a3b8;
}

.table tbody tr:hover{
background:#f8fafc;
transition:.2s;
}

.card{
background:#fff;
}

</style>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmDelete(form,type)
{
event.preventDefault();

Swal.fire({
title:'Delete Category?',
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