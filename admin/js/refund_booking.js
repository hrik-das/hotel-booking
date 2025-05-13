function getBookings(search="") {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/refund_booking.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("table-data").innerHTML = this.responseText;
    }
    
    xhr.send("get-bookings&search="+search);
}

function refundBooking(id) {
    if (confirm("Are you sure you want to refund the booking amount for this booking?")) {
        let data = new FormData();
        data.append("booking-id", id);
        data.append("refund-booking", "");
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/refund_booking.php", true);
    
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("success", "The amount refunded for this booking.");
                getBookings();
            } else {
                alert("error", "Couldn't refund the amount!");
            }
        }
    
        xhr.send(data);
    }
}

window.onload = function() {
    getBookings();
}