let generalData = document.getElementById("general-s");

function getGeneral(){
    let siteTitle = document.getElementById("site-title");
    let siteAbout = document.getElementById("site-about");
    let siteTitleInput = document.getElementById("site-title-inp");
    let siteAboutInput = document.getElementById("site-about-inp");
    let shutdownToggle = document.getElementById("shutdown-toggle");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        generalData = JSON.parse(this.responseText);
        siteTitle.innerText = generalData.site_title;
        siteAbout.innerText = generalData.site_about;
        siteTitleInput.value = generalData.site_title;
        siteAboutInput.value = generalData.site_about;
        if(generalData.shutdown == 0){
            shutdownToggle.checked = false;
            shutdownToggle.value = 0;
        }else{
            shutdownToggle.checked = true;
            shutdownToggle.value = 1;
        }
    }
    xhr.send("getGeneral");
}

function updateGeneral(siteTitleValue, siteAboutValue){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        var myModal = document.getElementById("general-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(this.responseText == 1){
            alert("success", "Changes Saved Successfully!");
            getGeneral();
        }else{
            alert("error", "No Changes Made!");
        }
    }
    xhr.send("siteTitle="+siteTitleValue+"&siteAbout="+siteAboutValue+"&updateGeneral");
}

function updateShutdown(value){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(this.responseText == 1 && generalData.shutdown == 0){
            alert("success", "Site has been Shutdown Successfully!");
        }else{
            alert("success", "Shutdown Mode is Turned Off!");
        }
        getGeneral();
    }
    xhr.send("updateShutdown="+value);
}

window.onload = function(){
    getGeneral();
}