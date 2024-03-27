let addRoomForm = document.getElementById("add-room-form");
let editRoomForm = document.getElementById("edit-room-form");

addRoomForm.addEventListener("submit", function(event){
    event.preventDefault();
    addRoom();
});

function addRoom(){
    let data = new FormData();
    data.append("addRoom", "");
    data.append("name", addRoomForm.elements["name"].value);
    data.append("area", addRoomForm.elements["area"].value);
    data.append("price", addRoomForm.elements["price"].value);
    data.append("quantity", addRoomForm.elements["quantity"].value);
    data.append("adult", addRoomForm.elements["adult"].value);
    data.append("children", addRoomForm.elements["children"].value);
    data.append("desc", addRoomForm.elements["desc"].value);
    let features = [];
    addRoomForm.elements["features"].forEach(element => {
        if(element.checked){
            features.push(element.value);
        }
    });
    let facilities = [];
    addRoomForm.elements["facilities"].forEach(element => {
        if(element.checked){
            facilities.push(element.value);
        }
    });
    data.append("features", JSON.stringify(features));
    data.append("facilities", JSON.stringify(facilities));
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            var myModal = document.getElementById("add-room");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if(this.responseText == 1){
                alert("success", "New Room Added Successfully!");
                addRoomForm.reset();
                getAllRooms();
            }else{
                alert("error", "Server didn't respond!");
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

function getAllRooms(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            document.getElementById("room-data").innerHTML = this.responseText;
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("getAllRooms");
}

function editDetails(id){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            let data = JSON.parse(this.responseText);
            console.log(data);
            editRoomForm.elements["name"].value = data.roomdata.name;
            editRoomForm.elements["area"].value = data.roomdata.area;
            editRoomForm.elements["price"].value = data.roomdata.price;
            editRoomForm.elements["quantity"].value = data.roomdata.quantity;
            editRoomForm.elements["adult"].value = data.roomdata.adult;
            editRoomForm.elements["children"].value = data.roomdata.children;
            editRoomForm.elements["desc"].value = data.roomdata.description;
            editRoomForm.elements["room_id"].value = data.roomdata.id;
            editRoomForm.elements["features"].forEach(element => {
                if(data.features.includes(Number(element.value))){
                    element.checked = true;
                }
            });
            editRoomForm.elements["facilities"].forEach(element => {
                if(data.facilities.includes(Number(element.value))){
                    element.checked = true;
                }
            });
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("getRoom="+id);
}

editRoomForm.addEventListener("submit", function(event){
    event.preventDefault();
    submitEditRoom();
});

function submitEditRoom(){
    let data = new FormData();
    data.append("editRoom", "");
    data.append("room_id", editRoomForm.elements["room_id"].value);
    data.append("name", editRoomForm.elements["name"].value);
    data.append("area", editRoomForm.elements["area"].value);
    data.append("price", editRoomForm.elements["price"].value);
    data.append("quantity", editRoomForm.elements["quantity"].value);
    data.append("adult", editRoomForm.elements["adult"].value);
    data.append("children", editRoomForm.elements["children"].value);
    data.append("desc", editRoomForm.elements["desc"].value);
    let features = [];
    editRoomForm.elements["features"].forEach(element => {
        if(element.checked){
            features.push(element.value);
        }
    });
    let facilities = [];
    editRoomForm.elements["facilities"].forEach(element => {
        if(element.checked){
            facilities.push(element.value);
        }
    });
    data.append("features", JSON.stringify(features));
    data.append("facilities", JSON.stringify(facilities));
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            var myModal = document.getElementById("edit-room");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if(this.responseText == 1){
                alert("success", "Room Data Edited Successfully!");
                editRoomForm.reset();
                getAllRooms();
            }else{
                alert("error", "Server didn't respond!");
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

function toggleStatus(id, value){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == 1){
                alert("success", "Status Toggled!");
                getAllRooms();
            }else{
                alert("error", "Server did not Responded!");
            }
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("toggleStatus="+id+"&value="+value);
}

window.onload = function(){
    getAllRooms();
}