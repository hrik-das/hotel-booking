<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
<link rel="stylesheet" href="./css/common.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="./js/navbar.js" defer></script>
<script src="./js/auth.js" defer></script>

<?php
    require("./admin/include/connect.php");
    require("./admin/include/essential.php");
    $contactQuery = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $settingsQuery = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $contactResult = mysqli_fetch_assoc(select($contactQuery, $values, "i"));
    $settings_r = mysqli_fetch_assoc(select($settingsQuery, $values, "i"));
?>