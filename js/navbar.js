const setActive = () => {
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