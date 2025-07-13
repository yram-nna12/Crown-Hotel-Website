<?php
session_start();
require './db.php'; // make sure this connects to your 'crownh_db' database

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username_or_email = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: ../admin_dashboard/index.php");
            } else {
                header("Location: ../ClientLandingPage/index.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "❌ Incorrect password.";
        }
    } else {
        $_SESSION['error'] = "❌ User not found.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "❌ Invalid request.";
}

header("Location: index.php");
exit();
?>
