let info_form = document.getElementById("info-form");
let profile_form = document.getElementById("profile-form");
let password_form = document.getElementById("password-form");

info_form.addEventListener("submit", function(e) {
    e.preventDefault();
    changeUserInformation();
});

profile_form.addEventListener("submit", function(e) {
    e.preventDefault();
    changeUserProfile();
});

password_form.addEventListener("submit", function(e) {
    e.preventDefault();
    changePassword();
});

function changeUserInformation() {
    let data = new FormData();
    data.append("username", info_form.elements["username"].value);
    data.append("phone", info_form.elements["phone"].value);
    data.append("dob", info_form.elements["dob"].value);
    data.append("pincode", info_form.elements["pincode"].value);
    data.append("address", info_form.elements["address"].value);
    data.append("info-form", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/profile.php", true);

    xhr.onload = function() {
        if (this.responseText == "phone-exist") {
            alert("error", "Phone number is already registered!");
        } else if (this.responseText == 0) {
            alert("error", "No changes made!");
        } else {
            alert("success", "Changes saved successfully.");
            info_form.reset();
        }
    }

    xhr.send(data);
}

function changeUserProfile() {
    let data = new FormData();
    data.append("profile", profile_form.elements["profile"].files[0]);
    data.append("profile-form", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/profile.php", true);

    xhr.onload = function() {
        if (this.responseText == "invalid-image") {
            alert("error", "Only JPG, PNG, JPEG or WEBP image formats are allowed!");
        } else if (this.responseText == "upload-failed") {
            alert("error", "Failed to upload image!");
        } else {
            window.location.href = window.location.pathname;
        }
    }

    xhr.send(data);
}

function changePassword() {
    let password = password_form.elements["password"].value;
    let confirm_password = password_form.elements["confirm_password"].value;

    if (password !== confirm_password) {
        alert("error", "Password mismatched!");
        return false;
    }

    let data = new FormData();
    data.append("password", password);
    data.append("confirm-password", confirm_password);
    data.append("password-form", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/profile.php", true);

    xhr.onload = function() {
        if (this.responseText == "mismatch") {
            alert("error", "Password do not match!");
        } else if (this.responseText == 0) {
            alert("error", "Failed to update password!");
        } else {
            alert("success", "Password changed.");
            password_form.reset();
        }
    }

    xhr.send(data);
}