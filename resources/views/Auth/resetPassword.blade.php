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
        <p class="brand-subtitle">
          Please choose a secure password for your account.
        </p>
      </div>

      <!-- Login Form -->
      <form id="loginForm">
        <!-- New Password Field -->
        <div class="form-group">
          <label for="password">New Password</label>
          <div class="input-wrapper">
            <i data-lucide="lock" class="input-icon"></i>
            <input
              type="password"
              id="password"
              placeholder="Min. 8 characters"
              required
            />
          </div>
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
          <label for="password">Comfirm New Password</label>
          <div class="input-wrapper">
            <i data-lucide="lock" class="input-icon"></i>
            <input
              type="password"
              id="password"
              placeholder="Re-enter new password"
              required
            />
          </div>
        </div>

        <div class="pass-require">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <p class="security">Security Requirements:</p>
                <p class="minimum">Minimum 8 characters
                    <span>Include at least one symbol (!@#$)</span>
                </p>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-login">Reset Password</button>
      </form>

      <!-- Forgot Password Link -->
      <div class="forgot-password">
        <a href="./login"><- Back to Login</a>
      </div>
    </div>

    <script src="../assets/script/login.js"></script>
  </body>
</html>
