function getUsers(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            document.getElementById("user-data").innerHTML = this.responseText;
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("getUsers");
}

function toggleStatus(id, value){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == 1){
                alert("success", "Status Toggled!");
                getUsers();
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

function removeUser(userId){
    if(confirm("You want to Delete this User. Are Your Sure?")){
        let data = new FormData();
        data.append("user_id", userId);
        data.append("removeUser", "");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/users.php", true);
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 300){
                if(this.responseText == 1){
                    alert("success", "User Removed Successfully!");
                    getUsers();
                }else{
                    alert("error", "User Removal Failed!");
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

function searchUser(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            document.getElementById("user-data").innerHTML = this.responseText;
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send("searchUser&username="+username);
}

window.onload = function(){
    getUsers();
}