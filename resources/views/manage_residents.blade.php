<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Residents | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('official_dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{url('manage_residents')}}">Manage Residents</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manage_e-serbisyo')}}">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" style="background-color: #0b3d91; !important;">
                            <li><a class="dropdown-item" href="{{url('transparency_records')}}">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="{{url('events_announcements')}}">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item" href="{{url('appointments_feedback')}}">Appointments & Feedback</a></li>
                        </ul>
                    </li>
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

            <div class="container">
                <h1 class="mt-2 text-navy fw-bold">Manage Residents</h1>
                <p class="lead text-secondary">Here you can manage resident information and requests.</p>
                    <div class="mt-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form class="row g-3 mb-4" method="GET" action="{{ route('manage_residents') }}">
                        @csrf
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search by Name, Email or ID" value="{{ request('q', $q ?? '') }}">
                        </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="Verified" {{ (request('status', $status ?? '')==='Verified') ? 'selected' : '' }}>Verified</option>
                                    <option value="Pending" {{ (request('status', $status ?? '')==='Pending') ? 'selected' : '' }}>Pending</option>
                                    <option value="Unverified" {{ (request('status', $status ?? '')==='Unverified') ? 'selected' : '' }}>Unverified</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-grid">
                                <button type="submit" class="btn btn-outline-navy">Search</button>
                            </div>
                        @if(!isset($hasStatus) || !$hasStatus)
                            <div class="col-12 mt-2">
                                <small class="text-muted">Status column not found in the `resident` table; choosing a status will not filter results until the column exists.</small>
                            </div>
                        @endif
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Resident ID</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Birth Date</th>
                                        <th scope="col">Date Registered</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($residents) && $residents->count())
                                        @foreach($residents as $r)
                                            <tr>
                                                <td>{{ $r->resident_id }}</td>
                                                <td>{{ $r->user_id ?? '' }}</td>
                                                <td>{{ $r->full_name ?? '' }}</td>
                                                <td>{{ $r->address ?? '' }}</td>
                                                <td>{{ $r->contact_number ?? '' }}</td>
                                                <td>{{ $r->email ?? '' }}</td>
                                                <td>{{ isset($r->birth_date) ? date('Y-m-d', strtotime($r->birth_date)) : '' }}</td>
                                                <td>{{ isset($r->date_registered) ? date('Y-m-d', strtotime($r->date_registered)) : '' }}</td>
                                                <td>
                                                    @php $st = $r->status ?? 'Pending'; @endphp
                                                    @if(strtolower($st) === 'active' || strtolower($st) === 'verified')
                                                        <span class="badge bg-success">Verified</span>
                                                    @elseif(strtolower($st) === 'pending')
                                                        <span class="badge bg-warning text-dark">{{ $st }}</span>
                                                    @elseif(strtolower($st) === 'unverified')
                                                        <span class="badge bg-danger">{{ $st }}</span>
                                                    @elseif(strtolower($st) === 'inactive')
                                                        <span class="badge bg-secondary">{{ $st }}</span>
                                                    @else
                                                        <span class="badge bg-light text-dark">{{ $st }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('residents.show', $r->resident_id) }}" title="View"><i class="bi bi-eye text-sm"></i></a>
                                                    <a href="{{ route('residents.edit', $r->resident_id) }}" class="ms-3" title="Edit"><i class="bi bi-pencil text-sm"></i></a>
                                                    <form action="{{ route('residents.destroy', $r->resident_id) }}" method="POST" class="d-inline ms-3" onsubmit="return confirm('Delete this resident?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-link p-0" title="Delete"><i class="bi bi-trash text-sm"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">No residents found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @if(isset($residents) && method_exists($residents, 'links'))
                                <div class="card-footer bg-white border-0">
                                    {{ $residents->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>