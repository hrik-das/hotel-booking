let register_form = document.getElementById("register-form");

register_form.addEventListener("submit", function(e) {
    e.preventDefault();
    registerUser();
});

function registerUser() {
    let data = new FormData();
    data.append("username", register_form.elements["username"].value);
    data.append("email", register_form.elements["email"].value);
    data.append("phone", register_form.elements["phone"].value);
    data.append("profile", register_form.elements["profile"].files[0]);
    data.append("address", register_form.elements["address"].value);
    data.append("pincode", register_form.elements["pincode"].value);
    data.append("dob", register_form.elements["dob"].value);
    data.append("password", register_form.elements["password"].value);
    data.append("confirm-password", register_form.elements["confirm_password"].value);
    data.append("register", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/auth.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("registerModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "password-mismatch") {
            alert("error", "Password mismatched!");
        } else if (this.responseText == "email-exist") {
            alert("error", "Email address alreay registered!");
        } else if (this.responseText == "phone-exist") {
            alert("error", "Phone number alreay registered!");
        } else if (this.responseText == "invalid-image") {
            alert("error", "Only JPEG, JPG, WEBP and PNG image formats are allowed!");
        } else if (this.responseText == "upload-failed") {
            alert("error", "Image upload failed!");
        } else if (this.responseText == "mail-send-failed") {
            alert("error", "Couldn't send the confirmation mail due to some reason!");
        } else if (this.responseText == "registration-failed") {
            alert("error", "User registration failed!");
        } else {
            alert("success", "Confirmation link send to the email address.");
            register_form.reset();
        }
    }
    
    xhr.send(data);
}