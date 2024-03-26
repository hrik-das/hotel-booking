let carouselSForm = document.getElementById("carousel-s-form");
let carouselPictureInput = document.getElementById("carousel-picture-inp");

function addImage(){
    let data = new FormData();
    data.append("picture", carouselPictureInput.files[0]);
    data.append("addImage", "");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/carousel_crud.php", true);
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            var myModal = document.getElementById("carousel-s");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            if(this.responseText == "invalidImage"){
                alert("error", "Only JPEG, PNG, JPG and WEBP Formats are allowed!");
            }else if(this.responseText == "invalidSize"){
                alert("error", "Image Should be less than 2 MB!");
            }else if(this.responseText == "uploadFailed"){
                alert("error", "Image Upload Failed, Server Down!");
            }else{
                alert("success", "New Image Added Successfully!");
                carouselPictureInput.value = "";
                getCarousel();
            }
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    }
    xhr.send(data);
}

carouselSForm.addEventListener("submit", function(event){
    event.preventDefault();
    addImage();
});

function getCarousel(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/carousel_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        document.getElementById("carousel-data").innerHTML = this.responseText;
    }
    xhr.send("getCarousel");
}

function deleteCarousel(value){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/carousel_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(xhr.status >= 200 && xhr.status < 300){
            if(this.responseText == 1){
                alert("success", "Image Deleted Successfully!");
                getCarousel();
            }else{
                alert("error", "Cannot Delete Image!");
            }
        }else{
            console.error("Request failed with status : ", xhr.status);
        }
    }
    xhr.onerror = function(){
        console.error("Network error occurred!");
    };
    xhr.send("deleteCarousel="+value);
}

window.onload = function(){
    getCarousel();
}