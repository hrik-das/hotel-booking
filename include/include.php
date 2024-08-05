<!-- Styles -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Merienda:wght@300..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="./css/common.css">

<!-- Javascript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="./js/navbar.js" defer></script>
<script src="./js/authentication.js" defer></script>
<script src="./js/recover_password.js" defer></script>

<!-- Backend Integration for Dynamic Frontend -->
<?php
    session_start();
    require_once("./admin/include/connect.php");
    require_once("./admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
    
    $contactQuery = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $settingsQuery = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $contact_r = mysqli_fetch_assoc(executeCrud("select", $contactQuery, $values, "i"));
    $settings_r = mysqli_fetch_assoc(executeCrud("select", $settingsQuery, $values, "i"));
    if ($settings_r["shutdown"]) {
        echo<<<alertbar
            <div class="bg-danger fw-bold text-center p-2 sticky-top">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Bookings are Temporarily Closed!!!
            </div>
        alertbar;
    }
?>