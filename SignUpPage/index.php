<?php
session_start();
$old = $_SESSION['old_input'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Account</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>
<body>
  <header class="topbar">
    <div class="logo">
      <img src="assets/img/logo.png" alt="Crown Tower Logo">
    </div>
    <nav class="nav-links">
      <a href="../index.php">Home</a>
      <a href="">About Us</a>
      <a href="../LoginPage/index.php" class="btn login" style="color: #0a2240;">Log in</a>
      <a href="#" class="btn signup">Sign up</a>
    </nav>
  </header>

  <div class="container">
    <div class="left-panel">
      <img src="assets/img/logo.png" alt="Logo" class="logo"/>
    </div>

    <div class="right-panel">
      <form action="register.php" method="POST" class="form">
        <h2>CREATE ACCOUNT</h2>

        <?php if (isset($_SESSION['register_error'])): ?>
          <p style="color: white; text-align: center; font-weight: bold; margin-bottom: 10px;">
            <?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
          </p>
        <?php endif; ?>

        <div class="form-group">
          <input type="text" name="first_name" placeholder="First Name" required
            value="<?= htmlspecialchars($old['first_name'] ?? '') ?>" />
          <input type="text" name="phone" placeholder="ex. 09562321354" required
            value="<?= htmlspecialchars($old['phone'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <input type="text" name="last_name" placeholder="Last Name" required
            value="<?= htmlspecialchars($old['last_name'] ?? '') ?>" />
          <input type="password" name="password" placeholder="Password" required />
        </div>

        <div class="form-group">
          <input type="email" name="email" placeholder="example@gmail.com" required
            value="<?= htmlspecialchars($old['email'] ?? '') ?>" />
          <input type="password" name="confirm_password" placeholder="Confirm Password" required />
        </div>

        <div class="checkbox">
          <input type="checkbox" name="terms" required />
          <label>I agree to the terms of services and privacy policy</label>
        </div>

        <button type="submit" class="signup-btn">Sign Up</button>

        <div class="divider">Or Sign Up With</div>
        <div class="social-icons">
          <a href="https://www.facebook.com/" target="_blank">
            <img src="assets/img/facebook.png" alt="Facebook" />
          </a>
          <a href="https://www.google.co.uk/" target="_blank">
            <img src="assets/img/google.png" alt="Google" />
          </a>
        </div>

        <p class="footer">@crownhotel25</p>
      </form>
    </div>
  </div>
</body>
</html>
