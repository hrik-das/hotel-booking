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