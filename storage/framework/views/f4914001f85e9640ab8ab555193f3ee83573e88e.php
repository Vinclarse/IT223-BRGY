<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('frontend/style.css')); ?>">
</head>
<body class="p-4">
    <div class="container">
        <h2>Edit Resident</h2>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('residents.update', $resident->resident_id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-3">
                <label class="form-label">User ID</label>
                <input type="text" name="user_id" class="form-control" value="<?php echo e(old('user_id', $resident->user_id ?? '')); ?>">
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name', $resident->first_name ?? '')); ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="<?php echo e(old('middle_name', $resident->middle_name ?? '')); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name', $resident->last_name ?? '')); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Sex</label>
                <select name="sex" class="form-select">
                    <option value="">-- Select --</option>
                    <?php $sexValue = old('sex', $resident->sex ?? ''); ?>
                    <option value="Male" <?php echo e($sexValue === 'Male' ? 'selected' : ''); ?>>Male</option>
                    <option value="Female" <?php echo e($sexValue === 'Female' ? 'selected' : ''); ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo e(old('address', $resident->address ?? '')); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="<?php echo e(old('contact_number', $resident->contact_number ?? '')); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $resident->email ?? '')); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="<?php echo e(old('birth_date', isset($resident->birth_date) ? date('Y-m-d', strtotime($resident->birth_date)) : '')); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Date Registered</label>
                <input type="date" name="date_registered" class="form-control" value="<?php echo e(old('date_registered', isset($resident->date_registered) ? date('Y-m-d', strtotime($resident->date_registered)) : date('Y-m-d'))); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php $statusValue = old('status', $resident->status ?? 'Pending'); ?>
                    <option value="Pending" <?php echo e($statusValue == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="Verified" <?php echo e($statusValue == 'Verified' ? 'selected' : ''); ?>>Verified</option>
                    <option value="Unverified" <?php echo e($statusValue == 'Unverified' ? 'selected' : ''); ?>>Unverified</option>
                    <option value="Active" <?php echo e($statusValue == 'Active' ? 'selected' : ''); ?>>Active</option>
                    <option value="Inactive" <?php echo e($statusValue == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="<?php echo e(route('manage_residents')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php /**PATH C:\Main Main file\resources\views/edit_resident.blade.php ENDPATH**/ ?>