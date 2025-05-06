let feature_settings_form = document.getElementById("feature-settings-form");
let facilities_settings_form = document.getElementById("facilities-settings-form");

feature_settings_form.addEventListener("submit", function(e) {
    e.preventDefault();
    addFeature();
});

facilities_settings_form.addEventListener("submit", function(e) {
    e.preventDefault();
    addFacility();
});

function addFeature() {
    let data = new FormData();
    data.append("feature-name", feature_settings_form.elements["feature_name"].value);
    data.append("add-feature", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/features_facilities.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("feature-settings");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success", "New feature added.");
            feature_settings_form.elements["feature_name"].value = "";
            getFeatures();
        } else {
            alert("error", "Failed to add this feature!");
        }
    }

    xhr.send(data);
}

function getFeatures() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("feature-data").innerHTML = this.responseText;
    }

    xhr.send("get-features");
}

function removeFeature(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success", "Feature removed.");
            getFeatures();
        } else if (this.responseText == "in-use") {
            alert("error", "Feature is already in use!");
        } else {
            alert("error", "Feature cannot be removed!");
        }
    }

    xhr.send("remove-feature="+id);
}

function addFacility() {
    let data = new FormData();
    data.append("facility-name", facilities_settings_form.elements["facility_name"].value);
    data.append("facility-icon", facilities_settings_form.elements["facility_icon"].files[0]);
    data.append("facility-desc", facilities_settings_form.elements["facility_desc"].value);
    data.append("add-facility", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/features_facilities.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("facility-settings");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid-image") {
            alert("error", "Only SVG image format is allowed!");
        } else if (this.responseText == "invalid-size") {
            alert("error", "Icon size should be less than 1MB!");
        } else if (this.responseText == "upload-failed") {
            alert("error", "Unable to upload this icon!");
        } else {
            alert("success", "New facility added.");
            feature_settings_form.reset();
            getFacilities();
        }
    }

    xhr.send(data);
}

function getFacilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("facilities-data").innerHTML = this.responseText;
    }

    xhr.send("get-facilities");
}

function removeFacility(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success", "Facility removed.");
            getFacilities();
        } else if (this.responseText == "in-use") {
            alert("error", "Facility is already in use!");
        } else {
            alert("error", "Facility cannot be removed!");
        }
    }

    xhr.send("remove-facility="+id);
}

window.onload = function() {
    getFeatures();
    getFacilities();
}