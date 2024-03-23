let generalData = document.getElementById("general-s");

function getGeneral(){
    let siteTitle = document.getElementById("site-title");
    let siteAbout = document.getElementById("site-about");
    let siteTitleInput = document.getElementById("site-title-inp");
    let siteAboutInput = document.getElementById("site-about-inp");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        generalData = JSON.parse(this.responseText);
        siteTitle.innerText = generalData.site_title;
        siteAbout.innerText = generalData.site_about;
        siteTitleInput.value = generalData.site_title;
        siteAboutInput.value = generalData.site_about;
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

window.onload = function(){
    getGeneral();
}