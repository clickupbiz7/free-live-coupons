@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
<div>
<h2 class="fw-bold mb-1">
{{ isset($blog) ? 'Edit Blog' : 'Create Blog' }}
</h2>
<p class="text-muted mb-0">
Blog Editor Panel
</p>
</div>

<a href="{{ route('admin.blogs.index') }}"
class="btn btn-dark px-4 rounded">
<i class="fa fa-arrow-left me-2"></i>
Back
</a>
</div>



<div class="card border-0 shadow-lg rounded-4">
<div class="card-body p-4">

@if(isset($blog))
<form action="{{ route('admin.blogs.update',$blog->id) }}"
method="POST"
enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{ route('admin.blogs.store') }}"
method="POST"
enctype="multipart/form-data">
@endif

@csrf

<div class="row g-4">

<!-- TITLE -->
<div class="col-md-8">
<label class="form-label fw-semibold">Blog Title</label>

<input type="text"
name="title"
class="form-control admin-input"
value="{{ old('title',$blog->title ?? '') }}"
placeholder="Enter blog title">

@error('title')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>



<!-- STATUS -->
<div class="col-md-4">
<label class="form-label fw-semibold">Status</label>

<select name="status" class="form-select admin-input">
<option value="1"
{{ old('status',$blog->status ?? 1) == 1 ? 'selected' : '' }}>
Publish
</option>

<option value="0"
{{ old('status',$blog->status ?? 1) == 0 ? 'selected' : '' }}>
Draft
</option>
</select>
</div>



<!-- CATEGORY -->
<div class="col-md-12">

<label class="form-label fw-semibold d-flex justify-content-between">
<span>Blog Category</span>

<button type="button"
class="btn btn-sm btn-primary rounded px-3"
data-bs-toggle="modal"
data-bs-target="#catModal">

<i class="fa fa-plus me-1"></i>
New Category

</button>
</label>

<select name="category_id"
class="form-select admin-input">

<option value="">Select Category</option>

@foreach($categories as $cat)

<option value="{{ $cat->id }}"
{{ old('category_id',$blog->category_id ?? '') == $cat->id ? 'selected' : '' }}>
{{ $cat->name }}
</option>

@endforeach

</select>

@error('category_id')
<small class="text-danger">{{ $message }}</small>
@enderror


<!-- MANAGE CATEGORY -->
<div class="mt-3">

<label class="form-label fw-semibold">
Manage Categories
</label>

<div id="categoryListBox">

@foreach($categories as $cat)

<div class="d-flex justify-content-between align-items-center border rounded-3 px-3 py-2 mb-2 category-row">

<span>{{ $cat->name }}</span>

<button type="button"
class="btn btn-sm btn-danger rounded px-3"
onclick="deleteCategory({{ $cat->id }}, this)">
Delete
</button>

</div>

@endforeach

</div>

</div>

</div>



<!-- SEO -->
<div class="col-md-12">
<label class="form-label fw-semibold">
SEO URL Preview
</label>

<input type="text"
id="slugPreview"
readonly
class="form-control admin-input bg-light"
value="{{ isset($blog) ? url('/blog/'.$blog->slug) : url('/blog/sample-blog-url') }}">
</div>



<!-- CONTENT -->
<div class="col-md-12">
<label class="form-label fw-semibold">
Blog Content
</label>

<textarea
id="editor"
name="content"
rows="10"
class="form-control admin-input">{{ old('content',$blog->content ?? '') }}</textarea>

@error('content')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>



<!-- IMAGE -->
<div class="col-md-12">
<label class="form-label fw-semibold">
Featured Image
</label>

<input type="file"
name="image"
class="form-control admin-input"
onchange="previewImage(event)">

@error('image')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>



<!-- IMAGE PREVIEW -->
<div class="col-md-12 text-center">

<label class="form-label fw-semibold d-block">
Image Preview
</label>

<img id="preview"
src="{{ isset($blog) && $blog->image ? asset('uploads/blogs/'.$blog->image) : 'https://via.placeholder.com/320x180?text=Blog+Preview' }}"
style="width:320px;height:180px;object-fit:cover;border-radius:10px;border:1px solid #eee;">

