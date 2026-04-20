<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#0f172a,#111827,#1e293b);
    font-family:Arial, Helvetica, sans-serif;
}

.login-box{
    width:430px;
    background:#ffffff;
    padding:35px;
    border-radius:22px;
    box-shadow:0 25px 70px rgba(0,0,0,.35);
    animation:fadeIn .4s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.logo{
    width:70px;
    height:70px;
    margin:auto;
    border-radius:50%;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    margin-bottom:18px;
}

.title{
    text-align:center;
    font-weight:700;
    font-size:28px;
    color:#111827;
}

.sub{
    text-align:center;
    color:#6b7280;
    margin-bottom:25px;
    font-size:14px;
}

.form-label{
    font-weight:600;
    color:#111827;
    margin-bottom:6px;
}

.form-control{
    height:48px;
    border-radius:12px;
    border:1px solid #d1d5db;
    padding-left:15px;
}

.form-control:focus{
    box-shadow:none;
    border-color:#4f46e5;
}

.password-wrap{
    position:relative;
}

.eye-btn{
    position:absolute;
    right:14px;
    top:13px;
    border:none;
    background:none;
    color:#6b7280;
}

.login-btn{
    height:48px;
    border:none;
    border-radius:12px;
    font-weight:600;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
}

.login-btn:hover{
    opacity:.95;
}

.bottom-link{
    font-size:14px;
}

.alert{
    border-radius:12px;
}
</style>
</head>
<body>

<div class="login-box">

<div class="logo">
<i class="fa fa-shield-halved"></i>
</div>

<div class="title">Admin Login</div>
<div class="sub">Secure Access Control Panel</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('admin.login.submit') }}">
@csrf

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email"
name="email"
class="form-control"
placeholder="Enter your email"
value="{{ old('email') }}"
required>
</div>

<div class="mb-2">
<label class="form-label">Password</label>

<div class="password-wrap">
<input type="password"
name="password"
id="password"
class="form-control pe-5"
placeholder="Enter password"
required>

<button type="button" class="eye-btn" onclick="togglePass()">
<i class="fa fa-eye" id="eyeIcon"></i>
</button>
</div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 mt-2">

<div class="form-check">
<input class="form-check-input" type="checkbox" name="remember" id="remember">
<label class="form-check-label bottom-link" for="remember">
Remember Me
</label>
</div>

<a href="{{ route('admin.forgot') }}" class="text-decoration-none bottom-link">
Forgot Password?
</a>

</div>

<button type="submit" class="btn btn-primary w-100 login-btn">
<i class="fa fa-right-to-bracket me-2"></i> Login
</button>

</form>

</div>

<script>
function togglePass(){
    let pass = document.getElementById("password");
    let icon = document.getElementById("eyeIcon");

    if(pass.type === "password"){
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }else{
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>