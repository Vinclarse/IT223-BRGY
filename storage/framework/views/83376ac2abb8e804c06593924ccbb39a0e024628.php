<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Management | Admin - Community e-Portal</title>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('admin_dashboard')); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manageusers_admin')); ?>">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('website_management')); ?>">Website Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('system_settings')); ?>">System Settings</a></li>
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

    <header class="container mb-4">
        <h1 class="display-5 fw-bold">Website Management</h1>
        <p class="lead text-secondary">
            Manage events, announcements, and transparency content shown to residents and guests.
        </p>
    </header>

    <section class="container mb-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-megaphone me-2"></i>Announcements</h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-2 mb-3" method="POST" action="<?php echo e(route('announcements.store')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-5">
                                <label class="form-label small text-muted">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Category</label>
                                <select name="category" class="form-select" required>
                                    <?php $__currentLoopData = ['General','Emergency','Event','Advisory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat); ?>"><?php echo e($cat); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small text-muted">Content</label>
                                <textarea name="content" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn-outline-navy btn-sm"><i class="bi bi-plus-lg"></i> Post</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($ann->title); ?></td>
                                            <td><?php echo e($ann->category); ?></td>
                                            <td><?php echo e($ann->date_posted); ?></td>
                                            <td class="text-end">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#ann-<?php echo e($ann->announcement_id); ?>">Edit</button>
                                                <form class="d-inline" method="POST" action="<?php echo e(route('announcements.destroy', $ann->announcement_id)); ?>" onsubmit="return confirm('Delete this announcement?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="ann-<?php echo e($ann->announcement_id); ?>">
                                            <td colspan="4">
                                                <form class="row g-2" method="POST" action="<?php echo e(route('announcements.update', $ann->announcement_id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted">Title</label>
                                                        <input type="text" name="title" class="form-control" value="<?php echo e($ann->title); ?>" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Category</label>
                                                        <select name="category" class="form-select" required>
                                                            <?php $__currentLoopData = ['General','Emergency','Event','Advisory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($cat); ?>" <?php if($ann->category===$cat): echo 'selected'; endif; ?>><?php echo e($cat); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Date Posted</label>
                                                        <input type="datetime-local" name="date_posted" class="form-control" value="<?php echo e($ann->date_posted); ?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small text-muted">Content</label>
                                                        <textarea name="content" class="form-control" rows="2" required><?php echo e($ann->content); ?></textarea>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button class="btn btn-outline-navy btn-sm">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="text-muted text-center">No announcements yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-calendar-event me-2"></i>Events</h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-2 mb-3" method="POST" action="<?php echo e(route('events.store')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Date</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn-outline-navy btn-sm"><i class="bi bi-plus-lg"></i> Add Event</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($event->title); ?></td>
                                            <td><?php echo e($event->event_date); ?></td>
                                            <td><?php echo e($event->location); ?></td>
                                            <td class="text-end">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#event-<?php echo e($event->event_id); ?>">Edit</button>
                                                <form class="d-inline" method="POST" action="<?php echo e(route('events.destroy', $event->event_id)); ?>" onsubmit="return confirm('Delete this event?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="event-<?php echo e($event->event_id); ?>">
                                            <td colspan="4">
                                                <form class="row g-2" method="POST" action="<?php echo e(route('events.update', $event->event_id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted">Title</label>
                                                        <input type="text" name="title" class="form-control" value="<?php echo e($event->title); ?>" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Date</label>
                                                        <input type="date" name="event_date" class="form-control" value="<?php echo e(\Illuminate\Support\Str::of($event->event_date)->substr(0,10)); ?>" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Location</label>
                                                        <input type="text" name="location" class="form-control" value="<?php echo e($event->location); ?>" required>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <button class="btn btn-outline-navy btn-sm w-100">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="text-muted text-center">No events yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-file-earmark-text me-2"></i>Transparency Reports</h5>
                <a class="btn btn-outline-navy btn-sm" href="<?php echo e(route('transparency_records')); ?>">Open full manager</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Report Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $transparency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($report->title); ?></td>
                                    <td><?php echo e($report->category); ?></td>
                                    <td><?php echo e($report->report_date); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="3" class="text-muted text-center">No reports yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <small class="text-muted d-block">Use the Transparency page to upload, edit, or remove reports.</small>
            </div>
        </div>
    </section>

    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/website_management.blade.php ENDPATH**/ ?>