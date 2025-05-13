let assign_room_form = document.getElementById("assign-room-form");

assign_room_form.addEventListener("submit", function(e) {
    e.preventDefault();
    allotRoom();
});

function getBookings(search="") {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/new_booking.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("table-data").innerHTML = this.responseText;
    }
    
    xhr.send("get-bookings&search="+search);
}

function assignRoom(id) {
    assign_room_form.elements["booking_id"].value = id;
}

function allotRoom() {
    let data = new FormData();
    data.append("room-no", assign_room_form.elements["room_no"].value);
    data.append("booking-id", assign_room_form.elements["booking_id"].value);
    data.append("assign-room", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/new_booking.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("assign-room");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "Room number alloted, booking finalized.");
            assign_room_form.reset();
            getBookings();
        } else {
            alert("error", "Couldn't assign room number!");
        }
    }

    xhr.send(data);
}

function cancelBooking(id) {
    if (confirm("are you sure you want to cancel this booking?")) {
        let data = new FormData();
        data.append("booking-id", id);
        data.append("cancel-booking", "");

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/new_booking.php", true);
    
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("success", "Booking cancelled.");
                getBookings();
            } else {
                alert("error", "Failed to cancel this booking!");
            }
        }
    
        xhr.send(data);
    }
}

window.onload = function() {
    getBookings();
}