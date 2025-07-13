<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hotel Details - Crown Hotel</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .image-gallery {
  overflow-x: auto;
  white-space: nowrap;
  padding: 20px 40px;
  margin-bottom: 2rem;
  scroll-behavior: smooth;
}

.image-scroll {
  display: flex;
  gap: 16px;
}

.image-scroll img {
  height: 250px;
  width: auto;
  border-radius: 12px;
  object-fit: cover;
  flex-shrink: 0;
  transition: transform 0.2s;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.image-scroll img:hover {
  transform: scale(1.05);
}

</style>
<body>
  <header class="topbar">
    <div class="logo">
            <img src="./assets/img/LOGO.png" alt="Crown Tower Logo">
        </div>
  <nav class="nav-links">

  <?php if (isset($_SESSION['user_id'])): ?>
    <a href="../user_hotel_list/index.php" class="btn booking">Booking</a>
    <a href="../ClientLandingPage/index.php" class="btn home">Home</a>
    <a href="../AccountDetails/index.php" class="btn home">My Account</a>
  <?php else: ?>
    <a href="../LoginPage/index.php" class="btn login" style="color: #0a2240;">Log in</a>
    <a href="../Signup_page/index.php" class="btn signup">Sign up</a>
  <?php endif; ?>
  </header>

  <section class="image-gallery">
  <div class="image-scroll" id="image-scroll"></div>
</section>


  <section class="hotel-info">
    <h2 id="hotel-name"></h2>
    <p class="rating" id="hotel-rating"></p>
    <p class="location" id="hotel-location"></p>
    <p class="note" id="hotel-note"></p>
  </section>

  <div class="room-section"></div>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-left">
        <img src="../assets/img/LOGO.png" alt="Crown Hotel Logo" class="footer-logo">
        <p class="footer-description">Offers a seamless stay with elegant rooms, warm hospitality, and everything you need to relax or recharge.</p>
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

<script src="./assets/js/script.js"></script>
</body>
</html>
