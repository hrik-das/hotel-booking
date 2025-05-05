let carousel_image_form = document.getElementById("carousel-image-form");
let carousel_image_input = document.getElementById("carousel-image-input");

carousel_image_form.addEventListener("submit", function(e) {
    e.preventDefault();
    uploadImage();
});

function uploadImage() {
    let data = new FormData();
    data.append("image", carousel_image_input.files[0]);
    data.append("upload-image", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/carousel_crud.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("carousel-image");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "invalid-image") {
            alert("error", "Only JPG, JPEG, PNG and WEBP formats are allowed!");
        } else if (this.responseText == "invalid-size") {
            alert("error", "Image size should be less than 2MB!");
        } else if (this.responseText == "upload-failed") {
            alert("error", "Server didn't respond!");
        } else {
            alert("success", "New carousel image uploaded.");
            carousel_image_input.value = "";
            getCarousel();
        }
    }

    xhr.send(data);
}

function getCarousel() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/carousel_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("carousel-data").innerHTML = this.responseText;
    }

    xhr.send("get-carousel");
}


function removeImage(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/carousel_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success", "Carousel image removed.");
            getCarousel();
        } else {
            alert("error", "Carousel image cannot be removed!");
        }
    }

    xhr.send("remove-image="+id);
}

window.onload = function() {
    getCarousel();
}