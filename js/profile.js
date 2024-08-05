let infoForm = document.getElementById("info-form");
let profileForm = document.getElementById("profile-form");
let passForm = document.getElementById("pass-form");

infoForm.addEventListener("submit", function(event) {
    event.preventDefault();
    sendInfo();
});

profileForm.addEventListener("submit", function(event) {
    event.preventDefault();
    sendProfile();
});

passForm.addEventListener("submit", function(event) {
    event.preventDefault();
    changePassword();
});

function sendInfo() {
    let data = new FormData();
    data.append("info-form", "");
    data.append("name", infoForm.elements["name"].value);
    data.append("phone", infoForm.elements["phone"].value);
    data.append("dob", infoForm.elements["dob"].value);
    data.append("address", infoForm.elements["address"].value);
    data.append("pincode", infoForm.elements["pincode"].value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/profile.php", true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == "phoneExist") {
                alert("error", "Phone Already Registered!");
            } else if (this.responseText == 0) {
                alert("error", "No Changes Made!");
            } else {
                alert("success", "Changes Saved.");
                window.location.href = window.location.href.split("/").pop();
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send(data);
}

function sendProfile() {
    let data = new FormData();
    data.append("profile-form", "");
    data.append("profile", profileForm.elements["profile"].files[0]);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/profile.php", true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == "invalidImage") {
                alert("error", "Only JPEG, JPG, PNG and WEBP formats are allowed!");
            } else if (this.responseText == "uploadFailed") {
                alert("error", "Image Upload Failed!");
            } else if (this.responseText == 0) {
                alert("error", "Image Updation Failed!");
            } else {
                window.location.href = window.location.pathname;
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send(data);
}

function changePassword() {
    let newPassword = passForm.elements["new_pass"].value;
    let confirmPassword = passForm.elements["con_pass"].value;
    if (newPassword != confirmPassword) {
        alert("error", "Password do not Matched!");
        return false;
    }
    let data = new FormData();
    data.append("new_pass", newPassword);
    data.append("con_pass", confirmPassword);
    data.append("pass-form", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/profile.php", true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == "misMatched") {
                alert("error", "Password doesn't Matched!");
            } else if (this.responseText == 0) {
                alert("error", "Image Updation Failed!");
            } else {
                alert("success", "Password Changed.");
                passForm.reset();
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send(data);
}