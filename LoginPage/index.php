<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crown Tower | Login</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
     <header class="topbar">
        <div class="logo">
            <img src="./assets/img/LOGO.png" alt="Crown Tower Logo">
        </div>
        <nav class="nav-links">
            <a href="../index.php">Home</a>
            <a href="">About Us</a>
            <a href="#" class="btn login" style="color: #0a2240;">Log in</a>
            <a href="../SignUpPage/index.php" class="btn signup" >Sign up</a>
        </nav>
    </header>
    <div class="container">
        <!-- Left Panel with Logo -->
        <div class="left-panel">
            <img src="assets/img/LOGO.png" alt="Crown Tower Logo" class="logo">
        </div>

        <!-- Right Panel with Form -->
        <div class="right-panel">
            <div class="form">
                <h2>Login to Your Account</h2>
                <form action="login_process.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username or Email" required>
                    </div>
                    <div class="form-group password-group">
                        <input type="password" name="password" placeholder="Password" id="password" required>
                        <span class="toggle-password" onclick="togglePassword()" style="background-image: url('assets/img/eye.png');"></span>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                    <input type="submit" value="Login" class="login-btn">
                </form>

                <?php if (isset($_SESSION['error'])): ?>
                    <p class="error" style="color: #fff;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>

                <div class="divider">or login with</div>
                <div class="social-icons">
                    <img src="assets/img/facebook.png" alt="Facebook">
                    <img src="assets/img/google.png" alt="Google">
                </div>
                <div class="footer">
                    Don't have an account? <a href="../SignUpPage/index.php" style="color: #fff; text-decoration: underline;">Sign up here</a>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
</body>
</html>
