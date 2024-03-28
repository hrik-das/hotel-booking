let addRoomForm = document.getElementById("add-room-form");
let editRoomForm = document.getElementById("edit-room-form");
let addImageForm = document.getElementById("add-image-form");

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

addImageForm.addEventListener("submit", function(event){
    event.preventDefault();
    addImage();
});

function addImage(){
    let data = new FormData();
    data.append("image", addImageForm.elements["image"].files[0]);
    data.append("room_id", addImageForm.elements["room_id"].value);
    data.append("addImage", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == "invalidImage"){
                alert("error", "Only JPG, PNG, JPEG and WEBP Formats are allowed!", "image-alert");
            }else if(this.responseText == "invalidSize"){
                alert("error", "Image Should be less than 2 MB!", "image-alert");
            }else if(this.responseText == "uploadFailed"){
                alert('error', "Image Upload Failed, Server Down!", "image-alert");
            }else{
                alert("success", "New Image Added Successfully!", "image-alert");
                roomImages(addImageForm.elements["room_id"].value, document.querySelector("#room-images .modal-title").innerText);
                addImageForm.reset();
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

function roomImages(id, name){
    document.querySelector("#room-images .modal-title").innerText = name;
    addImageForm.elements["room_id"].value = id;
    addImageForm.elements["image"].value = "";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            document.getElementById("room-image-data").innerHTML = this.responseText;
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("getRoomImages="+id);
}

function removeImage(imageId, roomId){
    let data = new FormData();
    data.append("image_id", imageId);
    data.append("room_id", roomId);
    data.append("removeImage", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == 1){
                alert("success", "Image Removed!", "image-alert");
                roomImages(roomId, document.querySelector("#room-images .modal-title").innerText);
            }else{
                alert("error", "Image Removal Failed!", "image-alert");
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

function thumbnailImage(imageId, roomId){
    let data = new FormData();
    data.append("image_id", imageId);
    data.append("room_id", roomId);
    data.append("thumbnailImage", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/rooms.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == 1){
                alert("success", "Image Thumbnail Changed!", "image-alert");
                roomImages(roomId, document.querySelector("#room-images .modal-title").innerText);
            }else{
                alert("error", "Image Thumbnail did not Changed!", "image-alert");
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

function removeRoom(roomId){
    if(confirm("You want to Delete this Room. Are Your Sure?")){
        let data = new FormData();
        data.append("room_id", roomId);
        data.append("removeRoom", "");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/rooms.php", true);
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 300){
                if(this.responseText == 1){
                    alert("success", "Room Removed Successfully!");
                    getAllRooms();
                }else{
                    alert("error", "Room Removal Failed!");
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
    getAllRooms();
}