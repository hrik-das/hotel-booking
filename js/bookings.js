let review_form = document.getElementById("review-form");

review_form.addEventListener("submit", function(e) {
    e.preventDefault();
    sendReview();
});

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

function reviewRoom(booking_id, room_id) {
    review_form.elements["booking_id"].value = booking_id;
    review_form.elements["room_id"].value = room_id;
}

function sendReview() {
    let data = new FormData();
    data.append("rating", review_form.elements["rating"].value);
    data.append("review", review_form.elements["review"].value);
    data.append("booking-id", review_form.elements["booking_id"].value);
    data.append("room-id", review_form.elements["room_id"].value);
    data.append("review-form", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/review.php", true);

    xhr.onload = function() {
        if (this.responseText == 1) {
            window.location.href = "bookings.php?review-status=true";
        } else {
            var myModal = document.getElementById("reviewModal");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            alert("error", "Failed to rate and review this booking!");
        }
    }

    xhr.send(data);
}