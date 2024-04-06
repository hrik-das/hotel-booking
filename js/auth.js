function alert(type, message, position = "body"){
    let bs_class = (type == "success") ? "alert-success" : "alert-danger";
    let element = document.createElement("div");
    element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
            <strong class="me-3">${message}</strong>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>    
        </div>`;
    if(position == "body"){
        document.body.append(element);
        element.classList.add("custom-alert");
    }else{
        document.getElementById(position).appendChild(element);
    }
    setTimeout(removeAlert, 3000);
}

function removeAlert(){
    document.getElementsByClassName("alert")[0].remove();
}

let registerForm = document.getElementById("register-form");
let loginForm = document.getElementById("login-form");
let forgotForm = document.getElementById("forgot-form");
registerForm.addEventListener("submit", (event) => {
    event.preventDefault();
    addUser();
});

const addUser = () => {
    let data = new FormData();
    data.append("name", registerForm.elements["name"].value);
    data.append("email", registerForm.elements["email"].value);
    data.append("phone", registerForm.elements["phone"].value);
    data.append("profile", registerForm.elements["profile"].files[0]);
    data.append("address", registerForm.elements["address"].value);
    data.append("pincode", registerForm.elements["pincode"].value);
    data.append("dob", registerForm.elements["dob"].value);
    data.append("pass", registerForm.elements["pass"].value);
    data.append("cpass", registerForm.elements["cpass"].value);
    data.append("register", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/login_register.php", true);
    xhr.onload = function(){
        var myModal = document.getElementById("registerModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == "passwordMisMatch"){
                alert("error", "Password does not Match!");
            }else if(this.responseText == "emailExist"){
                alert("error", "Email is Already Registered!");
            }else if(this.responseText == "phoneExist"){
                alert("error", "Phone Number is Already Registered!");
            }else if(this.responseText == "invalidImage"){
                alert("error", "Only JPG, JPEG, WEBP and PNG Images are Allowed!");
            }else if(this.responseText == "uploadFailed"){
                alert("error", "Image Upload Failed!");
            }else if(this.responseText == "mailFailed"){
                alert("error", "Cannot Send Confirmation Email!");
            }else if(this.responseText == "insertFailed"){
                alert("error", "Registration Failed!");
            }else{
                alert("success", "Registration Successful. Confirmation Link Send to Registered Email Address!");
                registerForm.reset();
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

loginForm.addEventListener("submit", (event) => {
    event.preventDefault();
    loginUser();
});

const loginUser = () => {
    let data = new FormData();
    data.append("email_mob", loginForm.elements["email_mob"].value);
    data.append("pass", loginForm.elements["pass"].value);
    data.append("login", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/login_register.php", true);
    xhr.onload = function(){
        var myModal = document.getElementById("loginModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == "invalidEmailorPhone"){
                alert("error", "Invalid Email Address or Mobile Number!");
            }else if(this.responseText == "notVerified"){
                alert("error", "Email is not Verified!");
            }else if(this.responseText == "inactive"){
                alert("error", "Account Suspend, Contact Admin!");
            }else if(this.responseText == "invalidPassword"){
                alert("error", "Incorrect Password!");
            }else{
                let fileURL = window.location.href.split("/").pop().split("?").shift();
                if(fileURL == "room_details.php"){
                    window.location = window.location.href;
                }else{
                    window.location = window.location.pathname;
                }
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

forgotForm.addEventListener("submit", (event) => {
    event.preventDefault();
    forgotPassword();
});

function forgotPassword(){
    let data = new FormData();
    data.append("email", forgotForm.elements["email"].value);
    data.append("forgot", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/login_register.php", true);
    xhr.onload = function(){
        var myModal = document.getElementById("forgotModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == "invalidEmail"){
                alert("error", "Invalid Email Address!");
            }else if(this.responseText == "notVerified"){
                alert("error", "Email is not Verified!");
            }else if(this.responseText == "inactive"){
                alert("error", "Account Suspend, Contact Admin!");
            }else if(this.responseText == "mailFailed"){
                alert("error", "Mail Send Failed!");
            }else if(this.responseText == "updateFailed"){
                alert("error", "Password Recovery Failed!");
            }else{
                alert("success", "Reset Link Sent to Given Email Address!");
                forgotForm.reset();
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

function checkLoginToBook(status, roomId){
    if(status){
        window.location.href = "confirm_booking.php?id="+roomId;
    }else{
        alert("error", "Please Login to Book Your Room!");
    }
}