let generalData;
let siteTitleInput = document.getElementById("site-title-inp");
let siteAboutInput = document.getElementById("site-about-inp");
let generalSForm = document.getElementById("general-s-form");

generalSForm.addEventListener("submit", function(event) {
    event.preventDefault();
    updateGeneral(siteTitleInput.value, siteAboutInput.value);
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

window.onload = function() {
    getGeneral();
}