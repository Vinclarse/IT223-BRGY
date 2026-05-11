<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Community e-Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{url('frontend/style.css')}}">
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
                    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('about_guest')}}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('e-serbisyo_guest')}}">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('transparency_guest')}}">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('community_guest')}}">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('disasterPreparedness_guest')}}">Disaster Preparedness</a></li>
                </ul>

                <div class="d-flex ms-2">
                    @if(session('user'))
                        <a href="{{ url('profile') }}">
                            <i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i>
                        </a>
                    @else
                        <a href="{{ url('profile_guest') }}">
                            <i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>


    <div class="container mb-2">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow">

                    <div class="card-body p-4">
                        <a href="{{url('profile_guest')}}" class="card-link mb-4">
                            <i class="bi bi-reply" style="font-size: 20px;"></i>
                        </a>

                        <h1 class="display-6 text-center mb-4 text-navy fw-bold" id="roleTitle">
                            Login
                        </h1>

                        <p class="lead text-secondary text-center mb-4" id="roleSubtitle">
                            Please log in to continue.
                        </p>

                        <!-- ERROR MESSAGE -->
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger text-center">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- LOGIN FORM -->
                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <input type="hidden" id="role" name="role">

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword" title="Show/Hide password">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-navy w-100">
                                Login
                            </button>
                        </form>


                        <p class="mt-3 text-center text-secondary" id="signupPrompt">
                            Don't have an account?
                            <a href="{{url('signup')}}" class="link-primary">Sign Up</a>
                        </p>

                    </div>
                </div>  
            </div>
        </div>
    </div>


    <script>
        const roleInput = document.getElementById('role');
        const params = new URLSearchParams(window.location.search);
        const role = params.get('role');

        const title = document.getElementById('roleTitle');
        const subtitle = document.getElementById('roleSubtitle');
        const signupPrompt = document.getElementById('signupPrompt');

        if (role === 'Resident') {
            title.textContent = "Resident Login";
            subtitle.textContent = "Log in to access your e-Serbisyo account.";
            roleInput.value = "Resident";
        } 
        else if (role === 'Official') {
            title.textContent = "Barangay Official Login";
            subtitle.textContent = "Log in to manage barangay records and updates.";
            signupPrompt.style.display = 'none';
            roleInput.value = "Official";
        }
        else if (role === 'Admin') {
            title.textContent = "Admin Login";
            subtitle.textContent = "Access administrative tools and settings.";
            signupPrompt.style.display = 'none';
            roleInput.value = "Admin";
        }

    </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var pwd = document.getElementById('password');
                var btn = document.getElementById('toggleLoginPassword');
                if (pwd && btn) {
                    btn.addEventListener('click', function () {
                        var type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
                        pwd.setAttribute('type', type);
                        var icon = btn.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('bi-eye');
                            icon.classList.toggle('bi-eye-slash');
                        }
                    });
                }
            });
        </script>

    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
