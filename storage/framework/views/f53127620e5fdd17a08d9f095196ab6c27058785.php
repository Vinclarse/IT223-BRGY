<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Community e-Portal</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('admin_dashboard')); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manageusers_admin')); ?>">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('website_management')); ?>">Website Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('system_settings')); ?>">System Settings</a></li>
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
    
    <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="text-navy fw-bold mb-1">Admin Dashboard</h1>
                <p class="text-muted mb-0">Welcome back! Manage your community portal system.</p>
            </div>
            <div class="text-end">
                <span class="text-muted small"><?php echo e(now()->format('l, F d, Y')); ?></span>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Officials -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-2">Total Officials</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalOfficials ?? 0); ?></h2>
                                <small class="text-muted">Barangay officials</small>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-person-badge fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="<?php echo e(url('manageusers_admin')); ?>" class="text-decoration-none small">
                            Manage users <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Residents -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-2">Total Residents</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalResidents ?? 0); ?></h2>
                                <small class="text-muted">Registered residents</small>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people fs-4 text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="<?php echo e(url('manageusers_admin')); ?>" class="text-decoration-none small">
                            View all users <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Complaints -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-2">Total Complaints</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalComplaints ?? 0); ?></h2>
                                <small class="text-muted">Filed complaints</small>
                            </div>
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="#" class="text-decoration-none small">
                            View complaints <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Announcements -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-2">Announcements</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalAnnouncements ?? 0); ?></h2>
                                <small class="text-muted">Posted announcements</small>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-megaphone fs-4 text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a href="<?php echo e(url('website_management')); ?>" class="text-decoration-none small">
                            Manage content <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check text-warning fs-1 mb-2"></i>
                        <h3 class="fw-bold mb-1"><?php echo e($dashboardStats['pendingResidents'] ?? 0); ?></h3>
                        <p class="text-muted mb-0 small">Pending resident verification</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-dash text-danger fs-1 mb-2"></i>
                        <h3 class="fw-bold mb-1"><?php echo e($dashboardStats['inactiveUsers'] ?? 0); ?></h3>
                        <p class="text-muted mb-0 small">Inactive user accounts</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-text text-info fs-1 mb-2"></i>
                        <h3 class="fw-bold mb-1"><?php echo e($dashboardStats['logsToday'] ?? 0); ?></h3>
                        <p class="text-muted mb-0 small">Audit logs today</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check text-success fs-1 mb-2"></i>
                        <h3 class="fw-bold mb-1"><?php echo e($dashboardStats['activeAdmins'] ?? 0); ?></h3>
                        <p class="text-muted mb-0 small">Active admin accounts</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 pb-2">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="<?php echo e(url('manageusers_admin')); ?>" class="btn btn-outline-primary w-100 py-3">
                                    <i class="bi bi-people fs-4 d-block mb-2"></i>
                                    Manage Users
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?php echo e(url('website_management')); ?>" class="btn btn-outline-info w-100 py-3">
                                    <i class="bi bi-globe fs-4 d-block mb-2"></i>
                                    Website Management
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?php echo e(url('system_settings')); ?>" class="btn btn-outline-success w-100 py-3">
                                    <i class="bi bi-gear fs-4 d-block mb-2"></i>
                                    System Settings
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-secondary w-100 py-3">
                                    <i class="bi bi-graph-up fs-4 d-block mb-2"></i>
                                    View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Activities</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $action = $activity->action ?? 'Activity logged';
                                    $timestamp = $activity->timestamps ?? null;
                                    $timeAgo = $timestamp ? \Carbon\Carbon::parse($timestamp)->diffForHumans() : 'N/A';
                                    $actionLower = strtolower($action);
                                    $icon = 'bi-activity';
                                    $color = 'primary';
                                    if (str_contains($actionLower, 'login') || str_contains($actionLower, 'auth')) {
                                        $icon = 'bi-door-open';
                                        $color = 'success';
                                    } elseif (str_contains($actionLower, 'delete') || str_contains($actionLower, 'remove')) {
                                        $icon = 'bi-trash';
                                        $color = 'danger';
                                    } elseif (str_contains($actionLower, 'update') || str_contains($actionLower, 'edit') || str_contains($actionLower, 'change')) {
                                        $icon = 'bi-pencil-square';
                                        $color = 'info';
                                    }
                                ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="bg-<?php echo e($color); ?> bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi <?php echo e($icon); ?> text-<?php echo e($color); ?>"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($action); ?></h6>
                                                    <small class="text-muted"><?php echo e($timeAgo); ?></small>
                                                    <small class="text-muted d-block">User: <?php echo e($activity->user_id ?? 'N/A'); ?> • IP: <?php echo e($activity->id_address ?? 'N/A'); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center text-muted py-4">
                                    No recent activities recorded.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>System Overview</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Database Status</span>
                                <span class="badge bg-<?php echo e($dashboardStats['dbStatus']['badge'] ?? 'secondary'); ?>">
                                    <?php echo e($dashboardStats['dbStatus']['label'] ?? 'Unknown'); ?>

                                </span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-<?php echo e($dashboardStats['dbStatus']['badge'] ?? 'secondary'); ?>" role="progressbar" style="width: <?php echo e(($dashboardStats['dbStatus']['label'] ?? '') === 'Connected' ? 100 : 25); ?>%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Open Complaints</span>
                                <span class="badge bg-warning text-dark"><?php echo e($dashboardStats['openComplaints'] ?? 0); ?></span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e(min(100, ($dashboardStats['openComplaints'] ?? 0) * 5)); ?>%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Server Load</span>
                                <span class="badge bg-info"><?php echo e($dashboardStats['serverLoadPercent'] ?? 0); ?>%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($dashboardStats['serverLoadPercent'] ?? 0); ?>%"></div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="fw-bold mb-3">Quick Stats</h6>
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h4 class="fw-bold mb-0 text-primary"><?php echo e(($totalOfficials ?? 0) + ($totalResidents ?? 0)); ?></h4>
                                        <small class="text-muted">Total Users</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h4 class="fw-bold mb-0 text-danger"><?php echo e($dashboardStats['openComplaints'] ?? 0); ?></h4>
                                        <small class="text-muted">Open Complaints</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/admin_dashboard.blade.php ENDPATH**/ ?>