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