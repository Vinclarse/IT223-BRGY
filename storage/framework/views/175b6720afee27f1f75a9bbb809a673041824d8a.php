<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments & Feedback | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('official_dashboard')); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manage_residents')); ?>">Manage Residents</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manage_e-serbisyo')); ?>">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?php echo e(url('transparency_records')); ?>">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(url('events_announcements')); ?>">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item active" href="<?php echo e(url('appointments_feedback')); ?>">Appointments & Feedback</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-2">
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2" title="Logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Please fix the following errors:
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <div class="container">
        <h1 class="mt-2 text-navy fw-bold">Appointments & Feedback</h1>
        <p class="lead text-secondary">Here you can manage appointments and view feedback from residents.</p>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <br>
            <button type="button" class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                <i class="bi bi-plus-circle"></i> Add New Appointment
            </button>
        </div>                
        
        <div class="mt-4">
            <h5 class="text-navy fw-bold">Appointments</h5>
            <form method="GET" action="<?php echo e(route('appointments_feedback')); ?>" class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" name="q" class="form-control" placeholder="Search by Name or Appointment ID" value="<?php echo e($q ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="" <?php echo e(empty($status) ? 'selected' : ''); ?>>Filter by Status</option>
                        <option value="Pending" <?php echo e(($status ?? '') === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="Confirmed" <?php echo e(($status ?? '') === 'Confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="Completed" <?php echo e(($status ?? '') === 'Completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="Cancelled" <?php echo e(($status ?? '') === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
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
                                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($appt->appointment_id); ?></td>
                                    <td><?php echo e($appt->resident_full_name ?? 'Unknown'); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y h:i A')); ?></td>
                                    <td><?php echo e($appt->purpose); ?></td>
                                    <td>
                                        <!-- FIXED: Using proper route for status update -->
                                        <form method="POST" action="<?php echo e(route('appointments.status', $appt->appointment_id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="Pending" <?php echo e($appt->status === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                                <option value="Confirmed" <?php echo e($appt->status === 'Confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                                                <option value="Completed" <?php echo e($appt->status === 'Completed' ? 'selected' : ''); ?>>Completed</option>
                                                <option value="Cancelled" <?php echo e($appt->status === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-link btn-sm p-0 me-2 view-appt" data-bs-toggle="modal" data-bs-target="#viewAppointmentModal"
                                            data-id="<?php echo e($appt->appointment_id); ?>"
                                            data-name="<?php echo e($appt->resident_full_name ?? 'Unknown'); ?>"
                                            data-date="<?php echo e($appt->appointment_date); ?>"
                                            data-purpose="<?php echo e($appt->purpose); ?>"
                                            data-status="<?php echo e($appt->status); ?>"
                                            data-description="<?php echo e($appt->description ?? ''); ?>"
                                        ><i class="bi bi-eye"></i></button>

                                        <!-- FIXED: Using proper route for delete -->
                                        <form method="POST" action="<?php echo e(route('appointments.destroy', $appt->appointment_id)); ?>" class="d-inline" onsubmit="return confirm('Delete this appointment?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-link btn-sm text-danger p-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No appointments found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if($appointments->hasPages()): ?>
                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($appointments->appends(request()->query())->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Feedback Section -->
            <h5 class="text-navy fw-bold mt-5">Resident Feedback</h5>
            <!-- Feedback Section -->
<h5 class="text-navy fw-bold mt-5">Resident Feedback</h5>
<?php $__empty_1 = true; $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h5 class="card-title">Feedback from <?php echo e($fb->full_name ?? 'Unknown'); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Submitted on <?php echo e(\Carbon\Carbon::parse($fb->date_submitted)->format('M d, Y')); ?>

                    </h6>
                </div>
                <div class="rating-display">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= $fb->rating): ?>
                            <i class="bi bi-star-fill text-warning"></i>
                        <?php else: ?>
                            <i class="bi bi-star text-secondary"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <small class="text-muted ms-1">(<?php echo e($fb->rating); ?>/5)</small>
                </div>
            </div>
            <p class="card-text"><?php echo e($fb->message); ?></p>
            <!-- FIXED: Using proper route for feedback delete -->
            <form method="POST" action="<?php echo e(route('feedback.destroy', $fb->feedback_id)); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Delete this feedback?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="card mt-3 mb-5">
        <div class="card-body text-center text-muted">
            <i class="bi bi-chat-square-text"></i> No feedback found.
        </div>
    </div>
    <?php endif; ?>
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
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
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
                <form method="POST" action="<?php echo e(route('appointments.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addResident" class="form-label">Select Resident *</label>
                            <select class="form-control" id="addResident" name="resident_id" required>
                                <option value="">Select a Resident</option>
                                <?php $__currentLoopData = $residents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($resident->resident_id); ?>">
                                        <?php echo e($resident->first_name); ?> <?php echo e($resident->last_name); ?> 
                                        (<?php echo e($resident->email ?? 'No email'); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <input type="hidden" name="official_id" value="<?php echo e(session('user.official_id')); ?>">
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
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
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
                form.action = "<?php echo e(url('appointments_feedback/appointment')); ?>/" + id;
                
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
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/appointments_feedback.blade.php ENDPATH**/ ?>