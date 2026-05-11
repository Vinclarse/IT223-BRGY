<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Official Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{('frontend/style.css')}}">
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
                    <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manage_residents')}}">Manage Residents</a></li>
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
        <div class="container-fluid px-4 py-4">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="text-navy fw-bold mb-1">Dashboard Overview</h1>
                    <p class="text-muted mb-0">Welcome back! Here's what's happening in your barangay.</p>
                </div>
                <div class="text-end">
                    <span class="text-muted small">{{ now()->format('l, F d, Y') }}</span>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <!-- Pending Requests -->
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md h-100" style="border-left: 4px solid #ffc107 !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted text-uppercase small mb-2">Pending Requests</h6>
                                    <h2 class="fw-bold mb-0">{{ $pendingRequests ?? 0 }}</h2>
                                    <small class="text-muted">Requires attention</small>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ url('manage_e-serbisyo') }}" class="text-decoration-none small">
                                View all <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md h-100" style="border-left: 4px solid #0d6efd !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted text-uppercase small mb-2">Pending Appointments</h6>
                                    <h2 class="fw-bold mb-0">{{ $pendingAppointments ?? 0 }}</h2>
                                    <small class="text-muted">Out of {{ $totalAppointments ?? 0 }} total</small>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-calendar-check fs-4 text-primary"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ url('appointments_feedback') }}" class="text-decoration-none small">
                                Manage appointments <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pending Complaints -->
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md h-100" style="border-left: 4px solid #dc3545 !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted text-uppercase small mb-2">Pending Complaints</h6>
                                    <h2 class="fw-bold mb-0">{{ $pendingComplaints ?? 0 }}</h2>
                                    <small class="text-muted">Out of {{ $totalComplaints ?? 0 }} total</small>
                                </div>
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ url('manage_e-serbisyo/complaints') }}" class="text-decoration-none small">
                                View complaints <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Verified Residents -->
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md h-100" style="border-left: 4px solid #198754 !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted text-uppercase small mb-2">Verified Residents</h6>
                                    <h2 class="fw-bold mb-0">{{ $verifiedResidents ?? 0 }}</h2>
                                    <small class="text-muted">Out of {{ $totalResidents ?? 0 }} total</small>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-people fs-4 text-success"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ url('manage_residents') }}" class="text-decoration-none small">
                                Manage residents <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Statistics Row -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                            <h3 class="fw-bold mb-1">{{ $completedRequests ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Completed Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md">
                        <div class="card-body text-center">
                            <i class="bi bi-megaphone-fill text-info fs-1 mb-2"></i>
                            <h3 class="fw-bold mb-1">{{ $activeAnnouncements ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Active Announcements</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-event-fill text-primary fs-1 mb-2"></i>
                            <h3 class="fw-bold mb-1">{{ $upcomingEvents ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Upcoming Events</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-md">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar3 text-secondary fs-1 mb-2"></i>
                            <h3 class="fw-bold mb-1">{{ $totalEvents ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Total Events</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="row g-4">
                <!-- Recent Requests -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-list-ul me-2 text-navy"></i>Recent Requests</h5>
                                <a href="{{ url('manage_e-serbisyo') }}" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($recentRequests) && $recentRequests->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Resident</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentRequests as $request)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                                <i class="bi bi-person text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-semibold">{{ $request->resident_name ?? 'N/A' }}</div>
                                                                <small class="text-muted">{{ $request->service_name ?? 'Service Request' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <small>{{ \Carbon\Carbon::parse($request->request_date ?? now())->format('M d, Y') }}</small>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusClass = 'bg-secondary';
                                                            if(isset($request->status)) {
                                                                if($request->status === 'Pending') $statusClass = 'bg-warning text-dark';
                                                                elseif($request->status === 'Completed' || $request->status === 'Complete') $statusClass = 'bg-success';
                                                                elseif($request->status === 'In Progress') $statusClass = 'bg-info';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}">{{ $request->status ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No recent requests</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-calendar-check me-2 text-navy"></i>Recent Appointments</h5>
                                <a href="{{ url('appointments_feedback') }}" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($recentAppointments) && $recentAppointments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Resident</th>
                                                <th>Date & Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentAppointments as $appointment)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                                <i class="bi bi-person text-info"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-semibold">{{ $appointment->resident_name ?? 'N/A' }}</div>
                                                                <small class="text-muted">{{ Str::limit($appointment->purpose ?? 'Appointment', 30) }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <small>{{ \Carbon\Carbon::parse($appointment->appointment_date ?? now())->format('M d, Y h:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusClass = 'bg-secondary';
                                                            if($appointment->status === 'Pending') $statusClass = 'bg-warning text-dark';
                                                            elseif($appointment->status === 'Confirmed') $statusClass = 'bg-success';
                                                            elseif($appointment->status === 'Completed') $statusClass = 'bg-info';
                                                            elseif($appointment->status === 'Cancelled') $statusClass = 'bg-danger';
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}">{{ $appointment->status ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No recent appointments</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Activity Section -->
            <div class="row g-4 mt-2">
                <!-- Recent Complaints -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Recent Complaints</h5>
                                <a href="{{ url('manage_e-serbisyo/complaints') }}" class="btn btn-sm btn-outline-danger">View All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($recentComplaints) && $recentComplaints->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($recentComplaints as $complaint)
                                        <div class="list-group-item border-0 px-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ Str::limit($complaint->subject ?? 'Complaint', 50) }}</h6>
                                                    <p class="mb-1 text-muted small">{{ Str::limit($complaint->description ?? '', 60) }}</p>
                                                    <small class="text-muted">
                                                        <i class="bi bi-person me-1"></i>{{ $complaint->resident_name ?? 'Anonymous' }}
                                                        <span class="ms-2"><i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($complaint->date_filed ?? now())->format('M d, Y') }}</span>
                                                    </small>
                                                </div>
                                                <div>
                                                    @php
                                                        $statusClass = 'bg-secondary';
                                                        if($complaint->status === 'Pending') $statusClass = 'bg-warning text-dark';
                                                        elseif($complaint->status === 'Resolved') $statusClass = 'bg-success';
                                                        elseif($complaint->status === 'In Progress') $statusClass = 'bg-info';
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">{{ $complaint->status ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-shield-check fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No recent complaints</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-calendar-event me-2 text-navy"></i>Upcoming Events</h5>
                                <a href="{{ url('events_announcements') }}" class="btn btn-sm btn-outline-primary">Manage Events</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($recentEvents) && $recentEvents->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($recentEvents as $event)
                                        @php
                                            $eventDate = \Carbon\Carbon::parse($event->event_date ?? now());
                                            $isUpcoming = $eventDate->isFuture();
                                        @endphp
                                        <div class="list-group-item border-0 px-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $event->title ?? 'Event' }}</h6>
                                                    <p class="mb-1 text-muted small">
                                                        <i class="bi bi-geo-alt me-1"></i>{{ $event->location ?? 'TBA' }}
                                                    </p>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar3 me-1"></i>{{ $eventDate->format('F d, Y') }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <span class="badge {{ $isUpcoming ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $isUpcoming ? 'Upcoming' : 'Past' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No upcoming events</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pt-4 pb-2">
                            <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-lightning-charge me-2 text-navy"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <a href="{{ url('manage_e-serbisyo') }}" class="btn btn-outline-primary w-100 py-3">
                                        <i class="bi bi-file-earmark-text fs-4 d-block mb-2"></i>
                                        Manage Requests
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ url('appointments_feedback') }}" class="btn btn-outline-info w-100 py-3">
                                        <i class="bi bi-calendar-check fs-4 d-block mb-2"></i>
                                        Appointments
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ url('events_announcements') }}" class="btn btn-outline-success w-100 py-3">
                                        <i class="bi bi-calendar-event fs-4 d-block mb-2"></i>
                                        Events & Announcements
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ url('manage_residents') }}" class="btn btn-outline-secondary w-100 py-3">
                                        <i class="bi bi-people fs-4 d-block mb-2"></i>
                                        Manage Residents
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>