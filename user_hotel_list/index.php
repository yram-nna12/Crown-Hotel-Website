<?php
session_start();
// Optional: Add login check here
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hotel Listings</title>
  <link rel="stylesheet" href="./assets/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header class="topbar">
    <div class="logo">
      <img src="../assets/img/LOGO.png" alt="Crown Tower Logo">
    </div>
    <nav class="nav-links">
      <a href="#" class="btn booking" style="color: #0a2240;">Booking</a>
      <a href="../ClientLandingPage/index.php" class="btn home">Home</a>
      <a href="../AccountDetails/account.php" class="btn home">Account</a>
    </nav>
  </header>

  <form action="" method="GET" class="search-bar">
  <div class="field">
    <label class="form-label">Location</label>
    <select name="location" required class="location-dropdown">
      <option value="">-- Select Location --</option>
      <option value="Metro Manila">Metro Manila</option>
      <option value="Antipolo">Antipolo</option>
      <option value="Laguna">Laguna</option>
    </select>
  </div>
  <div class="field">
  <label class="form-label">Check In</label>
  <input type="text" name="checkin" id="checkin-date" placeholder="Select date" required />
</div>
<div class="field">
  <label class="form-label">Check Out</label>
  <input type="text" name="checkout" id="checkout-date" placeholder="Select date" required />
</div>

  <div class="field">
    <label class="form-label">Guest</label>
    <input type="number" name="guests" placeholder="How many are you" min="1" required />
  </div>
  <button type="submit" class="search-btn" title="Search">
    <img src="./assets/img/SEARCH.png" alt="Search" />
  </button>
</form>


  <div class="hotel-list"></div>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-left">
        <img src="../assets/img/LOGO.png" alt="Crown Hotel Logo" class="footer-logo">
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
    <div class="footer-line"></div>
    <div class="footer-bottom">
      <span>@2025 CrownHotel All Rights Reserved</span>
      <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Condition</a>
      </div>
    </div>
  </footer>
  <script src=" ./assets/js/script.js "></script>
<!-- Load Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  const checkin = flatpickr("#checkin-date", {
    dateFormat: "Y-m-d",
    minDate: "today",
    onChange: function(selectedDates, dateStr) {
      if (dateStr) {
        checkout.set("minDate", dateStr);
      }
    }
  });

  const checkout = flatpickr("#checkout-date", {
    dateFormat: "Y-m-d",
    minDate: "today",
  });
</script>

</body>
</html>
