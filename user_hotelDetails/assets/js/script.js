    const hotels = {
      legaspi: {
        name: "Crown Hotel at Legaspi",
        location: "Pasay City, Metro Manila",
        rating: "⭐⭐⭐⭐ 176 Ratings",
        note: "Take note that all rooms are non-smoking. Balcony use allowed.",
        images: [
          "../hotel list/assets/img/28.png",
          "./assets/img/31.png",
          "./assets/img/34.png",
          "./assets/img/32.png"
        ]
      },
      westside: {
        name: "Crown Hotel at Westside City Tambo",
        location: "Parañaque, Metro Manila",
        rating: "⭐⭐⭐⭐ 210 Ratings",
        note: "Balcony and smoking area available upon request.",
        images: [
          "../hotel list/assets/img/29.png",
          "./assets/img/west (2).png",
          "./assets/img/west (1).png",
          "./assets/img/32.png"
        ]
      },
      espino: {
        name: "Crown Hotel at General Espino",
        location: "Taguig, Metro Manila",
        rating: "⭐⭐⭐⭐ 360 Ratings",
        note: "Pet-friendly rooms available.",
        images: [
          "../hotel list/assets/img/30.png",
          "./assets/img/31.png",
          "./assets/img/espino.png",
          "./assets/img/32.png"
        ]
      },
      antipolo: {
        name: "Crown Hotel at San Roque",
        location: "San Roque, Antipolo",
        rating: "⭐⭐⭐ 85 Ratings",
        note: "Surrounded by nature. Accessible to city and mountains.",
        images: [
          "../hotel list/assets/img/antipolo.png",
          "./assets/img/31.png",
          "./assets/img/espino.png",
          "./assets/img/32.png"
        ]
      },
      laguna: {
        name: "Crown Hotel at Tatlong Hari",
        location: "Tatlong Hari, Laguna",
        rating: "⭐⭐⭐⭐ 120 Ratings",
        note: "Enjoy mountain views and free shuttle from town center.",
        images: [
          "../hotel list/assets/img/laguna.png",
          "./assets/img/31.png",
          "./assets/img/32.png",
          "./assets/img/34.png"
        ]
      }
    };

    const rooms = [
      { name: "Standard Room", price: 1200, image: "./assets/img/room-standard.png", persons: "1–3 persons" },
      { name: "Deluxe Room", price: 1350, image: "./assets/img/deluxe.png", persons: "2–4 persons" },
      { name: "Superior Room", price: 1500, image: "./assets/img/superior.png", persons: "2–4 persons" },
      { name: "Suite Room", price: 1600, image: "./assets/img/superior1.png", persons: "3–7 persons" }
    ];

    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    const hotel = hotels[id];

    if (!hotel) {
      document.body.innerHTML = "<h2 style='padding: 2rem'>Hotel not found.</h2>";
    } else {
      document.querySelector(".hotel-info h2").innerText = hotel.name;
      document.querySelector(".hotel-info .rating").innerText = hotel.rating;
      document.querySelector(".hotel-info .location").innerText = hotel.location;
      document.querySelector(".hotel-info .note").innerText = hotel.note;

      const carousel = document.querySelector(".carousel");
      carousel.innerHTML = "";
      hotel.images.forEach(src => {
        const img = document.createElement("img");
        img.src = src;
        img.style.objectFit = "cover";
        img.style.width = "100%";
        img.style.height = "300px";
        carousel.appendChild(img);
      });

      const roomSection = document.querySelector(".room-section");
      roomSection.innerHTML = "";
      rooms.forEach(room => {
        const div = document.createElement("section");
        div.className = "room-card";
        div.innerHTML = `
          <div class="room-image-container">
            <img src="${room.image}" alt="${room.name}" />
          </div>
          <div class="room-details">
            <h3>${room.name}</h3>
            <p class="stars">⭐⭐⭐⭐⭐</p>
            <p class="persons">${room.persons}</p>
            <ul class="amenities">
              <li>✓ Free Breakfast</li>
              <li>✓ Free Wifi</li>
              <li>✓ Free Use of Amenities</li>
              <li>✓ Free Parking</li>
            </ul>
          </div>
          <div class="room-price">
            <p>Start at</p>
            <h2>₱${room.price}</h2>
            <small>Included Tax</small>
            <a href="../payment/payment.php?hotel=Crown%20Hotel%20at%20Legaspi&room=Standard%20Room&guests=2&checkin=2025-07-12&checkout=2025-07-14&price=1200" class="btn book-now">Book Now</a>
          </div>`;
        roomSection.appendChild(div);
      });
    }