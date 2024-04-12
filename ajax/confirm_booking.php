<?php
    require("../admin/include/essential.php");
    require("../admin/include/connect.php");
    date_default_timezone_set("Asia/Kolkata");

    if(isset($_POST["checkAvailability"])){
        $filterData = filteration($_POST);
        $status = "";
        $result = "";
        // Check In and Out Validations
        $todayDate = new DateTime(date("Y-m-d"));
        $checkInDate = new DateTime($filterData["checkin"]);
        $checkOutDate = new DateTime($filterData["checkout"]);
        if($checkInDate == $checkOutDate){
            $status = "Check_in_out_equal";
            $result = json_encode(["status" => $status]);
        }else if($checkOutDate < $checkInDate){
            $status = "Check_out_earlier";
            $result = json_encode(["status" => $status]);
        }else if($checkInDate < $todayDate){
            $status = "Check_in_earlier";
            $result = json_encode(["status" => $status]);
        }
        // Check Booking Availability If Status is Blank else Return Error
        if($status != ""){
            echo $result;
        }else{
            session_start();
            $totalBookings = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` WHERE booking_status=? AND room_id=? AND checkout > ? AND checkin < ?";
            $values = ["booked", $_SESSION["room"]["id"], $filterData["checkin"], $filterData["checkout"]];
            $totalBookingFetch = mysqli_fetch_assoc(select($totalBookings, $values, "siss"));
            $roomResult = select("SELECT `quantity` FROM `rooms` WHERE `id`=?", [$_SESSION["room"]["id"]], "i");
            $roomFetch = mysqli_fetch_assoc($roomResult);
            if(($roomFetch["quantity"]-$totalBookingFetch["total_bookings"]) == 0){
                $status = "unavailable";
                $result = json_encode(["status" => $status]);
                echo $result;
                exit();
            }
            $countDays = date_diff($checkInDate, $checkOutDate) -> days;
            $payment = $_SESSION["room"]["price"] * $countDays;
            $_SESSION["room"]["payment"] = $payment;
            $_SESSION["room"]["available"] = true;
            $result = json_encode(["status" => "available", "days" => $countDays, "payment" => $payment]);
            echo $result;
        }
    }
?>