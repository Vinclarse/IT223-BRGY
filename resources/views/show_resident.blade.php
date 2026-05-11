<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}">
</head>
<body class="p-4">
    <div class="container">
        <h3 class="text-center">Resident Details</h3>
        <div class="card mt-3">
            <div class="card-body">
                <p><strong>Resident ID:</strong> {{ $resident->resident_id }}</p>
                <p><strong>User ID:</strong> {{ $resident->user_id ?? '' }}</p>
                <p><strong>Full Name:</strong> 
                    @if(isset($resident->full_name) && $resident->full_name)
                        {{ $resident->full_name }}
                    @else
                        @php
                            $parts = array_filter([trim($resident->first_name ?? ''), trim($resident->middle_name ?? ''), trim($resident->last_name ?? '')]);
                        @endphp
                        {{ $parts ? implode(' ', $parts) : '' }}
                    @endif
                </p>
                <p><strong>Sex:</strong> {{ $resident->sex ?? '' }}</p>
                <p><strong>Address:</strong> {{ $resident->address ?? '' }}</p>
                <p><strong>Contact Number:</strong> {{ $resident->contact_number ?? '' }}</p>
                <p><strong>Email:</strong> {{ $resident->email ?? '' }}</p>
                <p><strong>Birth Date:</strong> {{ $resident->birth_date ?? '' }}</p>
                <p><strong>Date Registered:</strong> {{ $resident->date_registered ?? '' }}</p>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('manage_residents') }}" class="btn btn-secondary">Back to list</a>
        </div>
    </div>
</body>
</html>
