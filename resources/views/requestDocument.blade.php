<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Document | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <style>
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="{{ url('resident_dashboard') }}">Community e-Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('resident_dashboard') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('e-serbisyo') }}">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('transparency') }}">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('community') }}">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('disasterPreparedness') }}">Disaster Preparedness</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            @if(isset($appointmentCount) && $appointmentCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $appointmentCount }}
                            </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0 notification-dropdown" aria-labelledby="notificationDropdown" style="width: 400px; max-height: 500px; overflow-y: auto;">
                            <!-- Scroll Wrapper -->
                            <div class="notif-scroll notif">
                                <li class="dropdown-header fw-bold text-white p-3" style="background: linear-gradient(135deg, #5664a0ff 0%, #764ba2 100%);">
                                    <i class="bi bi-calendar-check me-2"></i>Appointments
                                    <span class="badge bg-light text-dark ms-2">{{ $appointmentCount ?? 0 }}</span>
                                </li>

                                @if(isset($userAppointments) && count($userAppointments) > 0)
                                    @foreach($userAppointments as $appointment)
                                    <li>
                                        <!-- Remove href or change to modal trigger -->
                                        <a href="#" class="dropdown-item py-3 border-bottom view-appointment-details" 
                                        data-appointment-id="{{ $appointment->appointment_id }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#appointmentDetailsModal">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div style="flex: 1;">
                                                    <!-- Appointment Status Badge with better colors -->
                                                    @php
                                                        $badgeClass = 'bg-secondary text-white';
                                                        $statusText = $appointment->status;
                                                        if($appointment->status === 'Confirmed') {
                                                            $badgeClass = 'bg-success text-white';
                                                        } elseif($appointment->status === 'Pending') {
                                                            $badgeClass = 'bg-warning text-dark';
                                                        } elseif($appointment->status === 'Completed') {
                                                            $badgeClass = 'bg-info text-white';
                                                        } elseif($appointment->status === 'Cancelled') {
                                                            $badgeClass = 'bg-danger text-white';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }} mb-2 px-2 py-1" style="font-size: 0.75rem;">
                                                        {{ $statusText }}
                                                    </span>
                                                    
                                                    <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.95rem;">{{ $appointment->purpose }}</h6>
                                                    
                                                    @if($appointment->description)
                                                    <p class="mb-2 text-secondary" style="font-size: 0.85rem; line-height: 1.4;">
                                                        <i class="bi bi-card-text me-1"></i>
                                                        {{ Str::limit($appointment->description, 60) }}
                                                    </p>
                                                    @endif
                                                    
                                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                                        <span class="text-secondary small d-flex align-items-center">
                                                            <i class="bi bi-calendar-event me-1"></i>
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                                        </span>
                                                        <span class="text-secondary small d-flex align-items-center">
                                                            <i class="bi bi-clock me-1"></i>
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}
                                                        </span>
                                                    </div>
                                                    
                                                    @if($appointment->official_full_name)
                                                    <p class="mb-0 text-primary small d-flex align-items-center">
                                                        <i class="bi bi-person-badge me-1"></i>
                                                        {{ $appointment->official_full_name }}
                                                    </p>
                                                    @endif
                                                </div>
                                                <div class="text-muted small ms-2 text-end" style="min-width: 70px;">
                                                    @php
                                                        $now = \Carbon\Carbon::now();
                                                        $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
                                                        
                                                        if($now->gt($appointmentDate)) {
                                                            echo '<span class="badge bg-light text-dark">Past</span>';
                                                        } else {
                                                            $diffInDays = $now->diffInDays($appointmentDate);
                                                            if($diffInDays > 0) {
                                                                echo '<span class="badge bg-light text-dark">' . $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '') . '</span>';
                                                            } else {
                                                                echo '<span class="badge bg-light text-dark">Today</span>';
                                                            }
                                                        }
                                                    @endphp
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                @else
                                    <li>
                                        <div class="dropdown-item py-4 text-center text-muted">
                                            <i class="bi bi-calendar-x fs-1 mb-3" style="color: #dee2e6;"></i>
                                            <h6 class="mb-2">No appointments scheduled</h6>
                                            <p class="mb-0 small">You don't have any appointments at the moment.</p>
                                            <a href="{{ url('e-serbisyo') }}" class="btn btn-sm btn-outline-primary mt-2">Schedule One</a>
                                        </div>
                                    </li>
                                @endif
                            </div>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="{{ url('profile') }}"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Document Request Form -->
        <section class="form-section mb-5">
            <h1 class="display-5 fw-bold text-navy" id="RequestDocument">Request Document</h1>
            <p class="lead text-secondary">
                Easily request essential barangay documents online. Fill out the form below to get started.
            </p>
            
            <form action="{{ route('requestDocument.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <h4 class="text-dark fw-bold mb-3">Personal Information</h4>
                        <div class="mb-3">
                            <label for="fullName" class="form-label fw-bold text-dark">Full Name *</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="fullName" name="full_name" 
                                   value="{{ old('full_name', $resident ? $resident->first_name . ' ' . $resident->last_name : '') }}"
                                   placeholder="Enter your full name" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $resident ? $resident->email : '') }}"
                                   placeholder="Enter your email address" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label fw-bold text-dark">Contact Number *</label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                   id="contactNumber" name="contact_number" 
                                   value="{{ old('contact_number', $resident ? $resident->contact_number : '') }}"
                                   placeholder="Enter your contact number" required>
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold text-dark">Address *</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" 
                                   value="{{ old('address', $resident ? $resident->address : '') }}"
                                   placeholder="Enter your address" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h4 class="text-dark fw-bold mb-3">Document Details</h4>
                        <div class="mb-3">
                            <label for="documentType" class="form-label fw-bold text-dark">Document Type *</label>
                            <select class="form-select @error('document_type') is-invalid @enderror" 
                                    id="documentType" name="document_type" required>
                                <option value="" disabled {{ old('document_type') ? '' : 'selected' }}>Select document type</option>
                                <option value="Barangay Clearance" {{ old('document_type') == 'Barangay Clearance' ? 'selected' : '' }}>Barangay Clearance</option>
                                <option value="Certificate of Residency" {{ old('document_type') == 'Certificate of Residency' ? 'selected' : '' }}>Certificate of Residency</option>
                                <option value="Certificate of Indigency" {{ old('document_type') == 'Certificate of Indigency' ? 'selected' : '' }}>Certificate of Indigency</option>
                                <option value="Business Permit" {{ old('document_type') == 'Business Permit' ? 'selected' : '' }}>Business Permit</option>
                            </select>
                            @error('document_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="purposeOfRequest" class="form-label fw-bold text-dark">Purpose of Request *</label>
                            <input type="text" class="form-control @error('purpose') is-invalid @enderror" 
                                   id="purposeOfRequest" name="purpose" 
                                   value="{{ old('purpose') }}"
                                   placeholder="e.g., Employment, School Requirement, Business" required>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="preferredDate" class="form-label fw-bold text-dark">Preferred Pick-up Date *</label>
                            <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" 
                                   id="preferredDate" name="preferred_date" 
                                   value="{{ old('preferred_date', date('Y-m-d', strtotime('+1 day'))) }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('preferred_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="supportingDocument" class="form-label fw-bold text-dark">Upload supporting document (Optional)</label>
                            <input type="file" class="form-control @error('supporting_document') is-invalid @enderror" 
                                   id="supportingDocument" name="supporting_document">
                            <small class="text-muted">Accepted: PDF, JPG, PNG, DOC (Max: 5MB)</small>
                            @error('supporting_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>    
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text"><i class="bi bi-pin"></i> Please review your information before submitting.</p>
                                <p class="card-text fw-bold">Processing Time</p>
                                <p class="card-text"><i class="bi bi-clock"></i> 2-3 business days</p>
                                <p class="card-text">Call Us: 0926 725 1208</p>
                                <p class="card-text fw-bold">Office Hours</p>
                                <p class="card-text"><i class="bi bi-clock-history"></i> Mon-Fri: 8:00 AM - 5:00 PM</p>
                                <button type="submit" class="btn btn-primary w-100 mt-3">Submit Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <!-- Complaint Form -->
        <section class="form-section">
            <h1 class="display-5 fw-bold text-navy" id="Complaint">File a Complaint</h1>
            <p class="lead text-secondary">
                Have an issue or concern? Use the form below to file a complaint with the barangay office.
            </p>
            
            <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="complainantName" class="form-label fw-bold text-dark">Full Name *</label>
                            <input type="text" class="form-control @error('complainant_name') is-invalid @enderror" 
                                   id="complainantName" name="complainant_name" 
                                   value="{{ old('complainant_name', $resident ? $resident->first_name . ' ' . $resident->last_name : '') }}"
                                   placeholder="Enter your name" required>
                            @error('complainant_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="complainantEmail" class="form-label fw-bold text-dark">Email Address *</label>
                            <input type="email" class="form-control @error('complainant_email') is-invalid @enderror" 
                                   id="complainantEmail" name="complainant_email" 
                                   value="{{ old('complainant_email', $resident ? $resident->email : '') }}"
                                   placeholder="Enter your email" required>
                            @error('complainant_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="complainantContact" class="form-label fw-bold text-dark">Contact Number *</label>
                            <input type="text" class="form-control @error('complainant_contact') is-invalid @enderror" 
                                   id="complainantContact" name="complainant_contact" 
                                   value="{{ old('complainant_contact', $resident ? $resident->contact_number : '') }}"
                                   placeholder="Enter your contact number" required>
                            @error('complainant_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold text-dark">Subject *</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" 
                                   value="{{ old('subject') }}"
                                   placeholder="Enter the subject" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="complaintDetails" class="form-label fw-bold text-dark">Complaint Details *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="complaintDetails" name="description" rows="8" 
                                      placeholder="Describe your complaint in detail" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="complaintDocument" class="form-label fw-bold text-dark">Upload supporting document (Optional)</label>
                            <input type="file" class="form-control @error('supporting_document') is-invalid @enderror" 
                                   id="complaintDocument" name="supporting_document">
                            <small class="text-muted">Accepted: PDF, JPG, PNG, DOC (Max: 10MB)</small>
                            @error('supporting_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text"><i class="bi bi-pin"></i> Please provide accurate information for follow-up.</p>
                                <p class="card-text fw-bold">Response Time</p>
                                <p class="card-text"><i class="bi bi-clock"></i> Within 5 business days</p>
                                <p class="card-text">Call Us: 0926 725 1208</p>
                                <p class="card-text fw-bold">Office Hours</p>
                                <p class="card-text"><i class="bi bi-clock-history"></i> Mon-Fri: 8:00 AM - 5:00 PM</p>
                                <button type="submit" id="submitComplaintBtn" class="btn btn-primary w-100 mt-3">Submit Complaint</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <!-- Appointment Details Modal -->
    <div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="appointmentDetailsContent">
                    <!-- Content will be loaded via JavaScript -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading appointment details...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-auto w-100 position-relative bottom-0 start-0">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set minimum date to tomorrow
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            const formattedDate = tomorrow.toISOString().split('T')[0];
            
            const dateInput = document.getElementById('preferredDate');
            if (dateInput && !dateInput.value) {
                dateInput.value = formattedDate;
            }
        });

        // Handle appointment details modal
    document.addEventListener('DOMContentLoaded', function() {
        // When a user clicks on an appointment in the dropdown
        document.querySelectorAll('.view-appointment-details').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const appointmentId = this.getAttribute('data-appointment-id');
                loadAppointmentDetails(appointmentId);
            });
        });
        
        // Reset modal content when hidden
        const appointmentModal = document.getElementById('appointmentDetailsModal');
        appointmentModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('appointmentDetailsContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading appointment details...</p>
                </div>
            `;
        });
    });

    function loadAppointmentDetails(appointmentId) {
        // You need to create an API endpoint to get appointment details
        // For now, let's create a simple version with the data we have
        fetch(`/api/appointments/${appointmentId}/details`)
            .then(response => response.json())
            .then(data => {
                displayAppointmentDetails(data);
            })
            .catch(error => {
                console.error('Error loading appointment details:', error);
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> 
                        Error loading appointment details. Please try again.
                    </div>
                `;
            });
    }

    function displayAppointmentDetails(appointment) {
        // Format the appointment date
        const appointmentDate = new Date(appointment.appointment_date);
        const formattedDate = appointmentDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        const formattedTime = appointmentDate.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Determine badge class based on status
        let badgeClass = 'bg-secondary';
        if (appointment.status === 'Confirmed') badgeClass = 'bg-success';
        else if (appointment.status === 'Pending') badgeClass = 'bg-warning text-dark';
        else if (appointment.status === 'Completed') badgeClass = 'bg-info';
        else if (appointment.status === 'Cancelled') badgeClass = 'bg-danger';
        
        // Create HTML for appointment details
        const html = `
            <div class="appointment-details">
                <!-- Status Badge -->
                <div class="text-end mb-3">
                    <span class="badge ${badgeClass} px-3 py-2 fs-6">
                        ${appointment.status}
                    </span>
                </div>
                
                <!-- Purpose -->
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Purpose</h6>
                    <div class="p-3 bg-light rounded">
                        <h5 class="mb-0">${appointment.purpose}</h5>
                    </div>
                </div>
                
                <!-- Description -->
                ${appointment.description ? `
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Description</h6>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0">${appointment.description}</p>
                    </div>
                </div>
                ` : ''}
                
                <div class="row">
                    <!-- Date & Time -->
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2">Date & Time</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-check me-2 text-primary"></i>
                                <div>
                                    <div class="fw-bold">${formattedDate}</div>
                                    <div class="text-muted small">${formattedTime}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Official -->
                    ${appointment.official_full_name ? `
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2">Assigned Official</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge me-2 text-primary fs-4"></i>
                                <div>
                                    <div class="fw-bold">${appointment.official_full_name}</div>
                                    <div class="text-muted small">Barangay Official</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
                
                <!-- Timeline -->
                <div class="mt-4">
                    <h6 class="text-muted mb-3">Timeline</h6>
                    <div class="ps-3">
                        <div class="border-start ps-3 pb-3 position-relative">
                            <div class="position-absolute top-0 start-0 translate-middle">
                                <div class="bg-primary rounded-circle" style="width: 12px; height: 12px;"></div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-plus me-2 text-success"></i>
                                    <div>
                                        <div class="fw-bold">Created</div>
                                        <div class="text-muted small">${new Date(appointment.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 start-0 translate-middle">
                                <div class="bg-info rounded-circle" style="width: 12px; height: 12px;"></div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-clockwise me-2 text-info"></i>
                                    <div>
                                        <div class="fw-bold">Last Updated</div>
                                        <div class="text-muted small">${new Date(appointment.updated_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('appointmentDetailsContent').innerHTML = html;
    }

    // For now, let's create a simple mock API response
    // In your web.php, add this route:
    // Route::get('/api/appointments/{id}/details', [ResidentDashboardController::class, 'getAppointmentDetails']);
    </script>
</body>
</html>