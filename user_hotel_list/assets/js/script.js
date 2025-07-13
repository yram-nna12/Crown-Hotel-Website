 const today = new Date().toISOString().split('T')[0];
    const checkin = document.querySelector("input[name='checkin']");
    const checkout = document.querySelector("input[name='checkout']");

    checkin.min = today;
    checkout.min = today;

    checkin.addEventListener('change', () => {
      checkout.min = checkin.value;
    });

    const hotels = [
      {
        id: "legaspi",
        name: "Crown Hotel at Legaspi",
        location: "Pasay City, Metro Manila",
        rating: "⭐⭐⭐⭐ 176 Ratings",
        price: 1200,
        image: "./assets/img/28.png"
      },
      {
        id: "westside",
        name: "Crown Hotel at Westside City Tambo",
        location: "Parañaque, Metro Manila",
        rating: "⭐⭐⭐⭐ 210 Ratings",
        price: 1400,
        image: "./assets/img/29.png"
      },
      {
        id: "espino",
        name: "Crown Hotel at General Espino",
        location: "Taguig, Metro Manila",
        rating: "⭐⭐⭐⭐ 360 Ratings",
        price: 1350,
        image: "./assets/img/30.png"
      },
      {
        id: "antipolo",
        name: "Crown Hotel at San Roque",
        location: "San Roque, Antipolo",
        rating: "⭐⭐⭐⭐ 155 Ratings",
        price: 1500,
        image: "./assets/img/antipolo.png"
      },
      {
        id: "laguna",
        name: "Crown Hotel at Tatlong Hari",
        location: "Tatlong Hari, Laguna",
        rating: "⭐⭐⭐⭐ 189 Ratings",
        price: 1600,
        image: "./assets/img/laguna.png"
      }
    ];

    const list = document.querySelector(".hotel-list");

    function renderHotels(filteredHotels) {
      list.innerHTML = "";

      if (filteredHotels.length === 0) {
        list.innerHTML = "<p>No hotels found for the selected location.</p>";
        return;
      }

      filteredHotels.forEach(hotel => {
        const card = document.createElement("div");
        card.className = "hotel-card";
        card.style.display = "flex";
        card.innerHTML = `
          <img src="${hotel.image}" alt="${hotel.name}">
          <div class="hotel-info">
            <h3>${hotel.name}</h3>
            <p><strong>${hotel.location}</strong><br>${hotel.rating}<br>This property offers</p>
            <div class="tags">
              <span>Free Parking</span>
              <span>Free Breakfast</span>
            </div>
          </div>
          <div class="price">
            ₱${hotel.price}<br><small>Included Tax</small>
          </div>
        `;
        card.addEventListener("click", () => {
          window.location.href = `../user_hotelDetails/index.php?id=${hotel.id}`;
        });
        list.appendChild(card);
      });
    }

    // Filter on load if coming from previous page
    const params = new URLSearchParams(window.location.search);
    const locationQuery = (params.get("location") || "").toLowerCase();

    if (locationQuery) {
      const filtered = hotels.filter(h =>
        h.location.toLowerCase().includes(locationQuery) ||
        h.name.toLowerCase().includes(locationQuery)
      );
      renderHotels(filtered);
    } else {
      renderHotels(hotels); // show all if no filter
    }

    document.getElementById("searchForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const selectedLocation = this.location.value.toLowerCase();
      const filtered = hotels.filter(h =>
        h.location.toLowerCase().includes(selectedLocation) ||
        h.name.toLowerCase().includes(selectedLocation)
      );
      renderHotels(filtered);
    });

