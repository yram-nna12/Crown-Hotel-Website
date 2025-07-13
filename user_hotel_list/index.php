<?php
session_start();
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

  <form id="searchForm" class="search-bar">
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

    const hotels = [
      { id: "legaspi", name: "Crown Hotel at Legaspi", location: "Pasay City, Metro Manila", rating: "⭐⭐⭐⭐ 176 Ratings", price: 1200, image: "./assets/img/28.png" },
      { id: "westside", name: "Crown Hotel at Westside City Tambo", location: "Parañaque, Metro Manila", rating: "⭐⭐⭐⭐ 210 Ratings", price: 1400, image: "./assets/img/29.png" },
      { id: "espino", name: "Crown Hotel at General Espino", location: "Taguig, Metro Manila", rating: "⭐⭐⭐⭐ 360 Ratings", price: 1350, image: "./assets/img/30.png" },
      { id: "antipolo", name: "Crown Hotel at San Roque", location: "San Roque, Antipolo", rating: "⭐⭐⭐⭐ 155 Ratings", price: 1480, image: "./assets/img/antipolo.png" },
      { id: "laguna", name: "Crown Hotel at Tatlong Hari", location: "Tatlong Hari, Laguna", rating: "⭐⭐⭐⭐ 189 Ratings", price: 1100, image: "./assets/img/laguna.png" }
    ];

    const list = document.querySelector(".hotel-list");

    function renderHotels(filtered) {
      list.innerHTML = "";
      if (filtered.length === 0) {
        list.innerHTML = "<p>No hotels found for the selected location.</p>";
        return;
      }

      filtered.forEach(hotel => {
        const card = document.createElement("div");
        card.className = "hotel-card";
        card.style.display = "flex";
        card.innerHTML = `
          <img src="${hotel.image}" alt="${hotel.name}">
          <div class="hotel-info">
            <h3>${hotel.name}</h3>
            <p><strong>${hotel.location}</strong><br>${hotel.rating}</p>
            <div class="tags">
              <span>Free Parking</span>
              <span>Free Breakfast</span>
            </div>
          </div>
          <div class="price">₱${hotel.price}<br><small>Included Tax</small></div>
        `;
        card.addEventListener("click", () => {
          window.location.href = `../user_hotelDetails/index.php?id=${hotel.id}`;
        });
        list.appendChild(card);
      });
    }

    const params = new URLSearchParams(window.location.search);
    const locationQuery = (params.get("location") || "").toLowerCase();
    renderHotels(hotels.filter(h => h.location.toLowerCase().includes(locationQuery)));

    document.getElementById("searchForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const loc = this.location.value.toLowerCase();
      renderHotels(hotels.filter(h => h.location.toLowerCase().includes(loc)));
    });
  </script>
</body>
</html>
