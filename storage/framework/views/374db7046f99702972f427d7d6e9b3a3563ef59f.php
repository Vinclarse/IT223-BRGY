<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Document | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/style.css')); ?>">
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
            <a class="navbar-brand fw-bold ms-4" href="<?php echo e(url('resident_dashboard')); ?>">Community e-Portal</a>
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

    <main class="container mb-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Document Request Form -->
        <section class="form-section mb-5">
            <h1 class="display-5 fw-bold text-navy" id="RequestDocument">Request Document</h1>
            <p class="lead text-secondary">
                Easily request essential barangay documents online. Fill out the form below to get started.
            </p>
            
            <form action="<?php echo e(route('requestDocument.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-5">
                        <h4 class="text-dark fw-bold mb-3">Personal Information</h4>
                        <div class="mb-3">
                            <label for="fullName" class="form-label fw-bold text-dark">Full Name *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="fullName" name="full_name" 
                                   value="<?php echo e(old('full_name', $resident ? $resident->first_name . ' ' . $resident->last_name : '')); ?>"
                                   placeholder="Enter your full name" required>
                            <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark">Email Address *</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" name="email" 
                                   value="<?php echo e(old('email', $resident ? $resident->email : '')); ?>"
                                   placeholder="Enter your email address" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label fw-bold text-dark">Contact Number *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="contactNumber" name="contact_number" 
                                   value="<?php echo e(old('contact_number', $resident ? $resident->contact_number : '')); ?>"
                                   placeholder="Enter your contact number" required>
                            <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold text-dark">Address *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="address" name="address" 
                                   value="<?php echo e(old('address', $resident ? $resident->address : '')); ?>"
                                   placeholder="Enter your address" required>
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h4 class="text-dark fw-bold mb-3">Document Details</h4>
                        <div class="mb-3">
                            <label for="documentType" class="form-label fw-bold text-dark">Document Type *</label>
                            <select class="form-select <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="documentType" name="document_type" required>
                                <option value="" disabled <?php echo e(old('document_type') ? '' : 'selected'); ?>>Select document type</option>
                                <option value="Barangay Clearance" <?php echo e(old('document_type') == 'Barangay Clearance' ? 'selected' : ''); ?>>Barangay Clearance</option>
                                <option value="Certificate of Residency" <?php echo e(old('document_type') == 'Certificate of Residency' ? 'selected' : ''); ?>>Certificate of Residency</option>
                                <option value="Certificate of Indigency" <?php echo e(old('document_type') == 'Certificate of Indigency' ? 'selected' : ''); ?>>Certificate of Indigency</option>
                                <option value="Business Permit" <?php echo e(old('document_type') == 'Business Permit' ? 'selected' : ''); ?>>Business Permit</option>
                            </select>
                            <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="purposeOfRequest" class="form-label fw-bold text-dark">Purpose of Request *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="purposeOfRequest" name="purpose" 
                                   value="<?php echo e(old('purpose')); ?>"
                                   placeholder="e.g., Employment, School Requirement, Business" required>
                            <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="preferredDate" class="form-label fw-bold text-dark">Preferred Pick-up Date *</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['preferred_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="preferredDate" name="preferred_date" 
                                   value="<?php echo e(old('preferred_date', date('Y-m-d', strtotime('+1 day')))); ?>" 
                                   min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                            <?php $__errorArgs = ['preferred_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="supportingDocument" class="form-label fw-bold text-dark">Upload supporting document (Optional)</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['supporting_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="supportingDocument" name="supporting_document">
                            <small class="text-muted">Accepted: PDF, JPG, PNG, DOC (Max: 5MB)</small>
                            <?php $__errorArgs = ['supporting_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
            
            <form action="<?php echo e(route('complaint.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="complainantName" class="form-label fw-bold text-dark">Full Name *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['complainant_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="complainantName" name="complainant_name" 
                                   value="<?php echo e(old('complainant_name', $resident ? $resident->first_name . ' ' . $resident->last_name : '')); ?>"
                                   placeholder="Enter your name" required>
                            <?php $__errorArgs = ['complainant_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="complainantEmail" class="form-label fw-bold text-dark">Email Address *</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['complainant_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="complainantEmail" name="complainant_email" 
                                   value="<?php echo e(old('complainant_email', $resident ? $resident->email : '')); ?>"
                                   placeholder="Enter your email" required>
                            <?php $__errorArgs = ['complainant_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="complainantContact" class="form-label fw-bold text-dark">Contact Number *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['complainant_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="complainantContact" name="complainant_contact" 
                                   value="<?php echo e(old('complainant_contact', $resident ? $resident->contact_number : '')); ?>"
                                   placeholder="Enter your contact number" required>
                            <?php $__errorArgs = ['complainant_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold text-dark">Subject *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="subject" name="subject" 
                                   value="<?php echo e(old('subject')); ?>"
                                   placeholder="Enter the subject" required>
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="complaintDetails" class="form-label fw-bold text-dark">Complaint Details *</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="complaintDetails" name="description" rows="8" 
                                      placeholder="Describe your complaint in detail" required><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="complaintDocument" class="form-label fw-bold text-dark">Upload supporting document (Optional)</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['supporting_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="complaintDocument" name="supporting_document">
                            <small class="text-muted">Accepted: PDF, JPG, PNG, DOC (Max: 10MB)</small>
                            <?php $__errorArgs = ['supporting_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
    </script>
</body>
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/requestDocument.blade.php ENDPATH**/ ?>