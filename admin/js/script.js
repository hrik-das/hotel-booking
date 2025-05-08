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