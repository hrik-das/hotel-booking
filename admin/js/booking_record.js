function getBookings(search="", page=1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/booking_record.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        document.getElementById("table-data").innerHTML = data.table_data;
        document.getElementById("table-pagination").innerHTML = data.pagination;
    }
    
    xhr.send("get-bookings&search="+search+"&page="+page);
}

function changePage(page) {
    getBookings(document.getElementById("search").value, page);
}

function downloadPDF(id) {
    window.location.href = "generate_pdf.php?generate-pdf&id="+id;
}

window.onload = function() {
    getBookings();
}