<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparency | Community e-Portal</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('transparency')); ?>">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('community')); ?>">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('disasterPreparedness')); ?>">Disaster Preparedness</a></li>
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
                                <li class="dropdown-header fw-bold text-white p-3" style="background-color: #0b3d91;">
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
                                                    
                                                    <h6 class="mb-1 text-navy fw-bold" style="font-size: 0.95rem;"><?php echo e($appointment->purpose); ?></h6>
                                                    
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
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </div>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="<?php echo e(('profile')); ?>"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <header class="container mb-4 text-center">
        <h1 class="display-5 fw-bold text-navy">Transparency in Barangay Services</h1>
        <p class="lead text-secondary">
            We are committed to transparency and accountability in our services. Explore financial reports, project updates, and community engagement initiatives.
        </p>
        <button class="btn btn-outline-navy btn-lg mt-3" onclick="scrollToSection()">Learn More</button>
    </header>

    <section class="container mb-5" id="transparency-section">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <h3 class="fw-bold text-navy mb-4 text-center">
                    Transparency Reports
                </h3>

                <div class="row g-4">

                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0">

                                <!-- CARD HEADER -->
                                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">

                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-building text-primary"></i>
                                        <small class="text-muted">
                                            <?php echo e(\Carbon\Carbon::parse($report->report_date)->format('M d, Y')); ?>

                                        </small>
                                    </div>

                                    <span class="badge
                                        <?php if($report->category == 'Financial'): ?> bg-success
                                        <?php elseif($report->category == 'Project'): ?> bg-warning text-dark
                                        <?php elseif($report->category == 'Community'): ?> bg-info
                                        <?php else: ?> bg-secondary
                                        <?php endif; ?>
                                    ">
                                        <?php echo e($report->category); ?>

                                    </span>

                                </div>

                                <!-- CARD BODY -->
                                <div class="card-body">

                                    <h6 class="fw-bold text-navy mb-2">
                                        <?php echo e($report->title); ?>

                                    </h6>

                                    <p class="text-secondary small" style="line-height: 1.6;">
                                        <?php echo e($report->description); ?>

                                    </p>

                                </div>

                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <div class="col-12 text-center py-5">
                            <i class="bi bi-folder2-open fs-1 text-muted mb-3"></i>
                            <p class="text-muted fs-5">
                                No transparency reports available at the moment.
                            </p>
                        </div>

                    <?php endif; ?>

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

    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script>
        function scrollToSection() {
            document.getElementById('transparency-section').scrollIntoView({ behavior: 'smooth' });
        }

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/transparency.blade.php ENDPATH**/ ?>