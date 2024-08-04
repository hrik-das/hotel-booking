let featureSForm = document.getElementById("feature-s-form");
let facilitySForm = document.getElementById("facility-s-form");

featureSForm.addEventListener("submit", function(event) {
    event.preventDefault();
    addFeature();
});

facilitySForm.addEventListener("submit", function(event) {
    event.preventDefault();
    addFacility();
});

function addFeature() {
    let data = new FormData();
    data.append("name", featureSForm.elements["feature_name"].value);
    data.append("addFeature", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/features_facilities.php", true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            var myModal = document.getElementById("features-s");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if (this.responseText == 1) {
                alert("success", "New Feature Added.");
                featureSForm.elements["feature_name"].value = "";
                getFeatures();
            } else {
                alert("error", "Server didn't respond!");
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

function getFeatures() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        document.getElementById("features-data").innerHTML = this.responseText;
    }
    xhr.send("getFeatures");
}

function deleteFeature(value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == 1) {
                alert("success", "Feature Deleted.");
                getFeatures();
            } else if (this.responseText == "room_added") {
                alert("error", "Feature is in Use!");
            } else {
                alert("error", "Cannot Delete Feature!");
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send("deleteFeature="+value);
}

function addFacility() {
    let data = new FormData();
    data.append("name", facilitySForm.elements["facility_name"].value);
    data.append("icon", facilitySForm.elements["facility_icon"].files[0]);
    data.append("desc", facilitySForm.elements["facility_desc"].value);
    data.append("addFacility", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/features_facilities.php", true);
    xhr.onload = function() {
        var myModal = document.getElementById("facility-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == "invalidImage") {
                alert("error", "Only SVG Formats are allowed!");
            } else if (this.responseText == "inv_size") {
                alert("error", "Image Should be less than 1 MB!");
            } else if (this.responseText == "uploadFailed") {
                alert("error", "Image Upload Failed, Server Down!");
            } else {
                alert("success", "New Facility Added.");
                facilitySForm.reset();
                getFacilities();
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

function getFacilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        document.getElementById("facilities-data").innerHTML = this.responseText;
    }
    xhr.send("getFacilities");
}

function deleteFacility(value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/features_facilities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == 1) {
                alert("success", "Facility Deleted Successfully!");
                getFacilities();
            } else if (this.responseText == "room_added") {
                alert("error", "Facility is in Use!");
            } else {
                alert("error", "Cannot Delete Facility!");
            }
        } else {
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function() {
        console.error("Network error occurred!");
    }
    xhr.send("deleteFacility="+value);
}

window.onload = function() {
    getFeatures();
    getFacilities();
}