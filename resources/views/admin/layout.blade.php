{{-- resources/views/admin/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Panel - Free Live Coupons</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
--primary:#6366f1;
--dark:#0f172a;
--dark2:#111827;
--light:#f8fafc;
--text:#334155;
--border:#e5e7eb;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:#f1f5f9;
font-family:'Poppins',sans-serif !important;
color:var(--text);
}

/* Sidebar */
.sidebar{
width:270px;
height:100vh;
position:fixed;
top:0;
left:0;
z-index:1000;
overflow-y:auto;
background:linear-gradient(180deg,var(--dark),var(--dark2));
padding:24px 18px;
}

.brand{
color:#fff;
font-size:28px;
font-weight:800;
margin-bottom:28px;
display:flex;
align-items:center;
gap:10px;
}

.brand i{ color:#facc15; }

.menu-title{
color:#94a3b8;
font-size:12px;
letter-spacing:1px;
margin:14px 8px 10px;
text-transform:uppercase;
}

.sidebar .nav-link{
color:#cbd5e1;
padding:13px 14px;
border-radius:12px;
margin-bottom:8px;
display:flex;
align-items:center;
gap:12px;
transition:.25s;
text-decoration:none;
font-size:15px;
font-weight:600;
}

.sidebar .nav-link i{
width:18px;
text-align:center;
}

.sidebar .nav-link:hover{
background:rgba(255,255,255,.08);
color:#fff;
transform:translateX(4px);
}

.sidebar .nav-link.active{
background:linear-gradient(135deg,#4f46e5,#7c3aed);
color:#fff !important;
box-shadow:0 12px 24px rgba(99,102,241,.25);
}

/* Main */

.main{
margin-left:270px;
min-height:100vh;
}

/* Topbar */

.topbar{
background:rgba(255,255,255,.92);
backdrop-filter:blur(8px);
padding:16px 24px;
border-bottom:1px solid var(--border);
display:flex;
justify-content:space-between;
align-items:center;
position:sticky;
top:0;
z-index:900;
}

.page-title{
font-size:22px;
font-weight:800;
color:#0f172a;
}

.top-actions{
display:flex;
align-items:center;
gap:12px;
}

.icon-btn{
width:42px;
height:42px;
border:none;
border-radius:50px;
background:#fff;
box-shadow:0 8px 18px rgba(0,0,0,.05);
color:#334155;
display:flex;
align-items:center;
justify-content:center;
}

.profile-btn{
width:46px;
height:46px;
border:none;
background:#111827;
color:#fff;
border-radius:50px;
font-size:22px;
display:flex;
align-items:center;
justify-content:center;
}

.profile-btn::after{
display:none !important;
}

.alert{
border:none;
border-radius:14px;
box-shadow:0 10px 20px rgba(0,0,0,.04);
}

.card{
border:none;
border-radius:18px;
box-shadow:0 12px 24px rgba(0,0,0,.05);
}

.content-wrap{
padding:22px;
}

.dropdown-menu{
border:none;
border-radius:10px;
box-shadow:0 20px 40px rgba(0,0,0,.08);
min-width:260px;
padding:10px 0;
}

.dropdown-item{
padding:12px 18px;
font-weight:600;
white-space:normal;
}

.dropdown-item:hover{
background:#f8fafc;
}

.dropdown-head{
padding:12px 18px 8px;
}

.user-email{
font-size:14px;
font-weight:700;
color:#111827;
word-break:break-all;
}

.user-label{
font-size:12px;
color:#64748b;
}

#clearClicksModal .modal-content{
    background:#ffffff;
}

#clearClicksModal .modal-title{
    font-size:20px;
}

#clearClicksModal .btn-danger{
    border-radius:10px;
    font-weight:600;
}

#clearClicksModal .btn-light{
    border-radius:10px;
    font-weight:600;
}

#clearClicksModal .modal-body p{
    font-size:15px;
    line-height:1.7;
}

.msg-badge{
margin-left:auto;
min-width:22px;
height:22px;
padding:0 6px;
border-radius:50px;
background:#ef4444;
color:#fff;
font-size:11px;
font-weight:700;
display:flex;
align-items:center;
justify-content:center;
}

@media(max-width:991px){
.sidebar{ left:-280px; transition:.3s; }
.sidebar.show{ left:0; }
.main{ margin-left:0; }
.mobile-toggle{ display:inline-flex !important; }
}

.mobile-toggle{ display:none; }

.notification-remove-form{
position:absolute;
top:12px;
right:12px;
margin:0;
z-index:5;
}

