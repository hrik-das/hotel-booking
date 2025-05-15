function bookingAnalytics(period=1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/dashboard.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);

        document.getElementById("total-bookings").textContent = data.total_bookings;
        document.getElementById("total-amount").textContent = "₹" + data.total_amount;
        document.getElementById("active-bookings").textContent = data.active_bookings;
        document.getElementById("active-amount").textContent = "₹" + data.active_amount;
        document.getElementById("cancelled-bookings").textContent = data.cancelled_bookings;
        document.getElementById("cancelled-amount").textContent = "₹" + data.cancelled_amount;
    }
    
    xhr.send("booking-analytics&period="+period);
}

function userAnalytics(period=1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/dashboard.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        document.getElementById("total-registration").textContent = data.total_registration;
        document.getElementById("queries").textContent = data.total_queries;
        document.getElementById("reviews").textContent = data.total_reviews;
    }
    
    xhr.send("user-analytics&period="+period);
}

window.onload = function() {
    bookingAnalytics();
    userAnalytics();
}