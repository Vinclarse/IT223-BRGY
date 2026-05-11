<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="{{ url('resident_dashboard') }}">Community e-Portal</a>
        </div>
    </nav>

    <main class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-navy">My Complaints</h1>
            <a href="{{ route('complaint.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>File New Complaint
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                @if($complaints->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Complaint ID</th>
                                    <th>Date Filed</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($complaints as $complaint)
                                <tr>
                                    <td>#{{ $complaint->complaint_id }}</td>
                                    <td>{{ $complaint->date_filed->format('Y-m-d') }}</td>
                                    <td>{{ Str::limit($complaint->subject, 30) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($complaint->status == 'Pending') bg-warning
                                            @elseif($complaint->status == 'Confirmed') bg-info
                                            @elseif($complaint->status == 'Completed') bg-success
                                            @elseif($complaint->status == 'Cancelled') bg-danger
                                            @else bg-secondary @endif">
                                            {{ $complaint->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#complaintModal{{ $complaint->complaint_id }}">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-6 text-muted mb-3 d-block"></i>
                        <p class="text-muted">No complaints found.</p>
                        <a href="{{ route('complaint.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>File Your First Complaint
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modals for complaint details -->
        @foreach($complaints as $complaint)
        <div class="modal fade" id="complaintModal{{ $complaint->complaint_id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Complaint Details #{{ $complaint->complaint_id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Subject:</strong> {{ $complaint->subject }}</p>
                        <p><strong>Date Filed:</strong> {{ $complaint->date_filed->format('Y-m-d H:i:s') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge 
                                @if($complaint->status == 'Pending') bg-warning
                                @elseif($complaint->status == 'Confirmed') bg-info
                                @elseif($complaint->status == 'Completed') bg-success
                                @elseif($complaint->status == 'Cancelled') bg-danger
                                @else bg-secondary @endif">
                                {{ $complaint->status }}
                            </span>
                        </p>
                        <p><strong>Description:</strong></p>
                        <p>{{ $complaint->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </main>

    <footer class="bg-primary text-white text-center py-3 mt-auto w-100">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>