</div>



<!-- BUTTONS -->
<div class="col-md-12 pt-2 d-flex gap-2">

<button class="btn btn-primary px-5 py-2 rounded">
<i class="fa fa-save me-2"></i>
{{ isset($blog) ? 'Update Blog' : 'Publish Blog' }}
</button>

<button type="submit"
name="status"
value="0"
class="btn btn-outline-dark px-4 py-2 rounded">
Save Draft
</button>

</div>

</div>
</form>

</div>
</div>

</div>



<!-- CATEGORY MODAL -->
<div class="modal fade" id="catModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content rounded-4 border-0">

<div class="modal-header">
<h5 class="modal-title fw-bold">
Add New Category
</h5>

<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text"
id="newCategory"
class="form-control admin-input"
placeholder="Enter category name">

</div>

<div class="modal-footer">

<button type="button"
class="btn btn-light"
data-bs-dismiss="modal">
Close
</button>

<button type="button"
class="btn btn-primary"
onclick="addCategory()">
Save Category
</button>

</div>

</div>
</div>
</div>



<style>
.admin-input{
border-radius:14px;
padding:12px 15px;
border:1px solid #dbe2ea;
transition:.3s;
box-shadow:none;
font-size:15px;
}

.admin-input:focus{
border-color:#4f46e5;
box-shadow:0 0 0 4px rgba(79,70,229,.08);
}

.card{
overflow:hidden;
}

.ck-editor__editable{
min-height:320px;
}

.category-row{
background:#fff;
transition:.3s;
}

.category-row:hover{
background:#f8f9ff;
}
</style>



<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

ClassicEditor.create(document.querySelector('#editor'), {

toolbar: [
'heading',
'|',
'bold',
'italic',
'link',
'bulletedList',
'numberedList',
'|',
'outdent',
'indent',
'|',
'imageUpload',
'insertTable',
'blockQuote',
'mediaEmbed',
'undo',
'redo'
],

image: {
toolbar: [
'imageStyle:inline',
'imageStyle:block',
'imageStyle:side',
'|',
'toggleImageCaption',
'imageTextAlternative'
]
},

table: {
contentToolbar: [
'tableColumn',
'tableRow',
'mergeTableCells'
]
},

ckfinder: {
uploadUrl: "{{ route('admin.blog.upload.image') }}?_token={{ csrf_token() }}"
}

})
.then(editor => {
window.editor = editor;
})
.catch(error => {
console.error(error);
});



function previewImage(event)
{
let reader = new FileReader();

reader.onload = function()
{
document.getElementById('preview').src = reader.result;
}

reader.readAsDataURL(event.target.files[0]);
}



/*
===================================
AUTO SLUG
===================================
*/
document.querySelector('[name="title"]').addEventListener('keyup', function(){

let val = this.value
.toLowerCase()
.trim()
.replace(/[^a-z0-9]+/g,'-')
.replace(/^-+|-+$/g,'');

document.getElementById('slugPreview').value =
"{{ url('/blog') }}/" + val;

});



/*
===================================
ADD CATEGORY
===================================
*/
function addCategory()
{
let name = document.getElementById('newCategory').value;

if(name.trim() == '')
{
showToast('Enter category name');
return;
}

fetch("{{ route('admin.blog.category.store') }}", {
method: "POST",

headers: {
"Content-Type": "application/json",
"X-CSRF-TOKEN": "{{ csrf_token() }}",
"Accept": "application/json"
},

body: JSON.stringify({
name: name
})

})

.then(res => res.json())

.then(data => {

if(data.success)
{
let select = document.querySelector('[name="category_id"]');

let option = document.createElement('option');

option.value = data.id;
option.text = data.name;
option.selected = true;

select.appendChild(option);

document.getElementById('categoryListBox').innerHTML += `
<div class="d-flex justify-content-between align-items-center border rounded-3 px-3 py-2 mb-2 category-row">
<span>${data.name}</span>

<button type="button"
class="btn btn-sm btn-danger rounded px-3"
onclick="confirmDeleteCategory(${data.id}, this)">
Delete
</button>

</div>
`;

document.getElementById('newCategory').value = '';

bootstrap.Modal
.getInstance(document.getElementById('catModal'))
.hide();

showToast('Category Added Successfully');
}

})

.catch(() => {
showToast('Something went wrong');
});

}



