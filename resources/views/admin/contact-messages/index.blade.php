@extends('admin.layout')

@section('content')

<div class="container-fluid">

<h2 class="mb-4 fw-bold">Contact Messages</h2>

<div class="card p-0 rounded-1 overflow-hidden">

<table class="table mb-0">

<thead class="table-dark">
<tr>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($messages as $m)

<tr>

<td>{{ $m->name }}</td>

<td>{{ $m->email }}</td>

<td>{{ $m->subject }}</td>

<td>

@if($m->is_replied == 1)

<span class="badge bg-success">
Replied
</span>

@else

<span class="badge bg-warning text-dark">
Unread
</span>

@endif

</td>

<td>
{{ $m->created_at->format('d M Y h:i A') }}
</td>

<td>

<a href="{{ route('admin.contact.messages.show',$m->id) }}"
class="btn btn-sm btn-primary">
View
</a>

<form method="POST"
action="{{ route('admin.contact.messages.delete',$m->id) }}"
class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection