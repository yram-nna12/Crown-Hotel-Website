<?php
session_start();
require_once(__DIR__ . '/../db.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../LoginPage/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Guest';

// Fetch recent bookings
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Crown Hotel - Dashboard</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
</head>
<body>
<header class="topbar">
  <div class="logo">
            <img src="./assets/img/LOGO.png" alt="Crown Tower Logo">
        </div>
  <nav class="nav-links">

  <?php if (isset($_SESSION['user_id'])): ?>
    <a href="../user_hotel_list/index.php" class="btn booking">Booking</a>
    <a href="../ClientLandingPage/index.php" class="btn booking">Home</a>
    <a href="../AccountDetails/index.php" class="btn home">My Account</a>
  <?php else: ?>
    <a href="../LoginPage/index.php" class="btn login" style="color: #0a2240;">Log in</a>
    <a href="../Signup_page/index.php" class="btn signup">Sign up</a>
  <?php endif; ?>
</header>

<section class="hero">
  <div class="hero-content">
    <h1 class="tagline">Welcome, <?= htmlspecialchars($username) ?>!</h1>
    <p>Start your next hotel experience by searching below.</p>

    <form action="../user_hotel_list/index.php" method="GET" class="search-bar">
      <div class="field">
        <label>Location</label>
        <select name="location" required>
          <option value="" disabled selected>Select Location</option>
          <option value="Metro Manila">Metro Manila</option>
          <option value="Antipolo">Antipolo</option>
          <option value="Laguna">Laguna</option>
        </select>
      </div>
      <div class="field">
        <label>Check In</label>
        <input type="text" name="checkin" id="checkin" placeholder="YYYY-MM-DD" required />
      </div>
      <div class="field">
        <label>Check Out</label>
        <input type="text" name="checkout" id="checkout" placeholder="YYYY-MM-DD" required />
      </div>
      <div class="field">
        <label>Guests</label>
        <input type="number" name="guests" placeholder="Number of Guests" min="1" required />
      </div>
      <button type="submit" class="search-btn"><img src="./assets/img/SEARCH.png" alt="Search"></button>
    </form>
  </div>
</section>

<section class="recent-bookings">
  <h2 class="section-title">Booking History</h2>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="booking-card">
        <div class="booking-info">
          <h3><?= htmlspecialchars($row['hotel_name']) ?> at <?= htmlspecialchars($row['location']) ?></h3>
          <p><strong>Room Type:</strong> <?= htmlspecialchars($row['room_type']) ?></p>
          <p><strong>Transaction ID:</strong> <?= htmlspecialchars($row['transaction_id']) ?></p>
          <p><strong>Check-in:</strong> <?= htmlspecialchars($row['check_in']) ?> to <strong>Check-out:</strong> <?= htmlspecialchars($row['check_out']) ?></p>
          <p><strong>Price:</strong> ₱<?= number_format($row['total_price'], 2) ?></p>
          <p><strong>Status:</strong>
            <?= $row['is_paid'] ? "<span class='paid-label'>PAID</span>" : "<span class='unpaid-label'>UNPAID</span>" ?>
          </p>
        </div>
        <?php if (!$row['is_paid']): ?>
          <form action="../CancelBooking/cancel.php" method="POST" class="cancel-form">
            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
            <button type="submit" class="cancel-btn">Cancel Booking</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="padding: 1rem; color: #444;">You have no bookings yet. Start by searching above!</p>
  <?php endif; ?>
</section>

<footer class="footer">
  <div class="footer-content">
    <div class="footer-left">
      <img src="./assets/img/LOGO.png" class="footer-logo" alt="Crown Logo">
      <p class="footer-description">Where elegance is for everyone.</p>
    </div>
    <div class="footer-right">
      <h3>Get in Touch</h3>
      <ul>
        <li><i class="fas fa-map-marker-alt icon"></i> Sampaloc, Manila</li>
        <li><i class="fas fa-phone icon"></i> 0227336689</li>
        <li><i class="fas fa-envelope icon"></i> Crownhotel07@gmail.com</li>
      </ul>
    </div>
  </div>
  <div class="footer-line"></div>
  <div class="footer-bottom">
    <span>©2025 CrownHotel All Rights Reserved</span>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Conditions</a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  flatpickr("#checkin", {
    minDate: "today",
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr) {
      checkout.set("minDate", dateStr);
    }
  });
  const checkout = flatpickr("#checkout", {
    minDate: "today",
    dateFormat: "Y-m-d"
  });
</script>
</body>
</html>
