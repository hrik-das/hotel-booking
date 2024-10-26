document.addEventListener("DOMContentLoaded", function () {
    // Select all nav links
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    // Function to remove 'active' class from all links
    function removeActiveClasses() {
        navLinks.forEach(link => link.classList.remove("active"));
    }

    // Highlight the current page link based on the URL path
    const currentPath = window.location.pathname;
    let activeLinkFound = false;

    navLinks.forEach(link => {
        // Check if the href matches the current path
        if (currentPath.includes(link.getAttribute("href"))) {
            link.classList.add("active");
            activeLinkFound = true;
        }
    });

    // If no specific link matches, set the first link as active
    if (!activeLinkFound && navLinks.length > 0) {
        navLinks[0].classList.add("active");
    }

    // Add event listener to each link for click highlighting
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            removeActiveClasses(); // Remove 'active' from all links
            this.classList.add("active"); // Add 'active' to clicked link
        });
    });
});