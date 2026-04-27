@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<div>
<h2 class="fw-bold mb-1">Blogs Management</h2>
<p class="text-muted mb-0">Manage all blog posts professionally</p>
</div>

<div class="d-flex gap-2 flex-wrap">

<a href="{{ route('admin.blogs.export') }}"
class="btn btn-success px-4 rounded">
<i class="fa fa-file-excel me-2"></i>
Export Excel
</a>

<button type="button"
class="btn btn-dark px-4 rounded"
data-bs-toggle="modal"
data-bs-target="#importBlogModal">

<i class="fa fa-upload me-2"></i>
Import Excel
</button>

<a href="{{ route('admin.blogs.create') }}"
class="btn btn-primary px-4 rounded">
<i class="fa fa-plus me-2"></i>Add Blog
</a>

</div>

</div>



<div class="card border-0 shadow-lg rounded overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th style="min-width:70px;">#ID</th>
<th style="min-width:280px;">Blog</th>
<th>Content</th>
<th style="min-width:130px;">Status</th>
<th style="min-width:160px;">Actions</th>
</tr>
</thead>

<tbody>

@forelse($blogs as $blog)

<tr>

<td class="fw-semibold">
{{ $blog->id }}
</td>



<td>

<div class="d-flex align-items-center gap-3">

<img src="{{ $blog->image ? asset('uploads/blogs/'.$blog->image) : 'https://via.placeholder.com/60x45' }}"
style="
width:60px;
height:45px;
object-fit:cover;
border-radius:8px;
border:1px solid #eee;">

<div>

<div class="fw-semibold text-dark">
{{ $blog->title }}
</div>

<small class="text-muted">
{{ $blog->category_name ?? 'Uncategorized' }}
</small>

</div>

</div>

</td>



<td class="text-muted">
{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),80) }}
</td>



<td>

@if(($blog->status ?? 1) == 1)

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

<a href="{{ route('admin.blogs.edit',$blog->id) }}"
class="btn btn-sm btn-warning rounded px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.blogs.destroy',$blog->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-sm btn-danger rounded px-3"
onclick="return confirmDelete(this.form,'blog')">

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

No blogs found

</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="importBlogModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content border-0 rounded-4">

<form method="POST"
action="{{ route('admin.blogs.import') }}"
enctype="multipart/form-data">

@csrf

<div class="modal-header">
<h5 class="modal-title fw-bold">
Import Blogs
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
title:'Delete Blog?',
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