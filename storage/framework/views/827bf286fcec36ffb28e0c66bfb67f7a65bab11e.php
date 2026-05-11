<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Community e-Portal</title>
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
                    <?php if($user['role'] === 'Resident'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(url('resident_dashboard')); ?>">Home</a></li>
                    <?php elseif($user['role'] === 'Official'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(url('official_dashboard')); ?>">Home</a></li>
                    <?php elseif($user['role'] === 'Admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(url('admin_dashboard')); ?>">Home</a></li>
                    <?php endif; ?>
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
                    <a href="<?php echo e(url('profile')); ?>"><i class="bi bi-person-circle fs-2 person text-white"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <header class="container mb-4 text-center">
        <h1 class="display-1 fw-bold text-navy"><i class="bi bi-person-circle"></i></h1>
        
        <!-- Display user's full name -->
        <h1 class="display-5 fw-bold text-navy">
            <?php if($userData): ?>
                <?php if($user['role'] === 'Resident' || $user['role'] === 'Official'): ?>
                    <?php echo e($userData->first_name ?? ''); ?> 
                    <?php echo e($userData->middle_name ? ' ' . $userData->middle_name . ' ' : ' '); ?> 
                    <?php echo e($userData->last_name ?? ''); ?>

                <?php elseif($user['role'] === 'Admin'): ?>
                    Administrator
                <?php endif; ?>
            <?php else: ?>
                User Profile
            <?php endif; ?>
        </h1>
        
        <p class="lead text-secondary">
            View and manage your profile information.
            <span class="badge bg-info"><?php echo e($user['role'] ?? 'Guest'); ?></span>
        </p>
        
        <div class="container text-center">
            <?php if(!$editMode): ?>
                <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-navy mb-4">
                    <i class="bi bi-pencil-square"></i> Edit Profile
                </a>
                <button type="button" class="btn btn-outline-navy mb-4 ms-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-key"></i> Change Password
                </button>
            <?php elseif($editMode): ?>
                <a href="<?php echo e(route('profile')); ?>" class="btn btn-outline-secondary mb-4">
                    <i class="bi bi-x-circle"></i> Cancel Edit
                </a>
            <?php endif; ?>
            
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-navy mb-4 ms-3">Log out</button>
            </form>
        </div>
    </header>
    
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
    <div class="container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>
    
    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title text-navy mb-4">
                            <i class="bi bi-person-lines-fill"></i> Profile Information
                        </h5>
                        
                        <?php if($userData): ?>
                        <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- SEPARATE NAME FIELDS - Arranged side by side in a row -->
                                    <?php if($user['role'] === 'Resident' || $user['role'] === 'Official'): ?>
                                        <?php if(!$editMode): ?>
                                        <!-- View Mode - Name fields in a row -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">First Name</label>
                                                <input type="text" class="form-control" 
                                                    value="<?php echo e($userData->first_name ?? ''); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Middle Name</label>
                                                <input type="text" class="form-control" 
                                                    value="<?php echo e($userData->middle_name ?? ''); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Last Name</label>
                                                <input type="text" class="form-control" 
                                                    value="<?php echo e($userData->last_name ?? ''); ?>" readonly>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <!-- Edit Mode - Name fields in a row -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="first_name" class="form-label fw-bold">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                                    value="<?php echo e(old('first_name', $userData->first_name ?? '')); ?>">
                                                <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="middle_name" class="form-label fw-bold">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name" 
                                                    value="<?php echo e(old('middle_name', $userData->middle_name ?? '')); ?>">
                                                <?php $__errorArgs = ['middle_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="last_name" class="form-label fw-bold">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                                    value="<?php echo e(old('last_name', $userData->last_name ?? '')); ?>">
                                                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <!-- Email Field -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <?php if($user['role'] === 'Admin' && $editMode): ?>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                value="<?php echo e(old('email', $userAccount->email ?? '')); ?>">
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php else: ?>
                                            <input type="email" class="form-control" id="email" 
                                                value="<?php echo e($userAccount->email ?? 'Not available'); ?>" readonly>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Resident-specific fields -->
                                    <?php if($user['role'] === 'Resident'): ?>
                                        <?php if(!$editMode): ?>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Birth Date</label>
                                                <input type="text" class="form-control" 
                                                    value="<?php echo e($userData->birth_date ? \Carbon\Carbon::parse($userData->birth_date)->format('F d, Y') : 'Not specified'); ?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Gender</label>
                                                <input type="text" class="form-control" 
                                                    value="<?php echo e($userData->sex ?? 'Not specified'); ?>" readonly>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <!-- Edit mode for resident - Birth Date and Gender side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="birth_date" class="form-label fw-bold">Birth Date</label>
                                                <input type="date" class="form-control" id="birth_date" name="birth_date" 
                                                    value="<?php echo e(old('birth_date', $userData->birth_date ?? '')); ?>">
                                                <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sex" class="form-label fw-bold">Gender</label>
                                                <select class="form-control" id="sex" name="sex">
                                                    <option value="Male" <?php echo e((old('sex', $userData->sex ?? '') == 'Male') ? 'selected' : ''); ?>>Male</option>
                                                    <option value="Female" <?php echo e((old('sex', $userData->sex ?? '') == 'Female') ? 'selected' : ''); ?>>Female</option>
                                                </select>
                                                <?php $__errorArgs = ['sex'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Contact Number -->
                                    <?php if(($user['role'] === 'Resident' || $user['role'] === 'Official') && isset($userData->contact_number)): ?>
                                    <div class="mb-3">
                                        <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" 
                                            value="<?php echo e(old('contact_number', $userData->contact_number ?? '')); ?>" 
                                            <?php echo e($editMode ? '' : 'readonly'); ?>>
                                        <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Address -->
                                    <?php if(($user['role'] === 'Resident' || $user['role'] === 'Official') && isset($userData->address)): ?>
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" 
                                            <?php echo e($editMode ? '' : 'readonly'); ?>><?php echo e(old('address', $userData->address ?? '')); ?></textarea>
                                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Position (Official only) -->
                                    <?php if($user['role'] === 'Official'): ?>
                                    <div class="mb-3">
                                        <label for="position" class="form-label fw-bold">Position</label>
                                        <?php if($editMode): ?>
                                            <input type="text" class="form-control" id="position" name="position" 
                                                value="<?php echo e(old('position', $userData->position ?? '')); ?>">
                                            <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php else: ?>
                                            <input type="text" class="form-control" id="position" 
                                                value="<?php echo e($userData->position ?? 'Barangay Official'); ?>" readonly>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Status fields (readonly) -->
                                    <?php if($user['role'] === 'Resident'): ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Verification Status</label>
                                        <?php
                                            $statusClass = 'bg-secondary';
                                            if($userData->status === 'Verified') {
                                                $statusClass = 'bg-success';
                                            } elseif($userData->status === 'Pending') {
                                                $statusClass = 'bg-warning';
                                            } elseif($userData->status === 'Rejected') {
                                                $statusClass = 'bg-danger';
                                            }
                                        ?>
                                        <span class="badge <?php echo e($statusClass); ?> p-2 d-block text-center">
                                            <?php echo e($userData->status ?? 'Unknown'); ?>

                                        </span>
                                        <small class="text-muted">Status cannot be changed by user.</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Date Registered</label>
                                        <input type="text" class="form-control" 
                                            value="<?php echo e($userData->date_registered ? \Carbon\Carbon::parse($userData->date_registered)->format('F d, Y') : 'Not specified'); ?>" readonly>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($user['role'] === 'Admin'): ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Account Status</label>
                                        <?php
                                            $statusClass = 'bg-secondary';
                                            if($userAccount->status === 'Active') {
                                                $statusClass = 'bg-success';
                                            } elseif($userAccount->status === 'Inactive') {
                                                $statusClass = 'bg-danger';
                                            }
                                        ?>
                                        <span class="badge <?php echo e($statusClass); ?> p-2 d-block text-center">
                                            <?php echo e($userAccount->status ?? 'Unknown'); ?>

                                        </span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Account Created</label>
                                        <input type="text" class="form-control" 
                                            value="<?php echo e($userAccount->date_created ? \Carbon\Carbon::parse($userAccount->date_created)->format('F d, Y') : 'Not specified'); ?>" readonly>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Save/Cancel buttons -->
                                    <?php if($editMode): ?>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-navy">
                                            <i class="bi bi-check-circle"></i> Save Changes
                                        </button>
                                        <a href="<?php echo e(route('profile')); ?>" class="btn btn-outline-secondary ms-2">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> 
                            <?php if($user['role'] === 'Resident'): ?>
                                Resident profile data not found.
                            <?php elseif($user['role'] === 'Official'): ?>
                                Official profile data not found.
                            <?php else: ?>
                                Profile data not found.
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-navy" id="changePasswordModalLabel">
                        <i class="bi bi-key"></i> Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('profile.change-password')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                    <label for="currentPassword" class="form-label fw-bold">Current Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="newPassword" class="form-label fw-bold">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label fw-bold">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-navy">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.addEventListener("DOMContentLoaded", function () {
            // Function to toggle password visibility
            function setupPasswordToggle(inputId, buttonId) {
                const passwordInput = document.getElementById(inputId);
                const toggleButton = document.getElementById(buttonId);
                
                if (passwordInput && toggleButton) {
                    toggleButton.addEventListener('click', function () {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        
                        const icon = toggleButton.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('bi-eye');
                            icon.classList.toggle('bi-eye-slash');
                        }
                    });
                }
            }
            
            // Set up all password toggles
            setupPasswordToggle("currentPassword", "toggleCurrentPassword");
            setupPasswordToggle("newPassword", "toggleNewPassword");
            setupPasswordToggle("confirmPassword", "toggleConfirmPassword");
        });
        
        // Show password change errors in modal
        <?php if($errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                changePasswordModal.show();
            });
        <?php endif; ?>

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
</html><?php /**PATH C:\Main Main file\resources\views/profile.blade.php ENDPATH**/ ?>