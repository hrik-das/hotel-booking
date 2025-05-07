let add_room_form = document.getElementById("add-room-form");
let edit_room_form = document.getElementById("edit-room-form");

add_room_form.addEventListener("submit", function(e) {
    e.preventDefault();
    addRoom();
});

edit_room_form.addEventListener("submit", function(e) {
    e.preventDefault();
    editRoom();
});

function addRoom() {
    let features = [], facilities = [];
    let data = new FormData();
    data.append("name", add_room_form.elements["name"].value);
    data.append("area", add_room_form.elements["area"].value);
    data.append("price", add_room_form.elements["price"].value);
    data.append("quantity", add_room_form.elements["quantity"].value);
    data.append("adult", add_room_form.elements["adult"].value);
    data.append("children", add_room_form.elements["children"].value);
    data.append("desc", add_room_form.elements["desc"].value);

    add_room_form.elements["features"].forEach(element => {
        if (element.checked) {
            features.push(element.value);
        }
    });

    add_room_form.elements["facilities"].forEach(element => {
        if (element.checked) {
            facilities.push(element.value);
        }
    });

    data.append("features", JSON.stringify(features));
    data.append("facilities", JSON.stringify(facilities));
    data.append("add-room", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/rooms.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("add-room");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "New room added.");
            add_room_form.reset();
            getAllRooms();
        } else {
            alert("error", "Room cannot be added!");
        }
    }

    xhr.send(data);
}

function getAllRooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("room-data").innerHTML = this.responseText;
    }
    
    xhr.send("get-all-rooms");
}

function toggleStatus(id, value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success", "Room status toggled.");
            getAllRooms();
        } else {
            alert("error", "Unable to toggle status at this moment!");
        }
    }
    
    xhr.send("toggle-status="+id+"&value="+value);
}

function editDetails(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);

        edit_room_form.elements["name"].value = data.room_data.name;
        edit_room_form.elements["area"].value = data.room_data.area;
        edit_room_form.elements["price"].value = data.room_data.price;
        edit_room_form.elements["quantity"].value = data.room_data.quantity;
        edit_room_form.elements["adult"].value = data.room_data.adult;
        edit_room_form.elements["children"].value = data.room_data.children;
        edit_room_form.elements["desc"].value = data.room_data.description;
        edit_room_form.elements["room_id"].value = data.room_data.id;

        edit_room_form.elements["features"].forEach(element => {
            if (data.features.includes(Number(element.value))) {
                element.checked = true;
            }
        });
    
        edit_room_form.elements["facilities"].forEach(element => {
            if (data.facilities.includes(Number(element.value))) {
                element.checked = true;
            }
        });
    }
    
    xhr.send("get-room="+id);
}

function editRoom() {
    let features = [], facilities = [];
    let data = new FormData();
    data.append("room-id", edit_room_form.elements["room_id"].value);
    data.append("name", edit_room_form.elements["name"].value);
    data.append("area", edit_room_form.elements["area"].value);
    data.append("price", edit_room_form.elements["price"].value);
    data.append("quantity", edit_room_form.elements["quantity"].value);
    data.append("adult", edit_room_form.elements["adult"].value);
    data.append("children", edit_room_form.elements["children"].value);
    data.append("desc", edit_room_form.elements["desc"].value);

    edit_room_form.elements["features"].forEach(element => {
        if (element.checked) {
            features.push(element.value);
        }
    });

    edit_room_form.elements["facilities"].forEach(element => {
        if (element.checked) {
            facilities.push(element.value);
        }
    });

    data.append("features", JSON.stringify(features));
    data.append("facilities", JSON.stringify(facilities));
    data.append("edit-room", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/rooms.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("edit-room");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "Room data edited.");
            edit_room_form.reset();
            getAllRooms();
        } else {
            alert("error", "Room cannot be edited!");
        }
    }

    xhr.send(data);
}

window.onload = function() {
    getAllRooms();
}