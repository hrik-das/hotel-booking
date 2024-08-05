<?php
    if (isset($_GET["account_recovery"])) {
        $data = filteration($_GET);
        $todayDate = date("Y-m-d");
        $query = executeCrud("select", "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `token_expire`=? LIMIT 1", [$data["email"], $data["token"], $todayDate], "sss");
        if (mysqli_num_rows($query) > 0) {
            echo<<<showModal
                <script>
                    var myModal = document.getElementById("recoveryModal");
                    myModal.querySelector("input[name='email']").value = "$data[email]";
                    myModal.querySelector("input[name='token']").value = "$data[token]";
                    var modal = bootstrap.Modal.getOrCreateInstance(myModal);
                    modal.show();
                </script>
            showModal;
        } else {
            alert("error", "Invalid or Expired Link!");
        }
    }
?>