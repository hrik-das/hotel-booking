let general_data, contact_data;

let site_title_input = document.getElementById("site-title-input");
let site_about_input = document.getElementById("site-about-input");
let member_name_input = document.getElementById("member-name-input");
let member_image_input = document.getElementById("member-image-input");

let general_settings_form = document.getElementById("general-settings-form");
let contact_details_form = document.getElementById("contact-details-form");
let team_management_form = document.getElementById("management-team-form");

general_settings_form.addEventListener("submit", function(e) {
    e.preventDefault();
    updateGeneralData(site_title_input.value, site_about_input.value);
});

contact_details_form.addEventListener("submit", function(e) {
    e.preventDefault();
    updateContactData();
});

team_management_form.addEventListener("submit", function(e) {
    e.preventDefault();
    uploadMember();
});

function getGeneralData() {
    let site_title = document.getElementById("site-title");
    let site_about = document.getElementById("site-about");

    let toggle_shutdown = document.getElementById("shutdown-toggle");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        general_data = JSON.parse(this.responseText);

        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        site_title_input.value = general_data.site_title;
        site_about_input.value = general_data.site_about;

        if (general_data.shutdown == 0) {
            toggle_shutdown.checked = false;
            toggle_shutdown.value = 0;
        } else {
            toggle_shutdown.checked = true;
            toggle_shutdown.value = 1;
        }
    }

    xhr.send("get-general");
}

function updateGeneralData(site_title_value, site_about_value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        var myModal = document.getElementById("general-settings");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "General Data Updated.");
            getGeneralData();
        } else {
            alert("error", "No changes made!");
        }
    }

    xhr.send("update-general&site_title="+site_title_value+"&site_about="+site_about_value);
}

function toggleShutdown(value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        if (this.responseText == 1 && general_data.shutdown == 0) {
            alert("success", "Services are currently shutdown.");
        } else {
            alert("success", "Services are available.");
        }

        getGeneralData();
    }

    xhr.send("update-shutdown="+value);
}

function getContactData() {
    let contacts_id = ["address", "gmap", "phone-one", "phone-two", "email", "facebook", "instagram", "twitter"];
    let iframe = document.getElementById("iframe");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        contact_data = JSON.parse(this.responseText);
        contact_data = Object.values(contact_data);

        for (let i=0; i<contacts_id.length; i++) {
            document.getElementById(contacts_id[i]).innerText = contact_data[i+1];
        }
        iframe.src = contact_data[contact_data.length-1];
        contactsInput(contact_data);
    }

    xhr.send("get-contacts");
}

function contactsInput(data) {
    let input_id = ["address-input", "gmap-input", "phone-one-input", "phone-two-input", "email-input", "facebook-input", "instagram-input", "twitter-input", "iframe-input"];

    for (let i=0; i<input_id.length; i++) {
        document.getElementById(input_id[i]).value = data[i+1];
    }
}

function updateContactData() {
    let index = ["address", "gmap", "phone_one", "phone_two", "email", "facebook", "instagram", "twitter", "iframe"];
    let contacts_input_id = ["address-input", "gmap-input", "phone-one-input", "phone-two-input", "email-input", "facebook-input", "instagram-input", "twitter-input", "iframe-input"];
    let data = "";

    for (let i=0; i<index.length; i++) {
        data += index[i] + "=" + document.getElementById(contacts_input_id[i]).value + "&";
    }
    data += "update-contacts";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        var myModal = document.getElementById("contact-details");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1 && general_data.shutdown == 0) {
            alert("success", "Contact details updated.");
            getContactData();
        } else {
            alert("error", "No changes made!");
        }
    }

    xhr.send(data);
}

function uploadMember() {
    let data = new FormData();
    data.append("name", member_name_input.value);
    data.append("image", member_image_input.files[0]);
    data.append("upload-member", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        var myModal = document.getElementById("management-team");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid-image") {
            alert("error", "Only JPG, JPEG, PNG and WEBP formats are allowed!");
        } else if (this.responseText == "invalid-size") {
            alert("error", "Image size should be less than 2MB!");
        } else if (this.responseText == "upload-failed") {
            alert("error", "Server didn't respond!");
        } else {
            alert("success", "New Member Uploaded.");
            member_name_input.value = "";
            member_image_input.value = "";
            getMembers();
        }
    }

    xhr.send(data);
}

function getMembers() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("team-data").innerHTML = this.responseText;
    }

    xhr.send("get-members");
}

function removeMember(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success", "Member details removed.");
            getMembers();
        } else {
            alert("error", "Member details cannot be removed!");
        }
    }

    xhr.send("remove-member="+id);
}

window.onload = function() {
    getGeneralData();
    getContactData();
    getMembers();
}