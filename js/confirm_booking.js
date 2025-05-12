let loader = document.getElementById("info-loader");
let payment_info = document.getElementById("payment-info");
let booking_form = document.getElementById("booking-form");

function checkAvailability() {
    let checkin_date = booking_form.elements["checkin"].value;
    let checkout_date = booking_form.elements["checkout"].value;
    booking_form.elements["payment"].setAttribute("disabled", true);

    if (checkin_date != "" && checkout_date != "") {
        payment_info.classList.add("d-none");
        payment_info.classList.replace("text-dark", "text-danger");
        loader.classList.remove("d-none");
        booking_form.elements["payment"].classList.replace("text-light", "text-dark");

        let data = new FormData();
        data.append("check-in", checkin_date);
        data.append("check-out", checkout_date);
        data.append("check-availability", "");

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/confirm_booking.php", true);

        xhr.onload = function() {
            let data = JSON.parse(this.responseText);

            if (data.status == "equal-check-in-out-date") {
                payment_info.innerText = "You won't be able to check out on same day!";
            } else if (data.status == "earlier-check-out-date") {
                payment_info.innerText = "Check-out date is earlier than the check-in date!";
            } else if (data.status == "earlier-check-in-date") {
                payment_info.innerText = "Check-in date in earlier than present date!";
            } else if (data.status == "unavailable") {
                payment_info.innerText = "Room currently not available for selected check-in date!";
            } else {
                payment_info.innerHTML = "No. of days: "+data.days+"<br/>Total payment amount: ₹"+data.payment;
                payment_info.classList.replace("text-danger", "text-dark");
                booking_form.elements["payment"].removeAttribute("disabled");
                booking_form.elements["payment"].classList.replace("text-dark", "text-light");
            }

            payment_info.classList.remove("d-none");
            loader.classList.add("d-none");
        }
        
        xhr.send(data);
    }
}