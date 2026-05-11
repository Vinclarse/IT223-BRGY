<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}">
    <style>
        .signup-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .signup-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .signup-header {
            background: linear-gradient(135deg, #667eea 0%, #0b3d91 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-section {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .section-title {
            color: #495057;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .section-title i {
            color: #0d6efd;
        }
        .required::after {
            content: " *";
            color: #dc3545;
        }
        .password-strength {
            height: 4px;
            margin-top: 5px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .strength-weak { background-color: #dc3545; width: 25%; }
        .strength-fair { background-color: #fd7e14; width: 50%; }
        .strength-good { background-color: #ffc107; width: 75%; }
        .strength-strong { background-color: #198754; width: 100%; }
        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        .password-requirements ul {
            padding-left: 0;
            margin-bottom: 0;
        }
        .password-requirements li {
            margin-bottom: 3px;
            display: flex;
            align-items: center;
        }
        .password-requirements .valid {
            color: #198754;
        }
        .password-requirements .invalid {
            color: #6c757d;
        }
        .input-with-icon {
            position: relative;
        }
        .input-with-icon .form-control {
            padding-left: 40px;
            padding-right: 40px;
        }
        .input-with-icon .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 4;
        }
        .input-with-icon .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            padding: 0;
            z-index: 4;
            cursor: pointer;
        }
        .input-with-icon .toggle-password:hover {
            color: #495057;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #0b3d91 100%);
            color: white;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .error-border {
            border-color: #dc3545;
        }
        .error-border:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="{{ url('/') }}">Community e-Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('about_guest') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('e-serbisyo_guest') }}">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('transparency_guest') }}">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('community_guest') }}">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('disasterPreparedness_guest') }}">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="{{url('profile_guest')}}"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card signup-card mb-5">
                    <!-- Header -->
                    <div class="signup-header">
                        <h1 class="display-6 fw-bold mb-3">Create Your Account</h1>
                        <p class="mb-0 opacity-75">
                            Join our community to access barangay services and stay updated
                        </p>
                    </div>

                    <!-- Messages -->
                    <div class="form-section">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                    </div>

                    <!-- Sign Up Form -->
                    <form method="POST" action="{{ route('signup.process') }}" id="signupForm" class="needs-validation" novalidate>
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="bi bi-person-badge text-navy"></i>
                                Personal Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="first_name" class="form-label fw-medium required">First Name</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-person input-icon"></i>
                                        <input type="text" 
                                               class="form-control {{ $errors->has('first_name') ? 'is-invalid error-border' : '' }}" 
                                               id="first_name" 
                                               name="first_name" 
                                               value="{{ old('first_name') }}" 
                                               required
                                               placeholder="Enter your first name">
                                        <div class="invalid-feedback">
                                            Please enter your first name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="middle_name" class="form-label fw-medium">Middle Name</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-person input-icon"></i>
                                        <input type="text" 
                                               class="form-control {{ $errors->has('middle_name') ? 'is-invalid error-border' : '' }}" 
                                               id="middle_name" 
                                               name="middle_name" 
                                               value="{{ old('middle_name') }}"
                                               placeholder="Enter your middle name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="last_name" class="form-label fw-medium required">Last Name</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-person input-icon"></i>
                                        <input type="text" 
                                               class="form-control {{ $errors->has('last_name') ? 'is-invalid error-border' : '' }}" 
                                               id="last_name" 
                                               name="last_name" 
                                               value="{{ old('last_name') }}" 
                                               required
                                               placeholder="Enter your last name">
                                        <div class="invalid-feedback">
                                            Please enter your last name.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="bi bi-telephone"></i>
                                Contact Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium required">Email Address</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-envelope input-icon"></i>
                                        <input type="email" 
                                               class="form-control {{ $errors->has('email') ? 'is-invalid error-border' : '' }}" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required
                                               placeholder="example@email.com">
                                        <div class="invalid-feedback">
                                            Please enter a valid email address.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_number" class="form-label fw-medium required">Contact Number</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-phone input-icon"></i>
                                        <input type="tel" 
                                               class="form-control {{ $errors->has('contact_number') ? 'is-invalid error-border' : '' }}" 
                                               id="contact_number" 
                                               name="contact_number" 
                                               value="{{ old('contact_number') }}" 
                                               required
                                               placeholder="09XX-XXX-XXXX">
                                        <div class="invalid-feedback">
                                            Please enter your contact number.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="bi bi-house-door"></i>
                                Additional Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="sex" class="form-label fw-medium required">Gender</label>
                                    <select class="form-select {{ $errors->has('sex') ? 'is-invalid error-border' : '' }}" id="sex" name="sex" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select your gender.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="birth_date" class="form-label fw-medium required">Birth Date</label>
                                    <input type="date" 
                                           class="form-control {{ $errors->has('birth_date') ? 'is-invalid error-border' : '' }}" 
                                           id="birth_date" 
                                           name="birth_date" 
                                           value="{{ old('birth_date') }}" 
                                           required
                                           max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                                    <div class="invalid-feedback">
                                        Please enter your birth date (must be 18+ years old).
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="address" class="form-label fw-medium required">Address</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-geo-alt input-icon"></i>
                                        <input type="text" 
                                               class="form-control {{ $errors->has('address') ? 'is-invalid error-border' : '' }}" 
                                               id="address" 
                                               name="address" 
                                               value="{{ old('address') }}" 
                                               required
                                               placeholder="Your complete address">
                                        <div class="invalid-feedback">
                                            Please enter your address.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Security Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="bi bi-shield-lock"></i>
                                Account Security
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-medium required">Password</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-key input-icon"></i>
                                        <input type="password" 
                                               class="form-control {{ $errors->has('password') ? 'is-invalid error-border' : '' }}" 
                                               id="password" 
                                               name="password" 
                                               required
                                               minlength="8"
                                               placeholder="Create a strong password">
                                        <button type="button" class="toggle-password" id="togglePassword">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength mt-2" id="passwordStrength"></div>
                                    <div class="password-requirements mt-2">
                                        <small class="d-block mb-1">Password must contain:</small>
                                        <ul class="list-unstyled mb-0">
                                            <li id="req-length">
                                                <i class="bi bi-circle me-1"></i>
                                                <span>At least 8 characters</span>
                                            </li>
                                            <li id="req-uppercase">
                                                <i class="bi bi-circle me-1"></i>
                                                <span>One uppercase letter</span>
                                            </li>
                                            <li id="req-lowercase">
                                                <i class="bi bi-circle me-1"></i>
                                                <span>One lowercase letter</span>
                                            </li>
                                            <li id="req-number">
                                                <i class="bi bi-circle me-1"></i>
                                                <span>One number</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-medium required">Confirm Password</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-key-fill input-icon"></i>
                                        <input type="password" 
                                               class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid error-border' : '' }}" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required
                                               placeholder="Re-enter your password">
                                        <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="passwordMatchError" style="display: none;">
                                        Passwords do not match.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Submit -->
                        <div class="form-section">
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input {{ $errors->has('terms') ? 'is-invalid error-border' : '' }}" 
                                           type="checkbox" 
                                           id="terms" 
                                           name="terms"
                                           {{ old('terms') ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree to the terms before signing up.
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-register btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <div class="card-footer text-center py-4 bg-light">
                        <p class="mb-0">
                            Already have an account? 
                            <a href="{{ url('login?role=Resident') }}" class="text-decoration-none fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Log In Here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bootstrap form validation
            const form = document.getElementById('signupForm');
            
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            // Initialize all fields with previous errors
            @if($errors->any())
                form.classList.add('was-validated');
            @endif

            // Password toggle functionality
            function setupPasswordToggle(passwordId, toggleId) {
                const passwordInput = document.getElementById(passwordId);
                const toggleButton = document.getElementById(toggleId);
                
                if (passwordInput && toggleButton) {
                    toggleButton.addEventListener('click', function () {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        const icon = toggleButton.querySelector('i');
                        if (type === 'password') {
                            icon.classList.remove('bi-eye');
                            icon.classList.add('bi-eye-slash');
                        } else {
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        }
                    });
                }
            }

            setupPasswordToggle('password', 'togglePassword');
            setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');

            // Password strength checker
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');
            const reqLength = document.getElementById('req-length');
            const reqUppercase = document.getElementById('req-uppercase');
            const reqLowercase = document.getElementById('req-lowercase');
            const reqNumber = document.getElementById('req-number');
            
            // Store references to icons
            const lengthIcon = reqLength.querySelector('i');
            const uppercaseIcon = reqUppercase.querySelector('i');
            const lowercaseIcon = reqLowercase.querySelector('i');
            const numberIcon = reqNumber.querySelector('i');
            
            // Store text spans
            const lengthText = reqLength.querySelector('span');
            const uppercaseText = reqUppercase.querySelector('span');
            const lowercaseText = reqLowercase.querySelector('span');
            const numberText = reqNumber.querySelector('span');

            function checkPasswordStrength(password) {
                let strength = 0;
                
                // Check length
                if (password.length >= 8) {
                    strength += 1;
                    lengthIcon.className = 'bi bi-check-circle-fill text-success me-1';
                    reqLength.classList.add('valid');
                    reqLength.classList.remove('invalid');
                } else {
                    lengthIcon.className = 'bi bi-circle me-1';
                    reqLength.classList.remove('valid');
                    reqLength.classList.add('invalid');
                }

                // Check uppercase
                if (/[A-Z]/.test(password)) {
                    strength += 1;
                    uppercaseIcon.className = 'bi bi-check-circle-fill text-success me-1';
                    reqUppercase.classList.add('valid');
                    reqUppercase.classList.remove('invalid');
                } else {
                    uppercaseIcon.className = 'bi bi-circle me-1';
                    reqUppercase.classList.remove('valid');
                    reqUppercase.classList.add('invalid');
                }

                // Check lowercase
                if (/[a-z]/.test(password)) {
                    strength += 1;
                    lowercaseIcon.className = 'bi bi-check-circle-fill text-success me-1';
                    reqLowercase.classList.add('valid');
                    reqLowercase.classList.remove('invalid');
                } else {
                    lowercaseIcon.className = 'bi bi-circle me-1';
                    reqLowercase.classList.remove('valid');
                    reqLowercase.classList.add('invalid');
                }

                // Check number
                if (/[0-9]/.test(password)) {
                    strength += 1;
                    numberIcon.className = 'bi bi-check-circle-fill text-success me-1';
                    reqNumber.classList.add('valid');
                    reqNumber.classList.remove('invalid');
                } else {
                    numberIcon.className = 'bi bi-circle me-1';
                    reqNumber.classList.remove('valid');
                    reqNumber.classList.add('invalid');
                }

                // Update strength bar
                strengthBar.className = 'password-strength';
                if (password.length === 0) {
                    strengthBar.style.width = '0%';
                } else if (strength <= 1) {
                    strengthBar.classList.add('strength-weak');
                } else if (strength === 2) {
                    strengthBar.classList.add('strength-fair');
                } else if (strength === 3) {
                    strengthBar.classList.add('strength-good');
                } else {
                    strengthBar.classList.add('strength-strong');
                }
            }

            passwordInput.addEventListener('input', function () {
                checkPasswordStrength(this.value);
            });

            // Check password match
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const passwordMatchError = document.getElementById('passwordMatchError');
            
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (confirmPassword.length === 0) {
                    confirmPasswordInput.classList.remove('is-invalid');
                    passwordMatchError.style.display = 'none';
                    return;
                }
                
                if (password !== confirmPassword) {
                    confirmPasswordInput.classList.add('is-invalid');
                    passwordMatchError.style.display = 'block';
                } else {
                    confirmPasswordInput.classList.remove('is-invalid');
                    passwordMatchError.style.display = 'none';
                }
            }

            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);

            // Set max birth date to 18 years ago
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
            document.getElementById('birth_date').max = maxDate.toISOString().split('T')[0];

            // Initialize password strength on page load
            checkPasswordStrength(passwordInput.value);
        });
    </script>
</body>
</html>