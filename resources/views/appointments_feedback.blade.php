<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments & Feedback | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{url('manage_e-serbisyo')}}">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" style="background-color: #0b3d91; !important;">
                            <li><a class="dropdown-item" href="{{url('transparency_records')}}">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="{{url('events_announcements')}}">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item active" href="{{url('appointments_feedback')}}">Appointments & Feedback</a></li>
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
    
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Please fix the following errors:
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <div class="container">
        <h1 class="mt-2 text-navy fw-bold">Appointments & Feedback</h1>
        <p class="lead text-secondary">Here you can manage appointments and view feedback from residents.</p>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <br>
            <button type="button" class="btn btn-outline-navy" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                <i class="bi bi-plus-circle"></i> Add New Appointment
            </button>
        </div>                
        
        <div class="mt-4">
            <h5 class="text-navy fw-bold">Appointments</h5>
            <form method="GET" action="{{ route('appointments_feedback') }}" class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" name="q" class="form-control" placeholder="Search by Name or Appointment ID" value="{{ $q ?? '' }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>Filter by Status</option>
                        <option value="Pending" {{ ($status ?? '') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ ($status ?? '') === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ ($status ?? '') === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ ($status ?? '') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-outline-navy">Search</button>
                </div>
            </form>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Appointment ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date & Time</th>
                                    <th scope="col">Purpose</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appt)
                                <tr>
                                    <td>{{ $appt->appointment_id }}</td>
                                    <td>{{ $appt->resident_full_name ?? 'Unknown' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y h:i A') }}</td>
                                    <td>{{ $appt->purpose }}</td>
                                    <td>
                                        <!-- FIXED: Using proper route for status update -->
                                        <form method="POST" action="{{ route('appointments.status', $appt->appointment_id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="Pending" {{ $appt->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Confirmed" {{ $appt->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="Completed" {{ $appt->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="Cancelled" {{ $appt->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-link btn-sm p-0 me-2 view-appt" data-bs-toggle="modal" data-bs-target="#viewAppointmentModal"
                                            data-id="{{ $appt->appointment_id }}"
                                            data-name="{{ $appt->resident_full_name ?? 'Unknown' }}"
                                            data-date="{{ $appt->appointment_date }}"
                                            data-purpose="{{ $appt->purpose }}"
                                            data-status="{{ $appt->status }}"
                                            data-description="{{ $appt->description ?? '' }}"
                                        ><i class="bi bi-eye"></i></button>

                                        <!-- FIXED: Using proper route for delete -->
                                        <form method="POST" action="{{ route('appointments.destroy', $appt->appointment_id) }}" class="d-inline" onsubmit="return confirm('Delete this appointment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn  btn-danger btn-link btn-sm p-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No appointments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($appointments->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $appointments->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Feedback Section -->
<h5 class="text-navy fw-bold mt-5">Resident Feedback</h5>
@forelse($feedbacks as $fb)
<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h5 class="card-title">Feedback from {{ $fb->full_name ?? 'Unknown' }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Submitted on {{ \Carbon\Carbon::parse($fb->date_submitted)->format('M d, Y') }}
                    </h6>
                </div>
                <div class="rating-display">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fb->rating)
                            <i class="bi bi-star-fill text-warning"></i>
                        @else
                            <i class="bi bi-star text-secondary"></i>
                        @endif
                    @endfor
                    <small class="text-muted ms-1">({{ $fb->rating }}/5)</small>
                </div>
            </div>
            <p class="card-text">{{ $fb->message }}</p>
            <!-- FIXED: Using proper route for feedback delete -->
            <form method="POST" action="{{ route('feedback.destroy', $fb->feedback_id) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-link p-0" onclick="return confirm('Delete this feedback?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="card mt-3 mb-5">
        <div class="card-body text-center text-muted">
            <i class="bi bi-chat-square-text"></i> No feedback found.
        </div>
    </div>
    @endforelse
        </div>
    </div>

    <!-- Appointment View/Edit Modal -->
    <div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- FIXED: Using proper route for appointment update -->
                <form id="viewAppointmentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Appointment ID</label>
                            <input type="text" class="form-control" id="modalApptId" readonly>
                            <input type="hidden" name="appointment_id" id="hiddenApptId">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Resident</label>
                            <input type="text" class="form-control" id="modalResident" readonly>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modalDate" class="form-label">Date & Time *</label>
                                <input type="datetime-local" id="modalDate" name="appointment_date" class="form-control" disabled required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modalPurpose" class="form-label">Purpose *</label>
                                <input type="text" id="modalPurpose" name="purpose" class="form-control" disabled required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="modalDescription" class="form-label">Description/Remarks</label>
                            <textarea id="modalDescription" name="description" class="form-control" rows="2" disabled></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label">Status *</label>
                            <select id="modalStatus" name="status" class="form-select" disabled required>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="modalEditBtn" class="btn btn-outline-navy">Edit</button>
                        <button type="submit" id="modalSaveBtn" class="btn btn-navy" disabled>Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- FIXED: Using proper route for appointment store -->
                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addResident" class="form-label">Select Resident *</label>
                            <select class="form-control" id="addResident" name="resident_id" required>
                                <option value="">Select a Resident</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->resident_id }}">
                                        {{ $resident->first_name }} {{ $resident->last_name }} 
                                        ({{ $resident->email ?? 'No email' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="addAppointmentDate" class="form-label">Appointment Date & Time *</label>
                                <input type="datetime-local" class="form-control" id="addAppointmentDate" name="appointment_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="addPurpose" class="form-label">Purpose *</label>
                                <select class="form-control" id="addPurpose" name="purpose" required>
                                    <option value="">Select Purpose</option>
                                    <option value="Document Request">Document Request</option>
                                    <option value="Barangay Clearance">Barangay Clearance</option>
                                    <option value="Business Permit">Business Permit</option>
                                    <option value="Complaint">Complaint</option>
                                    <option value="Inquiry">Inquiry</option>
                                    <option value="Meeting">Meeting</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="addDescription" class="form-label">Description/Remarks</label>
                            <textarea class="form-control" id="addDescription" name="description" rows="3" placeholder="Optional: Add any additional details..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="addStatus" class="form-label">Status *</label>
                            <select class="form-control" id="addStatus" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                            </select>
                        </div>
                        
                        <!-- Hidden field for official_id (will be set from session) -->
                        <input type="hidden" name="official_id" value="{{ session('user.official_id') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-navy">Save Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // View Appointment Modal
        document.querySelectorAll('.view-appt').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = btn.getAttribute('data-id');
                var residentName = btn.getAttribute('data-name');
                var date = btn.getAttribute('data-date');
                var purpose = btn.getAttribute('data-purpose');
                var status = btn.getAttribute('data-status');
                var description = btn.getAttribute('data-description') || '';
                
                // Convert date to datetime-local format
                var dateObj = new Date(date);
                var localDate = dateObj.toISOString().slice(0, 16);
                
                // Set modal values
                document.getElementById('modalApptId').value = id;
                document.getElementById('hiddenApptId').value = id;
                document.getElementById('modalResident').value = residentName;
                document.getElementById('modalDate').value = localDate;
                document.getElementById('modalPurpose').value = purpose;
                document.getElementById('modalDescription').value = description;
                document.getElementById('modalStatus').value = status;
                
                // Set form action using proper route
                var form = document.getElementById('viewAppointmentForm');
                form.action = "{{ url('appointments_feedback/appointment') }}/" + id;
                
                // Disable all fields initially
                toggleEditMode(false);
            });
        });
        
        // Edit button functionality
        document.getElementById('modalEditBtn').addEventListener('click', function() {
            toggleEditMode(true);
        });
        
        // Function to toggle edit mode
        function toggleEditMode(enabled) {
            var fields = ['modalDate', 'modalPurpose', 'modalDescription', 'modalStatus'];
            fields.forEach(function(fieldId) {
                var field = document.getElementById(fieldId);
                if (field) {
                    field.disabled = !enabled;
                }
            });
            
            document.getElementById('modalSaveBtn').disabled = !enabled;
            document.getElementById('modalEditBtn').disabled = enabled;
        }
        
        // Close modal on save
        document.getElementById('modalSaveBtn').addEventListener('click', function() {
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('viewAppointmentModal'));
                if (modal) {
                    modal.hide();
                }
            }, 1000);
        });
        
        // Set min date/time for new appointment form
        var now = new Date();
        var year = now.getFullYear();
        var month = String(now.getMonth() + 1).padStart(2, '0');
        var day = String(now.getDate()).padStart(2, '0');
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        
        var minDateTime = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
        var addAppointmentDate = document.getElementById('addAppointmentDate');
        if (addAppointmentDate) {
            addAppointmentDate.min = minDateTime;
        }
    });
    </script>
</body>
</html>