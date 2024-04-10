let bookingForm = document.getElementById("booking-form");
let payInfo = document.getElementById("pay-info");
let infoLoader = document.getElementById("info-loader");

function checkAvailability(){
    let checkInValue = bookingForm.elements["checkin"].value;
    let checkOutValue = bookingForm.elements["checkout"].value;
    bookingForm.elements["paynow"].setAttribute("disabled", true);
    if(checkInValue != "" && checkOutValue != ""){
        payInfo.classList.add("d-none");
        payInfo.classList.replace("text-dark", "text-danger");
        infoLoader.classList.remove("d-none");
        let data = new FormData();
        data.append("checkAvailability", "");
        data.append("checkin", checkInValue);
        data.append("checkout", checkOutValue);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/confirm_booking.php", true);
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 400){
                try{
                    let data = JSON.parse(this.responseText);
                    if(data.status == "Check_in_out_equal"){
                        payInfo.innerText = "You Can't Check Out on the Same Date!";
                    }else if(data.status == "Check_out_earlier"){
                        payInfo.innerText = "Check Out Date is Earlier than Check In Date!";
                    }else if(data.status == "Check_in_earlier"){
                        payInfo.innerText = "Check In Date is Earlier than Today's Date!";
                    }else if(data.status == "unavailable"){
                        payInfo.innerText = "Room not available to this Check In Date!";
                    }else{
                        payInfo.innerHTML = "Number of Days: "+data.days+"<br> Total Amount to Pay: ₹"+data.payment;
                        payInfo.classList.replace("text-danger", "text-dark");
                        bookingForm.elements["paynow"].removeAttribute("disabled");
                    }
                    payInfo.classList.remove("d-none");
                    infoLoader.classList.add("d-none");
                }catch(error){
                    console.error("Error parsing JSON : ", error);
                }
            }else{
                console.error("Request failed with status : ", xhr.status);
            }
        }
        xhr.send(data);
    }
}