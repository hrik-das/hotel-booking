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