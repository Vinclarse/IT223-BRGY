<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Document Requests | Community e-Portal</title>
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
            <h1 class="h3 fw-bold text-navy">My Document Requests</h1>
            <a href="{{ route('requestDocument') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Request
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
                @if($documentRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Date</th>
                                    <th>Document Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentRequests as $request)
                                <tr>
                                    <td>#{{ $request->request_id }}</td>
                                    <td>{{ $request->request_date }}</td>
                                    <td>
                                        @php
                                            $remarks = explode("\n", $request->remarks);
                                            $docType = str_replace('Document Type: ', '', $remarks[0] ?? 'N/A');
                                        @endphp
                                        {{ $docType }}
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($request->status == 'Pending') bg-warning
                                            @elseif($request->status == 'Processing') bg-info
                                            @elseif($request->status == 'Completed') bg-success
                                            @elseif($request->status == 'Rejected') bg-danger
                                            @else bg-secondary @endif">
                                            {{ $request->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('request.success', $request->request_id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-6 text-muted mb-3 d-block"></i>
                        <p class="text-muted">No document requests found.</p>
                        <a href="{{ route('requestDocument') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Make Your First Request
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <footer class="bg-primary text-white text-center py-3 mt-auto w-100">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>