<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage e-Services | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{url('manage_residents')}}">Manage Residents</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{url('manage_e-serbisyo')}}">E-Serbisyo Requests</a></li>
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
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mt-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ !request()->is('*/complaints') ? 'active' : '' }}" href="{{ route('manage_e-serbisyo') }}{{ $q || $status ? '?q=' . urlencode($q) . '&status=' . urlencode($status) : '' }}">
                    Document Requests
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->is('*/complaints') ? 'active' : '' }}" href="{{ route('manage_e-serbisyo.complaints') }}{{ $q || $status ? '?q=' . urlencode($q) . '&status=' . urlencode($status) : '' }}">
                    Complaints
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Document Requests Tab -->
            @if(!request()->is('*/complaints'))
            <div class="tab-pane fade show active" role="tabpanel">
                <h1 class="mt-4 text-navy fw-bold">Manage e-Services</h1>
                <p class="lead text-secondary">Here you can manage e-Service requests from residents.</p>
                <div class="mt-4">
                    <h5 class="mb-3 text-navy fw-bold">Document Requests</h5>
                    <form method="GET" action="{{ route('manage_e-serbisyo') }}" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search by Name or Request ID" value="{{ $q ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Filter by Status</option>
                                <option value="Pending" {{ ($status ?? '') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ ($status ?? '') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Approved" {{ ($status ?? '') === 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ ($status ?? '') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-navy">Search</button>
                        </div>
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Request ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Document Type</th>
                                        <th scope="col">Date Requested</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $req)
                                    <tr>
                                        <td>{{ $req->request_id }}</td>
                                        <td>{{ $req->full_name }}</td>
                                        <td>{{ $req->document_type ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($req->request_date)->format('M d, Y') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('request.status', $req->request_id) }}" class="d-inline" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="Pending" {{ $req->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In Progress" {{ $req->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Approved" {{ $req->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="Rejected" {{ $req->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('request.destroy', $req->request_id) }}" class="d-inline" onsubmit="return confirm('Delete this request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-link btn-sm p-0">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No requests found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($requests->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $requests->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Complaints Tab -->
            @if(request()->is('*/complaints'))
            <div class="tab-pane fade show active" role="tabpanel">
                <h1 class="mt-4 text-navy fw-bold">Manage Complaints</h1>
                <p class="lead text-secondary">Here you can manage resident complaints.</p>
                <div class="mt-4">
                    <h5 class="mb-3 text-navy fw-bold">Residents Filed Complaints</h5>
                    <form method="GET" action="{{ route('manage_e-serbisyo.complaints') }}" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search by Name or Complaint ID" value="{{ $q ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Filter by Status</option>
                                <option value="Pending" {{ ($status ?? '') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ ($status ?? '') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ ($status ?? '') === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="Cancelled" {{ ($status ?? '') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-navy">Search</button>
                        </div>
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Complaint ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Date Filed</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($complaints as $comp)
                                    <tr>
                                        <td>{{ $comp->complaint_id }}</td>
                                        <td>{{ $comp->full_name }}</td>
                                        <td>{{ $comp->subject }}</td>
                                        <td>{{ \Carbon\Carbon::parse($comp->date_filed)->format('M d, Y') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('complaint.status', $comp->complaint_id) }}" class="d-inline" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="Pending" {{ $comp->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In Progress" {{ $comp->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Resolved" {{ $comp->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                                    <option value="Cancelled" {{ $comp->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('complaint.destroy', $comp->complaint_id) }}" class="d-inline" onsubmit="return confirm('Delete this complaint?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-sm text-danger p-0">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No complaints found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($complaints->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $complaints->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>