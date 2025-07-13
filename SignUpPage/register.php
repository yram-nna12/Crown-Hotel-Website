<?php
session_start();
require './db.php';

// Get form input
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$terms = isset($_POST['terms']);

$_SESSION['old_input'] = $_POST;

// Validation
if (!$terms) {
    $_SESSION['register_error'] = "You must agree to the terms.";
    header("Location: index.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['register_error'] = "Passwords do not match.";
    header("Location: index.php");
    exit();
}

// Check if email exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $_SESSION['register_error'] = "Email already exists.";
    header("Location: index.php");
    exit();
}

// Insert user
$username = strtolower($first_name . '.' . $last_name);
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
$role = 'client';
$created_at = date('Y-m-d H:i:s');

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role, first_name, last_name, phone, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $username, $email, $hashed_password, $role, $first_name, $last_name, $phone, $created_at);

if ($stmt->execute()) {
    unset($_SESSION['old_input']);
    $_SESSION['login_error'] = "Account created! Please log in.";
    header("Location: ../LoginPage/index.php");
    exit();
} else {
    $_SESSION['register_error'] = "Registration failed. Please try again.";
    header("Location: index.php");
    exit();
}
?>
