let reviewForm = document.getElementById("review-form");

function cancelBooking(id){
    if(confirm("Are you sure You want to Cancel Your Booking?")){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/cancel_booking.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 300){
                if(this.responseText == 1){
                    window.location.href = "bookings.php?cancelStatus=true";
                }else{
                    alert("error", "Cancellation Failed!");
                }
            }else{
                console.error("Request failed with status : ", xhr.status);
            }
        }
        xhr.onerror = function(){
            console.error("Network error occurred!");
        }
        xhr.send("cancelBooking&id="+id);
    }
}

function reviewBooking(bookingId, roomId){
    reviewForm.elements["booking_id"].value = bookingId;
    reviewForm.elements["room_id"].value = roomId;
}

reviewForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let data = new FormData();
    data.append("review-form", "");
    data.append("rating", reviewForm.elements["rating"].value);
    data.append("review", reviewForm.elements["review"].value);
    data.append("booking_id", reviewForm.elements["booking_id"].value);
    data.append("room_id", reviewForm.elements["room_id"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/review_room.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            var myModal = document.getElementById("reviewModal");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if(this.responseText == 1){
                window.location.href = "bookings.php?review_status=true";
            }else{
                alert("error", "Rating and Review Failed!");
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