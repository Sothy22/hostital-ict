<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Login</title>
    <link rel="stylesheet" href="../assets/style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div class="login-card">
      @if (session('status'))
        <div class="alert alert-success" style="margin-bottom: 16px;">
          {{ session('status') }}
        </div>
      @endif
      <!-- Header Logo & Title -->
      <div class="brand">
        <div class="brand-logo">
          <div class="icon-box">
            <i data-lucide="briefcase-medical"></i>
          </div>
          <span class="brand-name">WeCare</span>
        </div>
        <p class="brand-subtitle">Hospital Management System</p>
      </div>

      <!-- Login Form -->
      <form id="loginForm" method="post" action="{{ route('login') }}">
        @csrf
        <!-- Username/ID Field -->
        <div class="form-group">
          <label for="staffId">Username or Staff ID</label>
          <div class="input-wrapper">
            <i data-lucide="user" class="input-icon"></i>
            <input type="text" name="email" id="staffId" placeholder="Email User" required />
          </div>
        </div>

        <!-- Password Field -->
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <i data-lucide="lock" class="input-icon"></i>
            <input
              type="password"
              name="password"
              id="password"
              placeholder="••••••••"
              required
            />
            <button type="button" class="toggle-password" id="togglePassword">
              <i data-lucide="eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-login">
          Login <i data-lucide="log-in" style="width: 18px; height: 18px"></i>
        </button>
      </form>

      <!-- Forgot Password Link -->
      <div class="forgot-password">
        <a href="{{ route('forgetpass') }}">Forgot Password?</a>
      </div>
    </div>

    <script src="../assets/script/login.js"></script>
  </body>
</html>
