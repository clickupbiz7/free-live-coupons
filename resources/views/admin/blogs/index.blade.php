{{-- ==================================================== --}}
{{-- FILE: resources/views/admin/blogs/index.blade.php --}}
{{-- ==================================================== --}}
@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Blogs Management</h2>
        <p class="text-muted mb-0">Manage all blog posts professionally</p>
    </div>

    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary px-4">
        <i class="fa fa-plus me-2"></i>Add Blog
    </a>
</div>

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-dark">
<tr>
<th>#ID</th>
<th>Blog</th>
<th>Content</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($blogs as $blog)
<tr>

<td>{{ $blog->id }}</td>

<td>
<div class="d-flex align-items-center gap-3">

<img src="{{ $blog->image ? asset('uploads/blogs/'.$blog->image) : 'https://via.placeholder.com/60x45' }}"
style="width:60px;height:45px;object-fit:cover;border-radius:10px;">

<div class="fw-semibold">
{{ $blog->title }}
</div>

</div>
</td>

<td>
{{ \Illuminate\Support\Str::limit(strip_tags($blog->content),80) }}
</td>

<td>
@if(($blog->status ?? 1) == 1)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Inactive</span>
@endif
</td>

<td>

<a href="{{ route('admin.blogs.edit',$blog->id) }}"
class="btn btn-sm btn-warning rounded-pill px-3">
<i class="fa fa-edit"></i>
</a>

<form action="{{ route('admin.blogs.destroy',$blog->id) }}"
method="POST"
class="d-inline">
@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger rounded-pill px-3"
onclick="return confirm('Delete this blog?')">
<i class="fa fa-trash"></i>
</button>

</form>

</td>

</tr>
@empty

<tr>
<td colspan="5" class="text-center py-5 text-muted">
No blogs found
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

</div>

</div>

@endsection