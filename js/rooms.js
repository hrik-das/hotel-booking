let rooms_data = document.getElementById("rooms-data");
let checkin = document.getElementById("check-in");
let checkout = document.getElementById("check-out");
let check_availablity_button = document.getElementById("check-reset");

let adult = document.getElementById("adult");
let children = document.getElementById("children");
let guest_reset_button = document.getElementById("guest-reset");
let facilities_reset_button = document.getElementById("facilites-reset");

function fetchRooms() {
    let check_availablity = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
    });

    let guests = JSON.stringify({
        adult: adult.value,
        children: children.value
    });

    let facilities_list = {
        "facilities": []
    };

    let get_facilities = document.querySelectorAll("[name=facilities]:checked");

    if (get_facilities.length > 0) {
        get_facilities.forEach(function(facility) {
            facilities_list.facilities.push(facility.value);
        });

        facilities_reset_button.classList.remove("d-none");
    } else {
        facilities_reset_button.classList.add("d-none");
    }

    facilities_list = JSON.stringify(facilities_list);

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "server/rooms.php?fetch-rooms&check-available="+check_availablity+"&guests="+guests+"&facilities="+facilities_list, true);
    
    xhr.onprogress = function() {
        rooms_data.innerHTML = `
            <div class="spinner-border text-primary mb-3 mx-auto d-block" role="status" id="loader">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
    }

    xhr.onload = function() {
        rooms_data.innerHTML = this.responseText;
    }

    xhr.send();
}

function checkAvailabilityFilter() {
    if (checkin.value != "" && checkout.value != "") {
        fetchRooms();
        check_availablity_button.classList.remove("d-none");
    }
}

function checkAvailabilityClear() {
    checkin.value = "";
    checkout.value = "";
    check_availablity_button.classList.add("d-none");
    fetchRooms();
}

function guestFilter() {
    if (adult.value > 0 || children.value > 0) {
        fetchRooms();
        guest_reset_button.classList.remove("d-none");
    }
}

function guestClear() {
    adult.value = "";
    children.value = "";
    guest_reset_button.classList.add("d-none");
    fetchRooms();
}

function facilitiesClear() {
    let get_facilities = document.querySelectorAll("[name=facilities]:checked");

    get_facilities.forEach(function(facility) {
        facility.checked = false;
    });
    
    facilities_reset_button.classList.add("d-none");
    fetchRooms();
}

fetchRooms();