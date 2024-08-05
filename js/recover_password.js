let recoveryForm = document.getElementById("recovery-form");

recoveryForm.addEventListener("submit", function(event) {
    event.preventDefault();
    recoveryPassword();
});

function recoveryPassword() {
    let data = new FormData();
    data.append("email", recoveryForm.elements["email"].value);
    data.append("token", recoveryForm.elements["token"].value);
    data.append("pass", recoveryForm.elements["pass"].value);
    data.append("recover", "");
    var myModal = document.getElementById("recoveryModal");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./ajax/authentication.php", true);
    xhr.onload = function() {
        if (this.responseText == "failed") {
            alert("error", "Password Reset Failed!");
        } else {
            alert("success", "Password Reset Successful.");
            recoveryForm.reset();
        }
    }
    xhr.send(data);
}