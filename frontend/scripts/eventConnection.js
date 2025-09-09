// Disable Past & Selected Dates

const startInput = document.getElementById('startDate');
const endInput = document.getElementById('endDate');

const today = new Date();

// Format

function formatDate(date){
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

// Set Today's Date as min check-in

startInput.setAttribute('min', formatDate(today));

// Set tommorows date as min check-out

const tomorrow = new Date(today);
tomorrow.setDate(tomorrow.getDate() + 1);
endInput.setAttribute('min', formatDate(tomorrow));


// When check-in changes, updates check-out

startInput.addEventListener('change', function() {
    const startInputDate = new Date(this.value);

    startInputDate.setDate(startInputDate.getDate() + 1);
    const minendInputDate = formatDate(checkInDate);
    endInput.setAttribute('min', minendInputDate);

    // If check-out is before new min, clear it

    if (startInput.value && endInput.value < minendInputDate){
        endInput.value ="";
    }
});


// For Event Reservation
document.getElementById("eventBookingForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    let form = new FormData(this);

    try {
        let response = await fetch("http://127.0.0.1:8000/api/eventReservation", {
            method: "POST",
            body: form
        });

        if (!response.ok) {
            throw new Error("HTTP error! Status: " + response.status);
        }

        let result = await response.json();

        document.getElementById("response").innerText = result.message;
        console.log("Success:", result);

    } catch (error) {
        console.error("Error:", error);
        document.getElementById("response").innerText = "Error: " + error.message;
    }
});

//Modals
  
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

    function openPaymentModal() {
      document.getElementById('paymentModal').classList.remove('hidden');
    }


  //Pages  

  //Room Reservation Page
  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("roomReser");


  btn.addEventListener("click", () => {
    window.location.href = "./RoomReser.html"; // go to another page
  });
});

  //Cottage Reservation Page
  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("cottageReser");


  btn.addEventListener("click", () => {
    window.location.href = "#"; // go to another page
  });
});

//Event Reservation Page

  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("eventReser");


  btn.addEventListener("click", () => {
    window.location.href = "./EventReser.html"; // go to another page
  });
});


//Food Order Page

  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("foodOrder");


  btn.addEventListener("click", () => {
    window.location.href = "./FarmOrders.html"; // go to another page
  });
});

//Farm Order Page

  document.addEventListener("DOMContentLoaded", () => {
  
  const btn = document.getElementById("farmOrder");


  btn.addEventListener("click", () => {
    window.location.href = "./FarmOrders.html"; // go to another page
  });
});