.notification-remove-btn{
width:28px;
height:28px;
border:none;
background:#f8fafc;
color:#ef4444;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
padding:0;
font-size:13px;
cursor:pointer;
transition:.2s ease;
box-shadow:0 4px 10px rgba(0,0,0,.06);
}

.notification-remove-btn:hover{
background:#ef4444;
color:#fff;
transform:scale(1.06);
}

</style>


</head>

<body>

@php
$messageCount = \App\Models\ContactMessage::count();
$notifications = \App\Models\AdminNotification::latest()->take(8)->get();
$notificationCount = \App\Models\AdminNotification::where('is_read',0)->count();
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">

<div class="brand">
<i class="fa fa-bolt"></i> Admin
</div>

<div class="menu-title">Main Menu</div>

<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
<i class="fa fa-chart-line"></i> Dashboard
</a>

<a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}">
<i class="fa fa-ticket"></i> Coupons
</a>

<a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
<i class="fa fa-folder-open"></i> Categories
</a>

<a href="{{ route('admin.stores.index') }}" class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
<i class="fa fa-store"></i> Stores
</a>

<a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->is('admin/blogs*') ? 'active' : '' }}">
<i class="fa fa-blog"></i> Blogs
</a>

<a href="{{ route('admin.contact.messages') }}" class="nav-link {{ request()->is('admin/contact-messages*') ? 'active' : '' }}">
<i class="fa fa-envelope"></i>
Contact Messages
</a>

<a href="{{ route('admin.ads.index') }}" class="nav-link {{ request()->is('admin/ads*') ? 'active' : '' }}">
<i class="fa fa-bullhorn"></i> Ads Management
</a>

<a href="{{ route('admin.settings') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
<i class="fa fa-cog"></i> Settings
</a>

</div>

<!-- Main -->
<div class="main">

<!-- Topbar -->
<div class="topbar">

<div class="d-flex align-items-center gap-2">

<button class="icon-btn mobile-toggle" onclick="toggleSidebar()">
<i class="fa fa-bars"></i>
</button>

<div class="page-title">Admin Dashboard</div>

</div>

<div class="top-actions">

<!-- Bell -->
<div class="dropdown">

<button class="icon-btn position-relative" data-bs-toggle="dropdown">
<i class="fa fa-bell"></i>

@if($notificationCount > 0)
<span style="
position:absolute;
top:-4px;
right:-4px;
background:#ef4444;
color:#fff;
font-size:10px;
font-weight:700;
min-width:18px;
height:18px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;">
{{ $notificationCount }}
</span>
@endif

</button>

<ul class="dropdown-menu dropdown-menu-end p-0" style="width:340px;">

<li class="p-3 border-bottom fw-bold">
Notifications
</li>

@forelse($notifications as $item)

<li class="border-bottom position-relative">

<a href="{{ route('admin.notifications.read',$item->id) }}"
class="dropdown-item py-3 pe-5">

<div class="fw-semibold">
{{ $item->title }}
</div>

<small class="text-muted d-block">
{{ $item->message }}
</small>

<small class="text-muted">
{{ $item->created_at->diffForHumans() }}
</small>

</a>

<form method="POST"
action="{{ route('admin.notifications.remove',$item->id) }}"
class="notification-remove-form">

@csrf

<button type="submit"
class="notification-remove-btn">

<i class="fa fa-times"></i>

</button>

</form>

</li>

@empty

<li class="p-3 text-muted text-center">
No Notifications
</li>

@endforelse

</ul>

</div>

<!-- Profile -->
<div class="dropdown">

<button class="profile-btn dropdown-toggle" data-bs-toggle="dropdown">
<i class="fa fa-user-circle"></i>
</button>

<ul class="dropdown-menu dropdown-menu-end">

<li class="dropdown-head">
<div class="user-label">Logged In Account</div>
<div class="user-email">
{{ auth()->check() ? auth()->user()->email : 'Admin' }}
</div>
</li>

<li><hr class="dropdown-divider"></li>

<li>
<a href="{{ route('admin.profile') }}" class="dropdown-item">
<i class="fa fa-user me-2 text-primary"></i>
My Profile
</a>
</li>

<li>
<a href="{{ route('admin.settings') }}" class="dropdown-item">
<i class="fa fa-cog me-2 text-secondary"></i>
Settings
</a>
</li>

<li><hr class="dropdown-divider"></li>

<li>
<a href="{{ route('admin.logout') }}" class="dropdown-item text-danger">
<i class="fa fa-sign-out-alt me-2"></i>
Logout
</a>
</li>

</ul>

</div>

</div>
</div>

<!-- Content -->
<div class="content-wrap">

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

@yield('content')

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar(){
document.getElementById('sidebar').classList.toggle('show');
}
</script>

</body>
</html>