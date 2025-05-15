<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if (isset($_GET["fetch-rooms"])) {
        $check_availability = json_decode($_GET["check-available"], true);

        if ($check_availability["checkin"] != "" && $check_availability["checkout"] != "") {
            // check-in and check-out filter validations
            $current_date = new DateTime(date("Y-m-d"));
            $checkin_date = new DateTime($check_availability["checkin"]);
            $checkout_date = new DateTime($check_availability["checkout"]);

            if ($checkin_date == $checkout_date) {
                echo "<h3 class='text-center fs-4 text-danger'>Invalid checkin and checkout dates!</h3>";
                exit;
            } else if ($checkout_date < $checkin_date) {
                echo "<h3 class='text-center fs-4 text-danger'>Checkout date is earlier than checkin date!</h3>";
                exit;
            } else if ($checkin_date < $current_date) {
                echo "<h3 class='text-center fs-4 text-danger'>Checkin date is earlier than present date!</h3>";
                exit;
            }
        }

        $guests = json_decode($_GET["guests"], true);
        $adults = ($guests["adult"] != "") ? $guests["adult"] : "";
        $children = ($guests["children"] != "") ? $guests["children"] : "";

        $facilities_list = json_decode($_GET["facilities"], true);

        // count number of rooms and keep track of room cards as output
        $count_rooms = 0;
        $output = "";

        // fetching settings table to check if website is shutdown or not
        $settings_query = "SELECT * FROM `settings` WHERE `sr_no`=1";
        $settings_result = mysqli_fetch_assoc(mysqli_query($connect, $settings_query));

        // room cards query with guest filteration
        $query = "SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=? ORDER BY `id` DESC";
        $values = [$adults, $children, 1, 0];
        $result = select($query, $values, "iiii");

        while ($room_data = mysqli_fetch_assoc($result)) {
            // check room availability filter logic
            if ($check_availability["checkin"] != "" && $check_availability["checkout"] != "") {
                // execute query to check if room is available or not
                $total_booking_query = "SELECT COUNT(*) AS `total_booking` FROM `booking_order` WHERE `booking_status`=? AND `room_id`=? AND `check_out`>? AND `check_in`<?";
                $values = ["booked", $room_data["id"], $check_availability["checkin"], $check_availability["checkout"]];
                $data = mysqli_fetch_assoc(select($total_booking_query, $values, "siss"));

                if (($room_data["quantity"] - $data["total_booking"]) == 0) {
                    continue;
                }
            }

            // get facilities of room with filters
            $count_facilities = 0;
            $facilities_data = "";
            $feacilities_query = "SELECT facility.name, facility.id FROM `facilities` facility INNER JOIN `room_facilities` room_facility ON facility.id=room_facility.facilities_id WHERE room_facility.room_id='$room_data[id]'";
            $feacilities_result = mysqli_query($connect, $feacilities_query);

            while ($facility_row = mysqli_fetch_assoc($feacilities_result)) {
                if (in_array($facility_row["id"], $facilities_list["facilities"])) {
                    $count_facilities++;
                }

                $facilities_data .= "
                    <span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>$facility_row[name]</span>
                ";
            }

            if (count($facilities_list["facilities"]) != $count_facilities) {
                continue;
            }

            // get features of room
            $features_data = "";
            $features_query = "SELECT feature.name FROM `features` feature INNER JOIN `room_features` room_feature ON feature.id=room_feature.features_id WHERE room_feature.room_id='$room_data[id]'";
            $features_result = mysqli_query($connect, $features_query);

            while ($feature_row = mysqli_fetch_assoc($features_result)) {
                $features_data .= "
                    <span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>$feature_row[name]</span>
                ";
            }

            // get thumbnail image of room
            $default_thumbnail = ROOM_IMAGE_PATH."thumbnail.jpg";
            $thumbnail_query = "SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]' AND `thumbnail`='1'";
            $thumbnail_result = mysqli_query($connect, $thumbnail_query);

            if (mysqli_num_rows($thumbnail_result) > 0) {
                $thumbnail = mysqli_fetch_assoc($thumbnail_result);
                $default_thumbnail = ROOM_IMAGE_PATH.$thumbnail["image"];
            }

            $book_button = "";

            if (!$settings_result["shutdown"]) {
                $login = 0;

                if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
                    $login = 1;
                }

                $book_button = "
                    <button onclick='authorizeUser($login, $room_data[id])' class='btn btn-sm w-100 text-white custom-background shadow-none mb-2'>
                        <i class='bi bi-bookmark-fill'></i> Book Now
                    </button>
                ";
            }

            // print room card
            $output .= "
                <div class='card mb-4 border-0 shadow'>
                    <div class='row g-0 p-3 align-items-center'>
                        <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                            <img src='$default_thumbnail' class='img-fluid rounded' alt='Room One' width='100%'>
                        </div>
                        <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                            <h5 class='mb-2'>$room_data[name]</h5>
                            <div class='features mb-2'>
                                <h6 class='mb-1'>Features</h6>
                                $features_data
                            </div>
                            <div class='facilities mb-2'>
                                <h6 class='mb-1'>Facilities</h6>
                                $facilities_data
                            </div>
                            <div class='guests'>
                                <h6 class='mb-1'>Guests</h6>
                                <span class='badge rounded-pill text-dark bg-light text-wrap'>$room_data[children] children</span>
                                <span class='badge rounded-pill text-dark bg-light text-wrap'>$room_data[adult] adult</span>
                            </div>
                        </div>
                        <div class='col-md-2 text-center mt-lg-0 mt-md-0 mt-4'>
                            <h6 class='mb-4'>₹$room_data[price] per night</h6>
                            $book_button
                            <a href='room_details.php?id=$room_data[id]' class='btn btn-sm w-100 btn-outline-dark shadow-none'>
                                <i class='bi bi-exclamation-circle-fill'></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
            ";

            $count_rooms++;
        }

        if ($count_rooms > 0) {
            echo $output;
        } else {
            echo "<h3 class='text-center text-danger'>No Rooms available to show!</h3>";
        }
    }
?>