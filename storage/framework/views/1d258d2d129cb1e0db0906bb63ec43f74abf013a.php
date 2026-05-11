<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage e-Services | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('manage_e-serbisyo')); ?>">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" style="background-color: #0b3d91; !important;">
                            <li><a class="dropdown-item" href="<?php echo e(url('transparency_records')); ?>">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(url('events_announcements')); ?>">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(url('appointments_feedback')); ?>">Appointments & Feedback</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="#" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>
                    </li>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success mt-3"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger mt-3"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mt-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(!request()->is('*/complaints') ? 'active' : ''); ?>" href="<?php echo e(route('manage_e-serbisyo')); ?><?php echo e($q || $status ? '?q=' . urlencode($q) . '&status=' . urlencode($status) : ''); ?>">
                    Document Requests
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo e(request()->is('*/complaints') ? 'active' : ''); ?>" href="<?php echo e(route('manage_e-serbisyo.complaints')); ?><?php echo e($q || $status ? '?q=' . urlencode($q) . '&status=' . urlencode($status) : ''); ?>">
                    Complaints
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Document Requests Tab -->
            <?php if(!request()->is('*/complaints')): ?>
            <div class="tab-pane fade show active" role="tabpanel">
                <h1 class="mt-4 text-navy fw-bold">Manage e-Services</h1>
                <p class="lead text-secondary">Here you can manage e-Service requests from residents.</p>
                <div class="mt-4">
                    <h5 class="mb-3 text-navy fw-bold">Document Requests</h5>
                    <form method="GET" action="<?php echo e(route('manage_e-serbisyo')); ?>" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search by Name or Request ID" value="<?php echo e($q ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Filter by Status</option>
                                <option value="Pending" <?php echo e(($status ?? '') === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="In Progress" <?php echo e(($status ?? '') === 'In Progress' ? 'selected' : ''); ?>>In Progress</option>
                                <option value="Approved" <?php echo e(($status ?? '') === 'Approved' ? 'selected' : ''); ?>>Approved</option>
                                <option value="Rejected" <?php echo e(($status ?? '') === 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-navy">Search</button>
                        </div>
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Request ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Document Type</th>
                                        <th scope="col">Date Requested</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($req->request_id); ?></td>
                                        <td><?php echo e($req->full_name); ?></td>
                                        <td><?php echo e($req->document_type ?? 'N/A'); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($req->request_date)->format('M d, Y')); ?></td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('request.status', $req->request_id)); ?>" class="d-inline" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="Pending" <?php echo e($req->status === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                                    <option value="In Progress" <?php echo e($req->status === 'In Progress' ? 'selected' : ''); ?>>In Progress</option>
                                                    <option value="Approved" <?php echo e($req->status === 'Approved' ? 'selected' : ''); ?>>Approved</option>
                                                    <option value="Rejected" <?php echo e($req->status === 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('request.destroy', $req->request_id)); ?>" class="d-inline" onsubmit="return confirm('Delete this request?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-link btn-sm p-0">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No requests found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($requests->hasPages()): ?>
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($requests->links()); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Complaints Tab -->
            <?php if(request()->is('*/complaints')): ?>
            <div class="tab-pane fade show active" role="tabpanel">
                <h1 class="mt-4 text-navy fw-bold">Manage Complaints</h1>
                <p class="lead text-secondary">Here you can manage resident complaints.</p>
                <div class="mt-4">
                    <h5 class="mb-3 text-navy fw-bold">Residents Filed Complaints</h5>
                    <form method="GET" action="<?php echo e(route('manage_e-serbisyo.complaints')); ?>" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search by Name or Complaint ID" value="<?php echo e($q ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Filter by Status</option>
                                <option value="Pending" <?php echo e(($status ?? '') === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="In Progress" <?php echo e(($status ?? '') === 'In Progress' ? 'selected' : ''); ?>>In Progress</option>
                                <option value="Resolved" <?php echo e(($status ?? '') === 'Resolved' ? 'selected' : ''); ?>>Resolved</option>
                                <option value="Cancelled" <?php echo e(($status ?? '') === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-navy">Search</button>
                        </div>
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Complaint ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Date Filed</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($comp->complaint_id); ?></td>
                                        <td><?php echo e($comp->full_name); ?></td>
                                        <td><?php echo e($comp->subject); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($comp->date_filed)->format('M d, Y')); ?></td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('complaint.status', $comp->complaint_id)); ?>" class="d-inline" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="Pending" <?php echo e($comp->status === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                                    <option value="In Progress" <?php echo e($comp->status === 'In Progress' ? 'selected' : ''); ?>>In Progress</option>
                                                    <option value="Resolved" <?php echo e($comp->status === 'Resolved' ? 'selected' : ''); ?>>Resolved</option>
                                                    <option value="Cancelled" <?php echo e($comp->status === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('complaint.destroy', $comp->complaint_id)); ?>" class="d-inline" onsubmit="return confirm('Delete this complaint?');">
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
                                        <td colspan="6" class="text-center text-muted py-4">No complaints found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($complaints->hasPages()): ?>
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($complaints->links()); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/manage_e-serbisyo.blade.php ENDPATH**/ ?>