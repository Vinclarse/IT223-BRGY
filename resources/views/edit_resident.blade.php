<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}">
</head>
<body class="p-4">
    <div class="container">
        <h2>Edit Resident</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('residents.update', $resident->resident_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">User ID</label>
                <input type="text" name="user_id" class="form-control" value="{{ old('user_id', $resident->user_id ?? '') }}">
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $resident->first_name ?? '') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $resident->middle_name ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $resident->last_name ?? '') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Sex</label>
                <select name="sex" class="form-select">
                    <option value="">-- Select --</option>
                    @php $sexValue = old('sex', $resident->sex ?? ''); @endphp
                    <option value="Male" {{ $sexValue === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $sexValue === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $resident->address ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $resident->contact_number ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $resident->email ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', isset($resident->birth_date) ? date('Y-m-d', strtotime($resident->birth_date)) : '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Date Registered</label>
                <input type="date" name="date_registered" class="form-control" value="{{ old('date_registered', isset($resident->date_registered) ? date('Y-m-d', strtotime($resident->date_registered)) : date('Y-m-d')) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @php $statusValue = old('status', $resident->status ?? 'Pending'); @endphp
                    <option value="Pending" {{ $statusValue == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Verified" {{ $statusValue == 'Verified' ? 'selected' : '' }}>Verified</option>
                    <option value="Unverified" {{ $statusValue == 'Unverified' ? 'selected' : '' }}>Unverified</option>
                    <option value="Active" {{ $statusValue == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $statusValue == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('manage_residents') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
