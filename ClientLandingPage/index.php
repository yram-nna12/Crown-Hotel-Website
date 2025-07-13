<?php
session_start();
require_once(__DIR__ . '/../db.php');
 // Your DB connection file

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../LoginPage/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch recent bookings
$sql = "SELECT b.*, h.name AS hotel_name, h.location, h.image, h.room_type, h.price, h.stars
        FROM bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crown Tower Hotel</title>
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
      <a href="../user_hotel_list/index.php" class="btn booking" style="color: #0a2240;">Booking</a>
      <a href="#" class="btn home">Home</a>
      <a href="#" class="btn home">Account</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-content">
      <h1 class="tagline">“Where Elegance is for Everyone”</h1>
      <p>
        Crown Hotel is your destination for a refined and relaxing stay...
      </p>

  <form action="../user_hotel_list/index.php" method="GET" class="search-bar">
  <div class="field">
    <label class="form-label">Location</label>
    <select name="location" required class="dropdown">
      <option value="" disabled selected>Select Location</option>
      <option value="Metro Manila">Metro Manila</option>
      <option value="Antipolo">Antipolo</option>
      <option value="Laguna">Laguna</option>
    </select>
  </div>

  <div class="field">
    <label class="form-label">Check In</label>
    <input type="text" name="checkin" id="checkin" placeholder="Select Check-In" required />
  </div>

  <div class="field">
    <label class="form-label">Check Out</label>
    <input type="text" name="checkout" id="checkout" placeholder="Select Check-Out" required />
  </div>

  <div class="field">
    <label class="form-label">Guests</label>
    <input type="number" name="guests" placeholder="How many are you" min="1" required />
  </div>

  <button type="submit" class="search-btn" title="Search">
    <img src="./assets/img/SEARCH.png" alt="Search" />
  </button>
</form>


    </div>
  </section>

  <section class="recent-bookings">
    <h2 class="section-title">Recent Bookings</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="booking-card">
      <div class="booking-details">
        <img src="<?= htmlspecialchars($row['image']) ?>" alt="Room Image" class="room-image" />
        <div class="booking-info">
          <h3 class="hotel-name">
            <?= htmlspecialchars($row['hotel_name']) ?> at
            <span><?= htmlspecialchars($row['location']) ?></span>
            <span class="book-date"><?= htmlspecialchars(date('F j, Y', strtotime($row['booking_date']))) ?></span>
          </h3>
          <p class="room-type"><?= htmlspecialchars($row['room_type']) ?></p>
          <div class="stars"><?= str_repeat("★", $row['stars']) . str_repeat("☆", 5 - $row['stars']) ?></div>
          <p class="occupancy">2-4 persons</p>
          <ul class="amenities">
            <li>✔ Bed</li>
            <li>✔ Free Breakfast</li>
            <li>✔ Free Wifi</li>
            <li>✔ Free Use of Amenities</li>
            <li>✔ Free Parking</li>
          </ul>
        </div>
      </div>
      <div class="booking-status">
        <div class="price">₱ <?= number_format($row['price'], 2) ?></div>
        <small>Included Tax</small>
        <?php if ($row['is_paid']): ?>
          <span class="paid-label">PAID</span>
        <?php else: ?>
          <form action="../payment/pay.php" method="POST">
            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
            <button type="submit" class="pay-now">Pay Now</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
  </section>

  <footer class="footer">
  <div class="footer-content">
    <div class="footer-left">
      <img src="./assets/img/LOGO.png" alt="Crown Hotel Logo" class="footer-logo">
      <p class="footer-description">
        Offers a seamless stay with elegant rooms, warm hospitality, and everything you need to relax or recharge.
      </p>
    </div>
    <div class="footer-right">
      <h3 class="footer-contact-title">Get in Touch</h3>
      <ul class="footer-contact-list">
        <li><i class="fas fa-map-marker-alt icon"></i> Sampaloc, Manila</li>
        <li><i class="fas fa-phone icon"></i> 0227336689</li>
        <li><i class="fas fa-envelope icon"></i> Crownhotel07@gmail.com</li>
      </ul>
    </div>
  </div>

  <!-- Updated line with white circles -->
  <div class="footer-line"></div>

  <div class="footer-bottom">
    <span>@2025 CrownHotel All Rights Reserved</span>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Condition</a>
    </div>
  </div>
</footer>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
  const checkin = flatpickr("#checkin", {
    minDate: "today",
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr, instance) {
      checkout.set("minDate", dateStr); // Prevent earlier checkout
    }
  });

  const checkout = flatpickr("#checkout", {
    minDate: "today",
    dateFormat: "Y-m-d"
  });
</script>

</body>
</html>
