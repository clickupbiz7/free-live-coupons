@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="card p-4 rounded-1 border-0 shadow-sm">

<h3 class="mb-4 fw-bold">My Profile</h3>

@if(session('success'))
<div class="alert alert-success rounded-3">
<i class="fa fa-check-circle me-2"></i>
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger rounded-3">
<i class="fa fa-times-circle me-2"></i>
{{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('admin.profile.update') }}">
@csrf


<!-- CURRENT EMAIL -->
<div class="mb-4">

<label class="form-label fw-semibold">
Current Email
</label>

<div class="input-group">
<span class="input-group-text bg-white">
<i class="fa fa-envelope text-primary"></i>
</span>

<input type="email"
value="{{ auth()->user()->email }}"
class="form-control"
readonly>
</div>

<small class="text-muted d-block mt-2">
Your current admin login email.
</small>

</div>



<!-- NEW EMAIL -->
<div class="mb-4">

<label class="form-label fw-semibold">
New Email
</label>

<div class="input-group">
<span class="input-group-text bg-white">
<i class="fa fa-at text-success"></i>
</span>

<input type="email"
name="new_email"
class="form-control"
placeholder="Enter your new email">
</div>

<small class="text-muted d-block mt-2">
Enter a new email and confirm from your current email.
</small>

</div>



<!-- STATUS AREA -->
<div class="mb-4">

@if(auth()->user()->pending_email)

<span class="badge bg-warning text-dark px-3 py-2">
<i class="fa fa-clock me-1"></i>
Pending Email Change
</span>

<div class="small text-muted mt-2">
Pending:
<strong>{{ auth()->user()->pending_email }}</strong>
</div>

@elseif(auth()->user()->email_verified_at)

<span class="badge bg-success px-3 py-2">
<i class="fa fa-check-circle me-1"></i>
Verified Email
</span>

@else

<span class="badge bg-danger px-3 py-2">
<i class="fa fa-times-circle me-1"></i>
Not Verified
</span>

@endif

</div>



<!-- CURRENT PASSWORD -->
<div class="mb-4">

<label class="form-label fw-semibold">
Current Password
</label>

<div class="input-group">

<span class="input-group-text bg-white">
<i class="fa fa-lock text-secondary"></i>
</span>

<input type="password"
name="current_password"
id="current_password"
class="form-control"
placeholder="Required only for password change">

<button type="button"
class="btn btn-outline-secondary"
onclick="togglePass('current_password',this)">
<i class="fa fa-eye"></i>
</button>

</div>

</div>



<!-- NEW PASSWORD -->
<div class="mb-4">

<label class="form-label fw-semibold">
New Password
</label>

<div class="input-group">

<span class="input-group-text bg-white">
<i class="fa fa-key text-success"></i>
</span>

<input type="password"
name="password"
id="new_password"
class="form-control"
placeholder="Leave blank if no change">

<button type="button"
class="btn btn-outline-secondary"
onclick="togglePass('new_password',this)">
<i class="fa fa-eye"></i>
</button>

</div>

<small class="text-muted">
Use uppercase, lowercase, number & symbol.
</small>

</div>



<!-- CONFIRM PASSWORD -->
<div class="mb-4">

<label class="form-label fw-semibold">
Confirm Password
</label>

<div class="input-group">

<span class="input-group-text bg-white">
<i class="fa fa-shield-alt text-danger"></i>
</span>

<input type="password"
name="password_confirmation"
id="confirm_password"
class="form-control"
placeholder="Re-enter new password">

<button type="button"
class="btn btn-outline-secondary"
onclick="togglePass('confirm_password',this)">
<i class="fa fa-eye"></i>
</button>

</div>

</div>



<!-- ACCOUNT STATUS -->
<div class="mb-4">

@if(auth()->user()->email_verified_at)

<span class="badge bg-success px-3 py-2">
<i class="fa fa-user-check me-1"></i>
Active Account
</span>

@else

<span class="badge bg-warning text-dark px-3 py-2">
<i class="fa fa-user-clock me-1"></i>
Pending Account
</span>

@endif

</div>



<!-- BUTTONS -->
<div class="d-flex gap-2 flex-wrap">

<button type="submit"
class="btn btn-primary px-4">
<i class="fa fa-save me-2"></i>
Update Profile
</button>

<button type="submit"
class="btn btn-outline-success px-4">
<i class="fa fa-envelope me-2"></i>
Save & Confirm Email
</button>

</div>

</form>

</div>

</div>



<script>
function togglePass(id, btn)
{
let input = document.getElementById(id);
let icon  = btn.querySelector('i');

if(input.type === 'password')
{
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
}
else
{
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
}
}
</script>

@endsection