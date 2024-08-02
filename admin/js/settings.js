let generalData, contactData;
let siteTitleInput = document.getElementById("site-title-inp");
let siteAboutInput = document.getElementById("site-about-inp");
let generalSForm = document.getElementById("general-s-form");
let contactSForm = document.getElementById("contact-s-form");
let teamSForm = document.getElementById("team-s-form");
let memberNameInput = document.getElementById("member-name-inp");
let memberPictureInput = document.getElementById("member-picture-inp");

generalSForm.addEventListener("submit", function(event) {
    event.preventDefault();
    updateGeneral(siteTitleInput.value, siteAboutInput.value);
});

contactSForm.addEventListener("submit", function(event) {
    event.preventDefault();
    updateContact();
});

teamSForm.addEventListener("submit", function(event) {
    event.preventDefault();
    addMember();
});

function getGeneral() {
    let siteTitle = document.getElementById("site-title");
    let siteAbout = document.getElementById("site-about");
    let shutdownToggle = document.getElementById("shutdown-toggle");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            generalData = JSON.parse(this.responseText);
            siteTitle.innerText = generalData.site_title;
            siteAbout.innerText = generalData.site_about;
            siteTitleInput.value = generalData.site_title;
            siteAboutInput.value = generalData.site_about;
            if (generalData.shutdown == 0) {
                shutdownToggle.checked = false;
                shutdownToggle.value = 0;
            } else {
                shutdownToggle.checked = true;
                shutdownToggle.value = 1;
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send("getGeneral");
}

function updateGeneral(siteTitleValue, siteAboutValue) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            var myModal = document.getElementById("general-s");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if (this.responseText == 1) {
                alert("success", "General Settings Updated.");
                getGeneral();
            } else {
                alert("error", "General Settings Update Failed!");
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send("siteTitle="+siteTitleValue+"&siteAbout="+siteAboutValue+"&updateGeneral");
}

function updateShutdown(value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300 ){
            if (this.responseText == 1 && generalData.shutdown == 0) {
                alert("success", "Site has been Shutdown.");
            } else {
                alert("success", "Shutdown Mode is Turned Off.");
            }
            getGeneral();
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send("updateShutdown="+value);
}

function getContact() {
    let contactsPId = ["address", "gmap", "phone1", "phone2", "email", "facebook", "instagram", "twitter"];
    let iframe = document.getElementById("iframe");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            contactData = JSON.parse(this.responseText);
            contactData = Object.values(contactData);
            for (let i=0; i<contactsPId.length; i++) {
                document.getElementById(contactsPId[i]).innerText = contactData[i+1];
            }
            iframe.src = contactData[9];
            contactsInput(contactData);
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send("getContact");
}

function contactsInput(data) {
    let contactInputId = ["address-input", "gmap-input", "phone1-input", "phone2-input", "email-input", "facebook-input", "instagram-input", "twitter-input", "iframe-input"];
    for (let i=0; i<contactInputId.length; i++) {
        document.getElementById(contactInputId[i]).value = data[i+1];
    }
}

function updateContact() {
    let data = "";
    let index = ["address", "gmap", "phone1", "phone2", "email", "facebook", "instagram", "twitter", "iframe"];
    let contactInputId = ["address-input", "gmap-input", "phone1-input", "phone2-input", "email-input", "facebook-input", "instagram-input", "twitter-input", "iframe-input"];
    for (let i=0; i<index.length; i++) {
        data += index[i] + "=" + document.getElementById(contactInputId[i]).value + "&";
    }
    data += "updateContact";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            var myModal = document.getElementById("contact-s");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if (this.responseText == 1) {
                alert("success", "Contact Details Updated.");
                getContact();
            } else {
                alert("error", "Contact Details Update Failed!");
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

function addMember() {
    let data = new FormData();
    data.append("name", memberNameInput.value);
    data.append("picture", memberPictureInput.files[0]);
    data.append("addMember", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            var myModal = document.getElementById("team-s");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if (this.responseText == "invalidImage") {
                alert("error", "Only JPEG, PNG, JPG and WEBP Formats are allowed!");
            } else if (this.responseText == "invalidSize") {
                alert("error", "Image Should be less than 2 MB!");
            } else if (this.responseText == "uploadFailed") {
                alert("error", "Image Upload Failed, Server Down!");
            } else {
                alert("success", "New Member Details Added.");
                memberNameInput.value = "";
                memberPictureInput.value = "";
                getMember();
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

function getMember() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        document.getElementById("team-data").innerHTML = this.responseText;
    }
    xhr.send("getMember");
}

function deleteMember(value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == 1) {
                alert("success", "Member Data Deleted.");
                getMember();
            } else {
                alert("error", "Cannot Delete Member Data!");
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    };
    xhr.send("deleteMember="+value);
}

window.onload = function() {
    getGeneral();
    getContact();
    getMember();
}