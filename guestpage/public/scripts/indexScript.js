// --- Modal Functions ---
function openReserModal() {
  document.getElementById('reservationModal').classList.remove('hidden');
}

function closeReserModal() {
  document.getElementById('reservationModal').classList.add('hidden');
}

function openOrderModal() {
  document.getElementById('orderModal').classList.remove('hidden');
}

function closeOrderModal() {
  document.getElementById('orderModal').classList.add('hidden');
}

// --- Close Modal When Clicking Outside ---
document.addEventListener("click", function (event) {
  const reservationModal = document.getElementById("reservationModal");
  const orderModal = document.getElementById("orderModal");

  // If Reservation Modal is open and user clicks outside the content box
  if (!reservationModal.classList.contains("hidden") &&
      event.target === reservationModal) {
    closeReserModal();
  }

  // If Order Modal is open and user clicks outside the content box
  if (!orderModal.classList.contains("hidden") &&
      event.target === orderModal) {
    closeOrderModal();
  }
  // --- Close Modal When Pressing ESC ---
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeReserModal();
    closeOrderModal();
  }
});
});


  //Pages  

  //Room Reservation Page
  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("roomReser");


  btn.addEventListener("click", () => {
    window.location.href = "./pages/RoomReser.html"; // go to another page
  });
});

  //Cottage Reservation Page
  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("roomReser");


  btn.addEventListener("click", () => {
    window.location.href = "./pages/RoomReser.html"; // go to another page
  });
});

//Event Reservation Page

  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("eventReser");


  btn.addEventListener("click", () => {
    window.location.href = "./pages/EventReser.html"; // go to another page
  });
});


//Food Order Page

  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("foodOrder");


  btn.addEventListener("click", () => {
    window.location.href = "./pages/FarmOrders.html"; // go to another page
  });
});

//Farm Order Page

  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("farmOrder");


  btn.addEventListener("click", () => {
    window.location.href = "./pages/FarmOrders.html"; // go to another page
  });
});

// --- Flatpickr  ---
const flatpickrScript = document.createElement("script");
flatpickrScript.src = "https://cdn.jsdelivr.net/npm/flatpickr";
document.head.appendChild(flatpickrScript);

flatpickrScript.onload = () => {
  const checkInInput = document.getElementById("checkIn");
  const checkOutInput = document.getElementById("checkOut");

  // Single Flatpickr controlling both fields
  const picker = flatpickr(checkInInput, {
    mode: "range",
    dateFormat: "Y-m-d",
    minDate: "today",
    showMonths: 2, 
    onClose: function (selectedDates) {
      if (selectedDates.length === 1) {
        // Auto set checkout as the next day
        const nextDay = new Date(selectedDates[0]);
        nextDay.setDate(nextDay.getDate() + 1);
        picker.setDate([selectedDates[0], nextDay], true);
        checkInInput.value = selectedDates[0].toLocaleDateString();
        checkOutInput.value = nextDay.toLocaleDateString();
      }
      if (selectedDates.length === 2) {
        // Update inputs
        checkInInput.value = selectedDates[0].toLocaleDateString();
        checkOutInput.value = selectedDates[1].toLocaleDateString();
      }
    }
  });

  // Make Check-Out input also open the same calendar
  checkOutInput.addEventListener("click", () => picker.open());
};


