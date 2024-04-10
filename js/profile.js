let infoForm = document.getElementById("info-form");

infoForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let data = new FormData();
    data.append("info-form", "");
    data.append("name", infoForm.elements["name"].value);
    data.append("phone", infoForm.elements["phone"].value);
    data.append("dob", infoForm.elements["dob"].value);
    data.append("address", infoForm.elements["address"].value);
    data.append("pincode", infoForm.elements["pincode"].value);
    let xhr = new XMLHttpRequest();
        xhr.open("POST", "./ajax/profile.php", true);
        xhr.onload = function(){
            if(xhr.status >= 200 && xhr.status < 300){
                if(this.responseText == "phoneExist"){
                    alert("error", "Phone Already Registered!");
                }else if(this.responseText == 0){
                    alert("error", "No Changes Made!");
                }else{
                    alert("success", "Changes Saved!");
                    window.location.href = window.location.href.split("/").pop();
                }
            }else{
                console.error("Request failed with status : ", xhr.status);
            }
        }
        xhr.onerror = function(){
            console.error("Network error occurred!");
        }
        xhr.send(data);
});