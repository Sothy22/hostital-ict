<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration | WeCare</title>
    <link rel="stylesheet" href="{{ asset('assets/style/register.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <main class="register-card">
        <div class="brand">
            <div class="brand-logo">
                <div class="icon-box"><i data-lucide="briefcase-medical"></i></div>
                <span class="brand-name">WeCare</span>
            </div>
            <h1>Patient Registration</h1>
            <p class="brand-subtitle">Create your account to book appointments</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Full name</label>
                    <div class="input-wrapper">
                        <i data-lucide="user"></i>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <div class="input-wrapper">
                        <i data-lucide="mail"></i>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="patient@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <div class="input-wrapper">
                        <i data-lucide="phone"></i>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="Phone number" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of birth</label>
                    <div class="input-wrapper">
                        <i data-lucide="calendar-days"></i>
                        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="input-wrapper">
                        <i data-lucide="users"></i>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                            <option value="Other" @selected(old('gender') === 'Other')>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="address">Address</label>
                    <div class="input-wrapper textarea-wrapper">
                        <i data-lucide="map-pin"></i>
                        <textarea id="address" name="address" placeholder="Your address" rows="2">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock"></i>
                        <input id="password" name="password" type="password" placeholder="At least 8 characters" required>
                        <button type="button" class="toggle-password" data-target="password" aria-label="Show password"><i data-lucide="eye"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock-keyhole"></i>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" required>
                        <button type="button" class="toggle-password" data-target="password_confirmation" aria-label="Show password"><i data-lucide="eye"></i></button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">
                Create Patient Account <i data-lucide="arrow-right"></i>
            </button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </main>

    <script>
        lucide.createIcons();
        document.querySelectorAll('.toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.target);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    </script>
</body>
</html>
