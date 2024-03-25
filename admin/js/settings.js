let generalData, contactData;
let generalSForm = document.getElementById("general-s-form");
let contactSForm = document.getElementById("contact-s-form");
let siteTitleInput = document.getElementById("site-title-inp");
let siteAboutInput = document.getElementById("site-about-inp");

function getGeneral(){
    let siteTitle = document.getElementById("site-title");
    let siteAbout = document.getElementById("site-about");
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

generalSForm.addEventListener("submit", function(event){
    event.preventDefault();
    updateGeneral(siteTitleInput.value, siteAboutInput.value);
});

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

function getContact(){
    let contactsPId = ["address", "gmap", "ph1", "ph2", "email", "fb", "insta", "tw"];
    let iframe = document.getElementById("iframe");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        contactData = JSON.parse(this.responseText);
        contactData = Object.values(contactData);
        for(let i=0; i<contactsPId.length; i++){
            document.getElementById(contactsPId[i]).innerText = contactData[i+1];
        }
        iframe.src = contactData[9];
        contactsInput(contactData);
    }
    xhr.send("getContact");
}

function contactsInput(data){
    let contactInputId = ["address-inp", "gmap-inp", "ph1-inp", "ph2-inp", "email-inp", "fb-inp", "insta-inp", "tw-inp", "iframe-inp"];
    for(let i=0; i<contactInputId.length; i++){
        document.getElementById(contactInputId[i]).value = data[i+1];
    }
}

contactSForm.addEventListener("submit", function(event){
    event.preventDefault();
    updateContact();
});

function updateContact(){
    let data = "";
    let index = ["address", "gmap", "ph1", "ph2", "email", "fb", "insta", "tw", "iframe"];
    let contactInputId = ["address-inp", "gmap-inp", "ph1-inp", "ph2-inp", "email-inp", "fb-inp", "insta-inp", "tw-inp", "iframe-inp"];
    for(let i=0; i<index.length; i++){
        data += index[i] + "=" + document.getElementById(contactInputId[i]).value + "&";
    }
    data += "updateContact";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/settings_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        var myModal = document.getElementById("contact-s");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(this.responseText == 1){
            alert("success", "Chnages Saved!");
            getContact();
        }else{
            alert("error", "No Changes Made!");
        }
    }
    xhr.send(data);
}

window.onload = function(){
    getGeneral();
    getContact();
}