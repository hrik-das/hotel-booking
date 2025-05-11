let reset_form = document.getElementById("reset-form");

reset_form.addEventListener("submit", function(e) {
    e.preventDefault();
    recoverAccount();
});

function showResetModal(email, token) {
    const myModal = document.getElementById("resetModal");
    myModal.querySelector("input[name='email']").value = email;
    myModal.querySelector("input[name='token']").value = token;
    const modal = bootstrap.Modal.getOrCreateInstance(myModal);
    modal.show();
}

function recoverAccount() {
    let data = new FormData();
    data.append("email", reset_form.elements["email"].value);
    data.append("token", reset_form.elements["token"].value);
    data.append("password", reset_form.elements["password"].value);
    data.append("recover-account", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/auth.php", true);

    xhr.onload = function() {
        var myModal = document.getElementById("resetModal");
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "failed") {
            alert("error", "Failed to reset you account!");
        } else {
            alert("success", "Password reset successful.");
            reset_form.reset();
        }
    }
    
    xhr.send(data);
}