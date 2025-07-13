const id = new URLSearchParams(window.location.search).get('id');

const hotels = {
  legaspi: {
    name: "Crown Hotel at Legaspi",
    location: "Pasay City, Metro Manila",
    rating: "⭐⭐⭐⭐ 176 Ratings",
    note: "Take note that all rooms are non-smoking. Balcony use allowed.",
    images: [
      "./assets/img/28.png",
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
      "./assets/img/29.png",
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
      "./assets/img/30.png",
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
      "./assets/img/antipolo.png",
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
      "./assets/img/laguna.png",
      "./assets/img/31.png",
      "./assets/img/32.png",
      "./assets/img/34.png"
    ]
  }
};

const prices = {
  legaspi: { "Standard Room": 1200, "Deluxe Room": 1350, "Superior Room": 1500, "Suite Room": 2000 },
  westside: { "Standard Room": 1400, "Deluxe Room": 1550, "Superior Room": 1700, "Suite Room": 2200 },
  espino: { "Standard Room": 1350, "Deluxe Room": 1450, "Superior Room": 1600, "Suite Room": 2100 },
  antipolo: { "Standard Room": 1480, "Deluxe Room": 1650, "Superior Room": 1800, "Suite Room": 2300 },
  laguna: { "Standard Room": 1100, "Deluxe Room": 1300, "Superior Room": 1600, "Suite Room": 1900 }
};

const roomTemplates = [
  { name: "Standard Room", image: "./assets/img/room-standard.png", persons: "2 persons max" },
  { name: "Deluxe Room", image: "./assets/img/deluxe.png", persons: "3 persons max" },
  { name: "Superior Room", image: "./assets/img/superior1.png", persons: "4 persons max" },
  { name: "Suite Room", image: "./assets/img/superior.png", persons: "5 persons max" }
];

// Load hotel data
const hotel = hotels[id];
if (!hotel) {
  document.body.innerHTML = "<h2>Hotel not found.</h2>";
  throw new Error("Invalid hotel ID");
}

document.getElementById("hotel-name").textContent = hotel.name;
document.getElementById("hotel-rating").textContent = hotel.rating;
document.getElementById("hotel-location").textContent = hotel.location;
document.getElementById("hotel-note").textContent = hotel.note;

// Load images
const gallery = document.getElementById("image-scroll");
if (hotel.images && hotel.images.length > 0) {
  hotel.images.forEach(src => {
    const img = document.createElement("img");
    img.src = src;
    img.alt = hotel.name;
    gallery.appendChild(img);
  });
} else {
  gallery.innerHTML = "<p>No images available.</p>";
}


// Load room cards
const roomSection = document.querySelector(".room-section");
roomTemplates.forEach(room => {
  const price = prices[id][room.name];
  const div = document.createElement("section");
  div.className = "room-card";
  div.innerHTML = `
    <div class="room-image-container"><img src="${room.image}" alt="${room.name}" /></div>
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
      <h2>₱${price}</h2>
      <small>Included Tax</small>
      <a href="../BookNow/index.php?hotel=${encodeURIComponent(hotel.name)}&room=${encodeURIComponent(room.name)}&price=${price}&location=${encodeURIComponent(hotel.location)}" class="btn book-now">Book Now</a>
    </div>`;
  roomSection.appendChild(div);
});