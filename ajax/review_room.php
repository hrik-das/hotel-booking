<?php
    require("../admin/include/connect.php");
    require("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();
    if(!(isset($_SESSION["login"]) && $_SESSION["login"] == true)){
        redirect("index.php");
    }

    if(isset($_POST["review-form"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `booking_order` SET `rate_review`=? WHERE `booking_id`=? AND `user_id`=?";
        $values = [1, $filterData["booking_id"], $_SESSION["userid"]];
        $result = update($query, $values, "iii");
        $insertQuery = "INSERT INTO `rating_review` (`booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?, ?, ?, ?, ?)";
        $insertValues = [$filterData["booking_id"], $filterData["room_id"], $_SESSION["userid"], $filterData["rating"], $filterData["review"]];
        $insertResult = insert($insertQuery, $insertValues, "iiiis");
        echo $insertResult;
    }
?>