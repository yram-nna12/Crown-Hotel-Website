<?php
// BookNow/index.php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../LoginPage/index.php");
  exit();
}

$hotel = $_GET['hotel'] ?? '';
$room_type = $_GET['room'] ?? '';
$location = $_GET['location'] ?? '';
$price = $_GET['price'] ?? '';

$_SESSION['selected_hotel_name'] = $hotel;
$_SESSION['selected_hotel_location'] = $location;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Now</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header class="topbar">
  <div class="logo">
    <img src="./assets/img/LOGO.png" alt="Crown Tower Logo">
  </div>
  <nav class="nav-links">
    <a href="../user_hotel_list/index.php" class="btn booking">Booking</a>
    <a href="#" class="btn home">Home</a>
    <a href="../AccountDetails/index.php" class="btn home">My Account</a>
  </nav>
</header>

  <main class="payment">
    <div class="left-panel">
      <h2 class="booking-title">Input Your Details</h2>
      <p class="note cancellation-policy">
        Cancellations are subject to penalty: 20% within 2 days, 15% if within 3–4 days, 10% if more than 5 days prior.
      </p>

      <form method="POST" action="./process_booking.php">
        <!-- Hidden booking details -->
        <input type="hidden" name="hotel_name" value="<?= $_SESSION['selected_hotel_name'] ?? 'Default Hotel' ?>">
<input type="hidden" name="location" value="<?= $_SESSION['selected_hotel_location'] ?? 'Unknown Location' ?>">

        <input type="hidden" name="room_type" value="<?= htmlspecialchars($room_type) ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <div class="name-fields">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="First Name" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Last Name" required>
          </div>
        </div>

        <label>Contact Number</label>
        <input type="tel" name="contact" placeholder="Mobile or phone number" required>

        <div class="row-fields">
          <div class="form-group">
            <label>Check In</label>
            <input type="date" name="check_in" required min="<?= date('Y-m-d', strtotime('+2 days')) ?>">
          </div>
          <div class="form-group">
            <label>Check Out</label>
            <input type="date" name="check_out" required>
          </div>
        </div>
       <div style="display: flex; gap: 15px; margin-top: 20px;">
  <button type="submit" class="btn submit">Proceed to Payment</button>
  <a href="../user_hotelDetails.php" class="btn" style="background:#ccc; color:#000; padding: 12px 30px; border-radius: 8px; text-decoration: none;">Go Back</a>
</div>


      </form>
    </div>

    <div class="right-panel">
  <div class="booking-box">
    <h3>Hotel</h3>
    <div class="info-box"><?= htmlspecialchars($hotel) ?></div>
    
    <h3>Location</h3>
    <div class="info-box"><?= htmlspecialchars($location) ?></div>

    <h3>Room Type</h3>
    <div class="info-box"><?= htmlspecialchars($room_type) ?></div>

    <h3 class="total-label">Total Price <span>(per night)</span></h3>
    <div class="price">₱<?= number_format($price, 2) ?></div>
  </div>
</div>

  </main>

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

</body>
</html>