/*
===================================
CONFIRM DELETE
===================================
*/
function confirmDeleteCategory(id, btn)
{
Swal.fire({
title: 'Delete Category?',
text: 'Choose what to do',
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#d33',
cancelButtonColor: '#6c757d',
confirmButtonText: 'Continue',
cancelButtonText: 'Cancel'
}).then((result) => {

if(result.isConfirmed)
{
deleteCategory(id, btn);
}

});
}



/*
===================================
DELETE CATEGORY
===================================
*/
function deleteCategory(id, btn)
{
fetch('/admin/blog-category/delete/' + id, {
method: 'DELETE',

headers: {
"X-CSRF-TOKEN": "{{ csrf_token() }}",
"Accept": "application/json"
}

})
.then(res => res.json())

.then(data => {

if(data.success)
{
btn.closest('.category-row').remove();
showToast(data.message);
}

/*
IF BLOGS EXIST
*/
else if(data.need_action)
{
advancedDeletePopup(id, btn);
}

else
{
Swal.fire({
icon: 'error',
title: 'Cannot Delete',
text: data.message
});
}

})

.catch(() => {

Swal.fire({
icon: 'error',
title: 'Failed',
text: 'Delete failed'
});

});
}



/*
===================================
ADVANCED POPUP
===================================
*/
function advancedDeletePopup(id, btn)
{
Swal.fire({
title: 'Category has blogs',
html: `
<div style="display:flex;flex-direction:column;gap:10px;margin-top:15px;">

<button onclick="moveBlogs(${id})"
class="swal2-confirm swal2-styled"
style="background:#3085d6;">
Move Blogs To Another Category
</button>

<button onclick="deleteAllBlogs(${id})"
class="swal2-confirm swal2-styled"
style="background:#d33;">
Delete Category + Blogs
</button>

</div>
`,
showConfirmButton:false,
showCloseButton:true
});
}



/*
===================================
MOVE BLOGS
===================================
*/
function moveBlogs(id)
{
Swal.fire({
title:'Enter Target Category ID',
input:'number',
inputPlaceholder:'Example: 2',
showCancelButton:true,
confirmButtonText:'Move Now'
}).then((result)=>{

if(result.isConfirmed)
{
fetch('/admin/blog-category/delete/' + id,{
method:'DELETE',

headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":"{{ csrf_token() }}",
"Accept":"application/json"
},

body: JSON.stringify({
action:'move',
move_to:result.value
})

})
.then(res=>res.json())
.then(data=>{

if(data.success)
{
Swal.fire('Success', data.message, 'success');
location.reload();
}
else
{
Swal.fire('Error', data.message, 'error');
}

});
}

});
}



/*
===================================
DELETE BLOGS TOO
===================================
*/
function deleteAllBlogs(id)
{
Swal.fire({
title:'Are you sure?',
text:'All blogs in this category will be deleted.',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
confirmButtonText:'Yes Delete'
}).then((result)=>{

if(result.isConfirmed)
{
fetch('/admin/blog-category/delete/' + id,{
method:'DELETE',

headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":"{{ csrf_token() }}",
"Accept":"application/json"
},

body: JSON.stringify({
action:'delete_all'
})

})
.then(res=>res.json())
.then(data=>{

if(data.success)
{
Swal.fire('Deleted', data.message, 'success');
location.reload();
}
else
{
Swal.fire('Error', data.message, 'error');
}

});
}

});
}



/*
===================================
TOAST
===================================
*/
function showToast(msg)
{
Swal.fire({
toast: true,
position: 'top-end',
icon: 'success',
title: msg,
showConfirmButton: false,
timer: 2200,
timerProgressBar: true
});
}

</script>

@endsection