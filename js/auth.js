let register_form = document.getElementById("register-form");
let login_form = document.getElementById("login-form");
let forgot_form = document.getElementById("forgot-form");

register_form.addEventListener("submit", function(e) {
    e.preventDefault();
    registerUser();
});

login_form.addEventListener("submit", function(e) {
    e.preventDefault();
    loginUser();
});

forgot_form.addEventListener("submit", function(e) {
    e.preventDefault();
    resetPassword();
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

function loginUser() {
    let data = new FormData();
    data.append("email-phone", login_form.elements["email_phone"].value);
    data.append("password", login_form.elements["password"].value);
    data.append("login", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/auth.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("loginModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid-details") {
            alert("error", "Login details are invalid!");
        } else if (this.responseText == "not-verified") {
            alert("error", "Email address is not verified yet!");
        } else if (this.responseText == "status-blocked") {
            alert("error", "Account currently suspended, contact admin!");
        } else if (this.responseText == "invalid-password") {
            alert("error", "Incorrect password!");
        } else {
            window.location = window.location.pathname;
        }
    }
    
    xhr.send(data);
}

function resetPassword() {
    let data = new FormData();
    data.append("email", forgot_form.elements["email"].value);
    data.append("forgot-password", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/auth.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("forgotModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid-user") {
            alert("error", "Invalid email address!");
        } else if (this.responseText == "not-verified") {
            alert("error", "Email address is not verified yet!");
        } else if (this.responseText == "status-blocked") {
            alert("error", "Account currently suspended, contact admin!");
        } else if (this.responseText == "send-mail-failed") {
            alert("error", "Couldn't send email due to some internal server error!");
        } else if (this.responseText == "update-failed") {
            alert("error", "Failed to reset your password!");
        } else {
            alert("success", "Password reset link send to your email address.");
            forgot_form.reset();
        }
    }
    
    xhr.send(data);
}