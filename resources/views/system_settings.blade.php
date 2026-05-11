<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings | Admin - Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{url('frontend/style.css')}}">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="#">Community e-Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{url('admin_dashboard')}}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manageusers_admin')}}">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('website_management')}}">Website Management</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{url('system_settings')}}">System Settings</a></li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="#" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <header class="container mb-4">
        <h1 class="display-5 fw-bold">System Settings</h1>
        <p class="lead text-secondary">
            Manage security, admin accounts, backups, and review audit logs.
        </p>
    </header>

    <section class="container mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Admins</p>
                        <h3 class="fw-bold mb-0 text-center">{{ $settingsStats['totalAdmins'] ?? 0 }}</h3>
                        <small class="text-success">Active: {{ $settingsStats['activeAdmins'] ?? 0 }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Backup reminder</p>
                        <h3 class="fw-bold mb-0 text-warning text-center">Create export</h3>
                        <small class="text-muted">Download latest SQL backup.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Admin Accounts</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($adminUsers as $admin)
                                        <tr>
                                            <td>{{ $admin->user_id }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>
                                                <span class="badge {{ $admin->status === 'Active' ? 'bg-success' : 'bg-secondary' }}">{{ $admin->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted">No admin accounts yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <small class="text-muted d-block mt-2">Manage accounts in the Users page.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy"><i class="bi bi-shield-lock-fill"></i> Security</h5>
                        <p class="card-text text-secondary mb-2">Review password complexity, session limits, and 2FA rollout.</p>
                        <a href="{{ route('manageusers_admin') }}" class="btn btn-sm btn-primary">Manage access</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy"><i class="bi bi-database-fill"></i> Backup</h5>
                        <p class="card-text text-secondary mb-2">Export your database regularly. Keep backups offsite.</p>
                        <a href="#" class="btn btn-sm btn-primary">Download latest backup</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>