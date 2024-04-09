function getBookings(search="", page=1){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/booking_records.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            let data = JSON.parse(this.responseText);
            document.getElementById("table-data").innerHTML = data.table_data;
            document.getElementById("table-pagination").innerHTML = data.pagination;
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("getBookings&search="+search+"&page="+page);
}

function changePage(page){
    getBookings(document.getElementById("search-input").value, page);
}

function downloadPDF(id){
    window.location.href  = "generatePDF.php?generatepdf&id="+id;
}

window.onload = function(){
    getBookings();
}