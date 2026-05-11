<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Preparedness | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('frontend/style.css')); ?>">
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('resident_dashboard')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('about')); ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('e-serbisyo')); ?>">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('transparency')); ?>">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('community')); ?>">Community</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('disasterPreparedness')); ?>">Disaster Preparedness</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            <?php if(isset($appointmentCount) && $appointmentCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                <?php echo e($appointmentCount); ?>

                            </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0 notification-dropdown" aria-labelledby="notificationDropdown" style="width: 400px; max-height: 500px; overflow-y: auto;">
                            <!-- Scroll Wrapper -->
                            <div class="notif-scroll notif">
                                <li class="dropdown-header fw-bold text-white p-3" style="background: linear-gradient(135deg, #5664a0ff 0%, #764ba2 100%);">
                                    <i class="bi bi-calendar-check me-2"></i>Appointments
                                    <span class="badge bg-light text-dark ms-2"><?php echo e($appointmentCount ?? 0); ?></span>
                                </li>

                                <?php if(isset($userAppointments) && count($userAppointments) > 0): ?>
                                    <?php $__currentLoopData = $userAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <!-- Remove href or change to modal trigger -->
                                        <a href="#" class="dropdown-item py-3 border-bottom view-appointment-details" 
                                        data-appointment-id="<?php echo e($appointment->appointment_id); ?>"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#appointmentDetailsModal">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div style="flex: 1;">
                                                    <!-- Appointment Status Badge with better colors -->
                                                    <?php
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
                                                    ?>
                                                    <span class="badge <?php echo e($badgeClass); ?> mb-2 px-2 py-1" style="font-size: 0.75rem;">
                                                        <?php echo e($statusText); ?>

                                                    </span>
                                                    
                                                    <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.95rem;"><?php echo e($appointment->purpose); ?></h6>
                                                    
                                                    <?php if($appointment->description): ?>
                                                    <p class="mb-2 text-secondary" style="font-size: 0.85rem; line-height: 1.4;">
                                                        <i class="bi bi-card-text me-1"></i>
                                                        <?php echo e(Str::limit($appointment->description, 60)); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                    
                                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                                        <span class="text-secondary small d-flex align-items-center">
                                                            <i class="bi bi-calendar-event me-1"></i>
                                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?>

                                                        </span>
                                                        <span class="text-secondary small d-flex align-items-center">
                                                            <i class="bi bi-clock me-1"></i>
                                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A')); ?>

                                                        </span>
                                                    </div>
                                                    
                                                    <?php if($appointment->official_full_name): ?>
                                                    <p class="mb-0 text-primary small d-flex align-items-center">
                                                        <i class="bi bi-person-badge me-1"></i>
                                                        <?php echo e($appointment->official_full_name); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-muted small ms-2 text-end" style="min-width: 70px;">
                                                    <?php
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
                                                    ?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <li>
                                        <div class="dropdown-item py-4 text-center text-muted">
                                            <i class="bi bi-calendar-x fs-1 mb-3" style="color: #dee2e6;"></i>
                                            <h6 class="mb-2">No appointments scheduled</h6>
                                            <p class="mb-0 small">You don't have any appointments at the moment.</p>
                                            <a href="<?php echo e(url('e-serbisyo')); ?>" class="btn btn-sm btn-outline-primary mt-2">Schedule One</a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </div>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="<?php echo e(url('profile')); ?>"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <header class="container mb-4 text-center">
        <h1 class="display-5 fw-bold text-navy">Disaster Preparedness</h1>
        <p class="lead text-secondary">
            Stay informed and prepared for emergencies. Learn about disaster response plans, evacuation routes, and safety tips to protect your family and community.
        </p>
        <a href="#resources" class="btn btn-outline-navy btn-lg mt-3">Explore Resources</a>
    </header>

    <!-- Disaster Preparedness Resources Section -->
    <section class="container mb-5" id="resources">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-navy">Preparedness Resources</h2>
                <p class="text-secondary">Access essential resources to stay safe and prepared during disasters.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy"><i class="bi bi-map"></i> Evacuation Maps</h5>
                        <p class="card-text text-secondary">Find the nearest evacuation centers and safe zones in your area.</p>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mapsModal">View Maps</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy"><i class="bi bi-telephone"></i> Emergency Hotlines</h5>
                        <p class="card-text text-secondary">Save important contact numbers for quick assistance during emergencies.</p>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#hotlinesModal">View Hotlines</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Safety Tips Section -->
    <section class="container mb-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-navy">Safety Tips</h2>
                <p class="text-secondary">Follow these tips to stay safe during disasters and emergencies.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-house-door"></i></div>
                    <h5 class="fw-bold">Prepare Your Home</h5>
                    <p class="text-secondary">Secure loose items, stock emergency supplies, and create a family emergency plan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-people"></i></div>
                    <h5 class="fw-bold">Stay Informed</h5>
                    <p class="text-secondary">Monitor weather updates and announcements from local authorities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-broadcast"></i></div>
                    <h5 class="fw-bold">Follow Instructions</h5>
                    <p class="text-secondary">Evacuate when advised and cooperate with disaster response teams.</p>
                </div>
            </div>
        </div>
    </section>

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
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Hotlines Modal -->
    <div class="modal fade" id="hotlinesModal" tabindex="-1" aria-labelledby="hotlinesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-navy fw-bold" id="hotlinesModalLabel">Emergency Hotlines & Resources</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">Keep these numbers handy. Call the appropriate service during emergencies and follow instructions from responders.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-navy">Emergency Services</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Police:</strong> 911 / (02) 1234-5678</li>
                                    <li><strong>Fire Department:</strong> 911 / (02) 2345-6789</li>
                                    <li><strong>Ambulance:</strong> 911 / (02) 3456-7890</li>
                                    <li><strong>Barangay Office:</strong> (02) 4567-8901</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-navy">Health & Support</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Municipal Health:</strong> (02) 5678-9012</li>
                                    <li><strong>Disaster Hotline:</strong> 1-800-000-000</li>
                                    <li><strong>Red Cross:</strong> (02) 6789-0123</li>
                                </ul>
                            </div>
                        </div>

                        <hr>
                        <h6 class="fw-bold text-navy">Quick Guidance</h6>
                        <ol>
                            <li>Stay calm and account for household members.</li>
                            <li>Move to the nearest evacuation center if advised.</li>
                            <li>Do not use open flames in areas with gas leaks.</li>
                            <li>Follow official updates via radio, social media, or barangay announcements.</li>
                        </ol>

                        <hr>
                        <h6 class="fw-bold text-navy">Evacuation Centers</h6>
                        <p class="text-secondary">Barangay Covered Court — Main Street; Elementary School Gym — North Road; Community Hall — Barangay Center.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Evacuation Maps Modal -->
        <div class="modal fade" id="mapsModal" tabindex="-1" aria-labelledby="mapsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-navy fw-bold" id="mapsModalLabel">Evacuation Maps</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">Below are the barangay evacuation maps showing safe zones and evacuation center locations. Use the download links to save a copy for offline use.</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="https://tse4.mm.bing.net/th/id/OIP.jlycdmkRt3D2eHSdY7rMdgHaFS?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top" alt="Evacuation Map Zone A">
                                    <span class="badge bg-secondary" style="font-size: 10px;">
                                    Last Updated: 2023-08-01 | Uploaded by: Admin Jose Ramirez
                                    </span>
                                    <div class="card-body">
                                        <h6 class="card-title">Evacuation Map for Earthquake</h6>
                                        <p class="card-text text-secondary small">Shows nearest evacuation centers and designated routes for Earthquake</p>                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="https://th.bing.com/th/id/R.3bc0e5daf31d64268d3eda9fabc80a4d?rik=RVUFpqf7wLHXIQ&riu=http%3a%2f%2flgustamonica.gov.ph%2fwp-content%2fuploads%2f2022%2f11%2fLIBERTAD-1-1024x724.jpg&ehk=7D2q5t%2b%2fFlsNkD%2bNNdlfkSxq8n8pxLuecBtmNnNUMsI%3d&risl=&pid=ImgRaw&r=0" class="card-img-top" alt="Evacuation Map Zone B">
                                    <span class="badge bg-secondary" style="font-size: 10px;">
                                        Last Updated: 2023-07-15 | Uploaded by: Sec. Maria Santos
                                    </span>
                                    <div class="card-body">
                                        <h6 class="card-title">Evacuation Map for Flood</h6>
                                        <p class="card-text text-secondary small">Shows nearest evacuation centers and designated routes for Flood.</p>                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-secondary small"><strong>Tip:</strong> Save these maps to your phone or print them and keep them with your emergency kit.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Disaster Response Plans Modal -->
        <div class="modal fade" id="plansModal" tabindex="-1" aria-labelledby="plansModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-navy fw-bold" id="plansModalLabel">Disaster Response Plans</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">The barangay has prepared the following response plans. Download the PDF copies for offline reference and share them with your household.</p>
                        <div class="list-group mb-3">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">Earthquake Response Plan</h6>
                                    <small class="text-secondary">Updated: 2024-02-10</small>
                                </div>
                                <p class="mb-1 text-secondary small">Guidance for immediate actions during and after an earthquake, including evacuation, first aid, and reporting.</p>
                                <div class="mt-1">
                                    <a href="#" class="btn btn-sm btn-outline-navy me-2" download>Download PDF</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Online</a>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold mt-3">Flood Response Plan</h6>
                                    <small class="text-secondary">Updated: 2023-11-05</small>
                                </div>
                                <p class="mb-1 text-secondary small">Procedures for early warning, safe evacuation routes, and temporary shelter operations during floods.</p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-navy me-2" download>Download PDF</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Online</a>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold mt-3">Fire & Chemical Incident Plan</h6>
                                    <small class="text-secondary">Updated: 2023-06-20</small>
                                </div>
                                <p class="mb-1 text-secondary small">Safety procedures for fire response, evacuation, and coordination with municipal services.</p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-navy me-2" download>Download PDF</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Online</a>
                                </div>
                            </a>
                        </div>
                        <hr>
                        <h6 class="fw-bold text-navy">How to use these plans</h6>
                        <ol>
                            <li class="text-secondary">Download the relevant plan and read it with your family.</li>
                            <li class="text-secondary">Prepare a household kit as described in the checklists.</li>
                            <li class="text-secondary">Familiarize yourselves with the nearest evacuation center and routes on the evacuation maps.</li>
                            <li class="text-secondary">Register vulnerable household members with the barangay health officer.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

        <script>
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
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/disasterPreparedness.blade.php ENDPATH**/ ?>