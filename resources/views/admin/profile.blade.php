@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="card p-4">

<h3 class="mb-4">My Profile</h3>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('admin.profile.update') }}">
@csrf

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email"
name="email"
value="{{ auth()->user()->email }}"
class="form-control"
required>
</div>

<div class="mb-3">
<label class="form-label">New Password</label>
<input type="password"
name="password"
class="form-control"
placeholder="Leave blank if no change">
</div>

<div class="mb-3">
<label class="form-label">Confirm Password</label>
<input type="password"
name="password_confirmation"
class="form-control">
</div>

<button class="btn btn-primary">
Update Profile
</button>

</form>

</div>

</div>

@endsection