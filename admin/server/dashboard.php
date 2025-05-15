<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["booking-analytics"])) {
        $filter_data = filteration($_POST);

        if ($filter_data["period"] == 1) {
            $condition = "WHERE date_time BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        } else if ($filter_data["period"] == 2) {
            $condition = "WHERE date_time BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        } else if ($filter_data["period"] == 3) {
            $condition = "WHERE date_time BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        } else {
            $condition = "";
        }

        $query = "SELECT
            COUNT(CASE WHEN booking_status!='pending' AND booking_status!='failed' THEN 1 END) AS `total_bookings`,
            SUM(CASE WHEN booking_status!='pending' AND booking_status!='failed' THEN `transaction_amount` END) AS `total_amount`, COUNT(CASE WHEN booking_status='booked' AND arrival=1 THEN 1 END) AS `active_bookings`,
            COUNT(CASE WHEN booking_status='cancelled' AND refund=1 THEN 1 END) AS `cancelled_bookings`,
            SUM(CASE WHEN booking_status='booked' AND arrival=1 THEN `transaction_amount` END) AS `active_amount`,
            SUM(CASE WHEN booking_status='cancelled' AND refund=1 THEN `transaction_amount` END) AS `cancelled_amount`
        FROM `booking_order` $condition";
        $bookings_data = mysqli_fetch_assoc(mysqli_query($connect, $query));
        $output = json_encode($bookings_data);
        echo $output;
    }

    if (isset($_POST["user-analytics"])) {
        $filter_data = filteration($_POST);

        if ($filter_data["period"] == 1) {
            $condition = "WHERE date_time BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        } else if ($filter_data["period"] == 2) {
            $condition = "WHERE date_time BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        } else if ($filter_data["period"] == 3) {
            $condition = "WHERE date_time BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        } else {
            $condition = "";
        }

        $total_queries = "SELECT COUNT(sr_no) AS `count` FROM `user_queries` $condition";
        $queries_result = mysqli_fetch_assoc(mysqli_query($connect, $total_queries));

        $total_reviews = "SELECT COUNT(sr_no) AS `count` FROM `rating_review` $condition";
        $reviews_result = mysqli_fetch_assoc(mysqli_query($connect, $total_reviews));

        $total_registration = "SELECT COUNT(id) AS `count` FROM `user_cred` $condition";
        $registration_result = mysqli_fetch_assoc(mysqli_query($connect, $total_registration));

        $output = ["total_queries" => $queries_result["count"], "total_reviews" => $reviews_result["count"], "total_registration" => $registration_result["count"]];
        $output = json_encode($output);
        echo $output;
    }
?>