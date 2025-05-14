<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
        redirect("index.php");
    }

    if (isset($_POST["review-form"])) {
        $filter_data = filteration($_POST);

        $insert_query = "INSERT INTO `rating_review` (`booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?, ?, ?, ?, ?)";
        $insert_values = [$filter_data["booking-id"], $filter_data["room-id"], $_SESSION["userid"], $filter_data["rating"], $filter_data["review"]];
        $insert_result = insert($insert_query, $insert_values, "iiiis");

        $query = "UPDATE `booking_order` SET `rate_review`=? WHERE `booking_id`=? AND `user_id`=?";
        $values = [1, $filter_data["booking-id"], $_SESSION["userid"]];
        $result = update($query, $values, "iii");

        echo $insert_result;
    }
?>