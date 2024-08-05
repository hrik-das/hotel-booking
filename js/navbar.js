function alert(type, message, position = "body") {
    let bs_class = (type == "success") ? "alert-success" : "alert-danger";
    let element = document.createElement("div");
    element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
            <strong class="me-3">${message}</strong>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>    
        </div>`;
    if (position == "body") {
        document.body.append(element);
        element.classList.add("custom-alert");
    } else {
        document.getElementById(position).appendChild(element);
    }
    setTimeout(removeAlert, 2000);
}

function removeAlert() {
    document.getElementsByClassName("alert")[0].remove();
}

function setActive() {
    let navbar = document.getElementById("navbar");
    let anchorTags = navbar.getElementsByTagName("a");
    let currentPath = document.location.pathname.toLowerCase().replace(/\/$/, "");    // Normalize and remove trailing slash
    // Handle default index file if path ends with a directory
    if (currentPath.split("/").pop().indexOf(".") === -1) {
        currentPath += "/index.php";
    }
    for (let i=0; i<anchorTags.length; i++) {
        let linkPath = new URL(anchorTags[i].href).pathname.toLowerCase().replace(/\/$/, "");    // Normalize and remove trailing slash
        if (currentPath === linkPath) {
            anchorTags[i].classList.add("active");
        }
    }
}

setActive();