<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Free Live Coupons</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: #f5f6fa;
    margin: 0;
}

/* Sidebar */
.sidebar {
    width: 250px;
    min-height: 100vh;
    background: #111827;
    padding: 20px;
}

.sidebar h4 {
    color: #fff;
    font-weight: bold;
}

/* Menu */
.sidebar .nav-link {
    color: #d1d5db;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 5px;
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar .nav-link:hover {
    background: #374151;
    color: #fff;
}

.sidebar .active {
    background: #6366f1;
    color: #fff !important;
}

/* Topbar */
.topbar {
    background: #fff;
    padding: 12px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Cards */
.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-3px);
}
</style>

</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h4>⚡ Admin Panel</h4>
        <hr style="border-color:#374151;">

        <ul class="nav flex-column">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                   class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <i class="fa fa-folder"></i> Categories
                </a>
            </li>

            <li>
                <a href="{{ route('stores.index') }}"
                   class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                    <i class="fa fa-store"></i> Stores
                </a>
            </li>

            <li>
                <a href="{{ route('coupons.index') }}"
                   class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}">
                    <i class="fa fa-ticket"></i> Coupons
                </a>
            </li>

            <li>
                <a href="{{ route('blogs.index') }}"
                   class="nav-link {{ request()->is('admin/blogs*') ? 'active' : '' }}">
                    <i class="fa fa-blog"></i> Blogs
                </a>
            </li>

            <!-- NEW -->
            <li>
                <a href="{{ route('pages.index') }}"
                   class="nav-link {{ request()->is('admin/pages*') ? 'active' : '' }}">
                    <i class="fa fa-file"></i> Pages
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}"
                   class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                    <i class="fa fa-cog"></i> Settings
                </a>
            </li>

        </ul>

    </div>

    <!-- MAIN -->
    <div class="w-100">

        <!-- TOPBAR -->
        <div class="topbar">
            <h5 class="mb-0">Admin Dashboard</h5>

            <div>
                <a href="/" class="btn btn-sm btn-outline-dark">
                    🌐 Visit Site
                </a>
            </div>
        </div>

        <!-- ALERT -->
        <div class="p-3">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- CONTENT -->
        <div class="p-4">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>