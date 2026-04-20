<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<div class="card p-4" style="width:400px">

<h3>Forgot Password</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('admin.forgot.submit') }}">
@csrf

<input type="email" name="email" class="form-control mb-3" placeholder="Enter Email">

<button class="btn btn-primary w-100">Reset Password</button>

</form>

</div>
</body>
</html>