<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('frontend/style.css')); ?>">
</head>
<body class="p-4">
    <div class="container">
        <h2>Resident Details</h2>
        <div class="card mt-3">
            <div class="card-body">
                <p><strong>Resident ID:</strong> <?php echo e($resident->resident_id); ?></p>
                <p><strong>User ID:</strong> <?php echo e($resident->user_id ?? ''); ?></p>
                <p><strong>Full Name:</strong> 
                    <?php if(isset($resident->full_name) && $resident->full_name): ?>
                        <?php echo e($resident->full_name); ?>

                    <?php else: ?>
                        <?php
                            $parts = array_filter([trim($resident->first_name ?? ''), trim($resident->middle_name ?? ''), trim($resident->last_name ?? '')]);
                        ?>
                        <?php echo e($parts ? implode(' ', $parts) : ''); ?>

                    <?php endif; ?>
                </p>
                <p><strong>Sex:</strong> <?php echo e($resident->sex ?? ''); ?></p>
                <p><strong>Address:</strong> <?php echo e($resident->address ?? ''); ?></p>
                <p><strong>Contact Number:</strong> <?php echo e($resident->contact_number ?? ''); ?></p>
                <p><strong>Email:</strong> <?php echo e($resident->email ?? ''); ?></p>
                <p><strong>Birth Date:</strong> <?php echo e($resident->birth_date ?? ''); ?></p>
                <p><strong>Date Registered:</strong> <?php echo e($resident->date_registered ?? ''); ?></p>
            </div>
        </div>
        <div class="mt-3">
            <a href="<?php echo e(route('manage_residents')); ?>" class="btn btn-secondary">Back to list</a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/show_resident.blade.php ENDPATH**/ ?>