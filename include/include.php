<!-- Bootstrap CSS Link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Bootstrap Icon Link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>

<!-- Common CSS File -->
<link rel="stylesheet" href="./css/common.css">

<!-- Bootstrap Javascript Bundle Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Common JS File -->
<script src="./js/navbar.js" defer></script>
<script src="./js/auth.js" defer></script>

<?php
    session_start();

    require_once("admin/include/connect.php");
    require_once("admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");

    $contact_query = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $contact_values = [1];
    $contact_result = mysqli_fetch_assoc(select($contact_query, $contact_values, "i"));

    $settings_query = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $settings_values = [1];
    $settings_result = mysqli_fetch_assoc(select($settings_query, $settings_values, "i"));

    if ($settings_result["shutdown"]) {
        echo<<<alert
            <div class="bg-danger text-center p-2 fw-bold text-light">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Bookings are temporarily closed!
            </div>
        alert;
    }
?>