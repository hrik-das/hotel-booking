function getAllUsers() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("user-data").innerHTML = this.responseText;
    }
    
    xhr.send("get-all-users");
}

function toggleStatus(id, value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success", "User status toggled.");
            getAllUsers();
        } else {
            alert("error", "Unable to toggle status at this moment!");
        }
    }
    
    xhr.send("toggle-status="+id+"&value="+value);
}

function removeUser(id) {
    if (confirm("are you sure you want to remove this user?")) {
        let data = new FormData();
        data.append("user-id", id);
        data.append("remove-user", "");

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/users.php", true);
    
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert("success", "User details removed.");
                getAllUsers();
            } else {
                alert("error", "Failed to remove this user!");
            }
        }
    
        xhr.send(data);
    }
}

function searchUser(username) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("user-data").innerHTML = this.responseText;
    }

    xhr.send("search-user&username="+username);
}

window.onload = function() {
    getAllUsers();
}