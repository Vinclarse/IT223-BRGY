<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admin - Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{url('frontend/style.css')}}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="#">Community e-Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{url('admin_dashboard')}}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{url('manageusers_admin')}}">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('website_management')}}">Website Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('system_settings')}}">System Settings</a></li>
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
        <h1 class="display-5 fw-bold">Manage Users</h1>
        <p class="lead text-secondary">
            Here you can manage user accounts, roles, and permissions.
        </p>
    </header>

    <section class="container mb-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>

    <section class="container mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small">Admins</p>
                        <h3 class="fw-bold mb-0 text-center">{{ $counts['admins'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small">Officials</p>
                        <h3 class="fw-bold mb-0 text-center">{{ $counts['officials'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small">Residents</p>
                        <h3 class="fw-bold mb-0 text-center">{{ $counts['residents'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1 small">Pending resident verifications</p>
                        <h3 class="fw-bold mb-0 text-center">{{ $counts['pendingResidents'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-navy mb-0">User List</h3>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-lg"></i> Add User
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form class="row g-2 align-items-end mb-3" method="GET" action="{{ route('manageusers_admin') }}">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Email or ID">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Role</label>
                        <select name="role" class="form-select">
                            <option value="">All</option>
                            @foreach(['Admin','Official','Resident'] as $role)
                                <option value="{{ $role }}" @selected(request('role')===$role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            @foreach(['Active','Inactive'] as $status)
                                <option value="{{ $status }}" @selected(request('status')===$status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-outline-primary w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('manageusers_admin') }}">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <span class="badge {{ $user->status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $user->status ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->date_created ?? '—' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $user->user_id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <form action="{{ route('manageusers_admin.destroy', $user->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="collapse" id="edit-{{ $user->user_id }}">
                                    <td colspan="6">
                                        <form class="row g-2 align-items-end" method="POST" action="{{ route('manageusers_admin.update', $user->user_id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="col-md-3">
                                                <label class="form-label small text-muted">Email</label>
                                                <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small text-muted">Role</label>
                                                <select name="role" class="form-select" required>
                                                    @foreach(['Admin','Official','Resident'] as $role)
                                                        <option value="{{ $role }}" @selected($user->role===$role)>{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small text-muted">Status</label>
                                                <select name="status" class="form-select" required>
                                                    @foreach(['Active','Inactive'] as $status)
                                                        <option value="{{ $status }}" @selected($user->status===$status)>{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small text-muted">New Password (optional)</label>
                                                <input type="text" name="password" class="form-control" placeholder="Leave blank to keep current">
                                            </div>
                                            <div class="col-md-2 d-grid">
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('manageusers_admin.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="Admin">Admin</option>
                                <option value="Official">Official</option>
                                <option value="Resident">Resident</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
