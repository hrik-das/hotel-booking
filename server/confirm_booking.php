<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");

    if (isset($_POST["check-availability"])) {
        $filter_data = filteration($_POST);
        $status = $result = "";

        // check-in and check-out validations
        $current_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($filter_data["check-in"]);
        $checkout_date = new DateTime($filter_data["check-out"]);

        if ($checkin_date == $checkout_date) {
            $status = "equal-check-in-out-date";
            $result = json_encode(["status" => $status]);
        } else if ($checkout_date < $checkin_date) {
            $status = "earlier-check-out-date";
            $result = json_encode(["status" => $status]);
        } else if ($checkin_date < $current_date) {
            $status = "earlier-check-in-date";
            $result = json_encode(["status" => $status]);
        }

        // check booking availability if status is blank else return the error
        if ($status != "") {
            echo $result;
        } else {
            session_start();

            // execute query to check if room is available or not
            $total_booking_query = "SELECT COUNT(*) AS `total_booking` FROM `booking_order` WHERE `booking_status`=? AND `room_id`=? AND `check_out`>? AND `check_in`<?";
            $values = ["booked", $_SESSION["room"]["id"], $filter_data["check-in"], $filter_data["check-out"]];
            $data = mysqli_fetch_assoc(select($total_booking_query, $values, "siss"));

            $room_query = "SELECT `quantity` FROM `rooms` WHERE `id`=?";
            $room_values = [$_SESSION["room"]["id"]];
            $room_result = select($room_query, $room_values, "i");
            $room_fetch = mysqli_fetch_assoc($room_result);

            if (($room_fetch["quantity"] - $data["total_booking"]) <= 0) {
                $status = "unavailable";
                $result = json_encode(["status" => $status]);
                echo $result;
                exit;
            }

            $count_days = date_diff($checkin_date, $checkout_date) -> days;
            $payment = $_SESSION["room"]["price"] * $count_days;

            $_SESSION["room"]["payment"] = $payment;
            $_SESSION["room"]["available"] = true;

            $result = json_encode(["status" => "available", "days" => $count_days, "payment" => $payment]);
            echo $result;
        }
    }
?>