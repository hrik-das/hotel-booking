function getBookings(search=""){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/refund_bookings.php", true);
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

function refundBooking(id){
    if(confirm("Are Your Sure You want to Refund Money for this Booking?")){
        let data = new FormData();
        data.append("booking_id", id);
        data.append("refundBookings", "");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/refund_bookings.php", true);
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 300){
                if(this.responseText == 1){
                    alert("success", "Refunded Successfully!");
                    getBookings();
                }else{
                    alert("error", "Failed to Refund!");
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