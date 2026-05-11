<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Residents | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('manage_residents')); ?>">Manage Residents</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manage_e-serbisyo')); ?>">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?php echo e(url('transparency_records')); ?>">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(url('events_announcements')); ?>">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(url('appointments_feedback')); ?>">Appointments & Feedback</a></li>
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

            <div class="container">
                <h1 class="mt-2 text-navy fw-bold">Manage Residents</h1>
                <p class="lead text-secondary">Here you can manage resident information and requests.</p>
                    <div class="mt-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <form class="row g-3 mb-4" method="GET" action="<?php echo e(route('manage_residents')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control" placeholder="Search by Name, Email or ID" value="<?php echo e(request('q', $q ?? '')); ?>">
                        </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="Verified" <?php echo e((request('status', $status ?? '')==='Verified') ? 'selected' : ''); ?>>Verified</option>
                                    <option value="Pending" <?php echo e((request('status', $status ?? '')==='Pending') ? 'selected' : ''); ?>>Pending</option>
                                    <option value="Unverified" <?php echo e((request('status', $status ?? '')==='Unverified') ? 'selected' : ''); ?>>Unverified</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-grid">
                                <button type="submit" class="btn btn-outline-navy">Search</button>
                            </div>
                        <?php if(!isset($hasStatus) || !$hasStatus): ?>
                            <div class="col-12 mt-2">
                                <small class="text-muted">Status column not found in the `resident` table; choosing a status will not filter results until the column exists.</small>
                            </div>
                        <?php endif; ?>
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Resident ID</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Birth Date</th>
                                        <th scope="col">Date Registered</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($residents) && $residents->count()): ?>
                                        <?php $__currentLoopData = $residents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($r->resident_id); ?></td>
                                                <td><?php echo e($r->user_id ?? ''); ?></td>
                                                <td><?php echo e($r->full_name ?? ''); ?></td>
                                                <td><?php echo e($r->address ?? ''); ?></td>
                                                <td><?php echo e($r->contact_number ?? ''); ?></td>
                                                <td><?php echo e($r->email ?? ''); ?></td>
                                                <td><?php echo e(isset($r->birth_date) ? date('Y-m-d', strtotime($r->birth_date)) : ''); ?></td>
                                                <td><?php echo e(isset($r->date_registered) ? date('Y-m-d', strtotime($r->date_registered)) : ''); ?></td>
                                                <td>
                                                    <?php $st = $r->status ?? 'Pending'; ?>
                                                    <?php if(strtolower($st) === 'active' || strtolower($st) === 'verified'): ?>
                                                        <span class="badge bg-success">Verified</span>
                                                    <?php elseif(strtolower($st) === 'pending'): ?>
                                                        <span class="badge bg-warning text-dark"><?php echo e($st); ?></span>
                                                    <?php elseif(strtolower($st) === 'unverified'): ?>
                                                        <span class="badge bg-danger"><?php echo e($st); ?></span>
                                                    <?php elseif(strtolower($st) === 'inactive'): ?>
                                                        <span class="badge bg-secondary"><?php echo e($st); ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-light text-dark"><?php echo e($st); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('residents.show', $r->resident_id)); ?>" title="View"><i class="bi bi-eye"></i></a>
                                                    <a href="<?php echo e(route('residents.edit', $r->resident_id)); ?>" class="ms-3" title="Edit"><i class="bi bi-pencil"></i></a>
                                                    <form action="<?php echo e(route('residents.destroy', $r->resident_id)); ?>" method="POST" class="d-inline ms-3" onsubmit="return confirm('Delete this resident?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-link p-0 text-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No residents found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php if(isset($residents) && method_exists($residents, 'links')): ?>
                                <div class="card-footer bg-white border-0">
                                    <?php echo e($residents->links()); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/manage_residents.blade.php ENDPATH**/ ?>