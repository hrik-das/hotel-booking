document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    function removeActiveClasses() {
        navLinks.forEach(function(link) {
            link.classList.remove("active");
        });  
    }

    const currentPath = window.location.pathname;
    let activeLinkFound = false;

    navLinks.forEach(function(link) {
        if (currentPath.includes(link.getAttribute("href"))) {
            link.classList.add("active");
            activeLinkFound = true;
        }
    });

    if (!activeLinkFound && navLinks.length > 0) {
        navLinks[0].classList.add("active");
    }

    navLinks.forEach(function(link) {
        link.addEventListener("click", function () {
            removeActiveClasses();
            this.classList.add("active");
        });
    });
});

function alert(type, message, position = "body") {
    let bs_class = (type == "success") ? "alert-success" : "alert-danger";
    let element = document.createElement("div");

    element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
            <p class="m-0">${message}</p>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    if (position == "body") {
        document.body.append(element);
        element.classList.add("custom-alert");
    } else {
        document.getElementById(position).appendChild(element);
    }

    setTimeout(alertRemove, 3000);
}

function alertRemove(){
    document.getElementsByClassName("alert")[0].remove();
}