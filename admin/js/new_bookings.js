let assignRoomForm = document.getElementById("assign-room-form");

function getBookings(search=""){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/new_bookings.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            document.getElementById("table-data").innerHTML = this.responseText;
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("getBookings&search="+search);
}

function assignRoom(id){
    assignRoomForm.elements["booking_id"].value = id;
}

assignRoomForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let data = new FormData();
    data.append("room_number", assignRoomForm.elements["room_number"].value);
    data.append("booking_id", assignRoomForm.elements["booking_id"].value);
    data.append("assignRoom", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/new_bookings.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            var myModal = document.getElementById("assignRoom");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if(this.responseText == 1){
                alert("success", "Room Number Alloted Successfully!");
                getBookings();
                assignRoomForm.reset();
            }else{
                alert("error", "Room Cannot Assigned!");
            }
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send(data);
});

function cancelBooking(id){
    if(confirm("You want to Cancel this Booking. Are Your Sure?")){
        let data = new FormData();
        data.append("booking_id", id);
        data.append("cancelBooking", "");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/new_bookings.php", true);
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 300){
                if(this.responseText == 1){
                    alert("success", "Room Booking Removed Successfully!");
                    getBookings();
                }else{
                    alert("error", "Room Booking Cancelling Failed!");
                }
            }else{
                console.error("Request failed with status : ", xhr.status);
            }
        }
        xhr.onerror = function(){
            console.error("Network error occurred!");
        }
        xhr.send(data);
    }
}

window.onload = function(){
    getBookings();
}