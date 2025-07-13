<?php
session_start();
require './db.php'; // Ensure correct database connection to crownh_db

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Normalize input
    $username_or_email = strtolower(trim($_POST['username']));
    $password = $_POST['password'];

    // Debug (optional)
    // echo "Input: $username_or_email<br>";

    // Case-insensitive query
    $stmt = $conn->prepare("
        SELECT * FROM users 
        WHERE LOWER(TRIM(username)) = ? 
           OR LOWER(TRIM(email)) = ?
    ");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // ✅ Success: Set session and redirect
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

// Redirect back to login page
header("Location: index.php");
exit();
