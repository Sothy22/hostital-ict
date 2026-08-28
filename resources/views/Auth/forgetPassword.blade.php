<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hospital Login</title>
    <link rel="stylesheet" href="../assets/style/login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <script src="https://unpkg.com/lucide@latest"></script>
  </head>
  <body>
    <div class="login-card">
      <!-- Header Logo & Title -->
      <div class="brand">
        <div class="brand-logo">
          <div class="icon-box">
            <i data-lucide="briefcase-medical"></i>
          </div>
          <span class="brand-name">WeCare</span>
        </div>
        <h1>Reset Password</h1>
        <p class="brand-subtitle">Enter your email to reset your password</p>
      </div>

      <!-- Login Form -->
      <form id="loginForm">
        <!-- Username/ID Field -->
        <div class="form-group">
          <label for="staffId">Username or Staff ID</label>
          <div class="input-wrapper">
            <i class="fa-regular fa-envelope"></i>
            <input
              type="text"
              name="email"
              id="staffId"
              placeholder="Email User"
              required
            />
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-login">
          Send Reset Link ->
          <i data-lucide="log-in" style="width: 18px; height: 18px"></i>
        </button>
      </form>

      <!-- Forgot Password Link -->
      <div class="forgot-password">
        <a href="./login"><- Back to Login</a>
      </div>
    </div>

    <script src="../assets/script/login.js"></script>
  </body>
</html>
