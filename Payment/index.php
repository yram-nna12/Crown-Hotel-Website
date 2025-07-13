<?php
session_start();

// Safely extract booking session data
$transaction_id = $_SESSION['transaction_id'] ?? 'Unavailable';
$first_name     = $_SESSION['first_name'] ?? 'Guest';
$last_name      = $_SESSION['last_name'] ?? '';
$full_name      = trim($first_name . ' ' . $last_name);
$email          = $_SESSION['email'] ?? 'No email';
$contact        = $_SESSION['contact'] ?? 'No contact';
$check_in       = $_SESSION['check_in'] ?? 'N/A';
$check_out      = $_SESSION['check_out'] ?? 'N/A';
$room_type      = $_SESSION['room_type'] ?? 'Standard Room';
$total_price    = $_SESSION['total_price'] ?? 0.00;
$hotel_name     = $_SESSION['selected_hotel_name'] ?? 'Crown Hotel';
$location       = $_SESSION['selected_hotel_location'] ?? 'Metro Manila';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Page</title>
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
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="../user_hotel_list/index.php" class="btn">Booking</a>
      <a href="../ClientLandingPage/index.php" class="btn">Home</a>
      <a href="../AccountDetails/index.php" class="btn">My Account</a>
    <?php else: ?>
      <a href="../index.php">Home</a>
      <a href="../AboutUs/index.php">About Us</a>
      <a href="../LoginPage/index.php" class="btn login">Log in</a>
      <a href="../Signup_page/index.php" class="btn signup">Sign up</a>
    <?php endif; ?>
  </nav>
</header>

<main class="payment">
  <div class="left-panel">
    <div class="payment-method-container">
      <h3>Payment Method</h3>
      <h5 class="cancellation-policy">
        Cancellations are subject to a penalty: 20% of the room rate if cancelled within 2 days of check-in,
        15% if cancelled 4 days prior, and 10% if cancelled 5 days or more in advance.
      </h5>

      <p class="method-label">E-Wallet / E-Money</p>
      <div class="payment-buttons">
        <button class="gcash">Gcash</button>
        <button class="paymaya">Paymaya</button>
        <button class="gotyme">GoTyme</button>
      </div>

      <p class="method-label">Credit / Debit Card</p>
      <div class="payment-buttons">
        <button class="bdo">BDO</button>
        <button class="bpi">BPI</button>
        <button class="metrobank">Metrobank</button>
      </div>
    </div>
  </div>

  <div class="right-panel">
    <div class="booking-box">
      <h3><?= htmlspecialchars($hotel_name) ?></h3>
      <p class="location"><?= htmlspecialchars($location) ?></p>

      <div class="info-box">Transaction ID: <?= htmlspecialchars($transaction_id) ?></div>
      <div class="info-box">Name: <?= htmlspecialchars($full_name) ?></div>
      <div class="info-box">Email: <?= htmlspecialchars($email) ?></div>
      <div class="info-box">Contact: <?= htmlspecialchars($contact) ?></div>
      <div class="info-box">Check-in: <?= htmlspecialchars($check_in) ?></div>
      <div class="info-box">Check-out: <?= htmlspecialchars($check_out) ?></div>
      <div class="info-box">Room Type: <?= htmlspecialchars($room_type) ?></div>

      <div class="total-section">
        <p class="total-label">Total Payment<br><span>Includes Tax</span></p>
        <p class="price">₱<?= number_format($total_price, 2) ?></p>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
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
  <div class="footer-line"></div>
  <div class="footer-bottom">
    <span>@2025 CrownHotel All Rights Reserved</span>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Conditions</a>
    </div>
  </div>
</footer>

<!-- POPUP PAYMENT FORM -->
<div id="payment-popup" class="popup-overlay">
  <div class="popup-content">
    <span id="close-popup" class="close-btn">&times;</span>
    <h2>AMOUNT TO BE PAID</h2>
    <p class="payment-note">Total Payment<br><strong>₱<?= number_format($total_price, 2) ?></strong></p>
    <input type="text" placeholder="Number">
    <input type="text" placeholder="Full Name">
    <p class="secure-msg">Your payment is 100% secure. All processes are encrypted.</p>
    <form action="confirm_payment.php" method="POST">
  <button type="submit" class="confirm-btn">CONFIRM PAYMENT</button>
</form>

  </div>
</div>

<!-- CARD POPUP FOR BANK PAYMENTS -->
<div class="popup-overlay" id="card-popup">
  <div class="popup-content">
    <span class="close-btn" id="close-card-popup">&times;</span>
    <h2>AMOUNT TO BE PAID</h2>
    <p class="payment-note">Total Payment<br><strong>₱<?= number_format($total_price, 2) ?></strong></p>
    <input type="text" placeholder="Card Number" maxlength="19" />
    <div style="display: flex; gap: 10px;">
      <input type="text" placeholder="Expiry MM/YY" maxlength="5" />
      <input type="text" placeholder="CVV" maxlength="3" />
    </div>
    <input type="text" placeholder="Full Name" />
    <p class="secure-msg">Your payment is 100% secure and encrypted. Contact customer support if issues arise.</p>
    <form action="confirm_payment.php" method="POST">
  <button type="submit" class="confirm-btn">CONFIRM PAYMENT</button>
</form>

  </div>
</div>
<script>
    const ewalletButtons = document.querySelectorAll('.gcash, .paymaya, .gotyme');
const cardButtons = document.querySelectorAll('.bdo, .bpi, .metrobank');
const popupEwallet = document.getElementById('payment-popup');
const popupCard = document.getElementById('card-popup');
const closeEwallet = document.getElementById('close-popup');
const closeCard = document.getElementById('close-card-popup');

ewalletButtons.forEach(button => {
  button.addEventListener('click', () => popupEwallet.style.display = 'flex');
});
cardButtons.forEach(button => {
  button.addEventListener('click', () => popupCard.style.display = 'flex');
});

closeEwallet.addEventListener('click', () => popupEwallet.style.display = 'none');
closeCard.addEventListener('click', () => popupCard.style.display = 'none');

window.addEventListener('click', e => {
  if (e.target === popupEwallet) popupEwallet.style.display = 'none';
  if (e.target === popupCard) popupCard.style.display = 'none';
});
</script>
</body>
</html>
