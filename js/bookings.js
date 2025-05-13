function cancelBooking(id) {
    if (confirm("Are you sure you want to cancel this booking")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/bookings.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            if (this.responseText == 1) {
                window.location.href = "bookings.php?cancel-status=true";
            } else {
                alert("error", "Cancellation failed!");
            }
        }

        xhr.send("cancel-booking&id="+id);
    }
}