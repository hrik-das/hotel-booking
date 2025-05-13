<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
        redirect("index.php");
    }

    if (isset($_POST["cancel-booking"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=? AND `user_id`=?";
        $values = ["cancelled", 0, $filter_data["id"], $_SESSION["userid"]];
        $result = update($query, $values, "siii");
        echo $result;
    }
?>