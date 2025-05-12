<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/confirm_booking.js" defer></script>
    <title>Confirm Booking - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <?php
        /*
        - check the room id from URL is present or not
        - shutdown mode is active or not
        - user logged in or not
        */
        if (!isset($_GET["id"]) || $settings_result["shutdown"] == true) {
            redirect("rooms.php");
        } else if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
            redirect("rooms.php");
        }

        // filter and get room data and user data
        $data = filteration($_GET);

        $query = "SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?";
        $values = [$data["id"], 1, 0];
        $result = select($query, $values, "iii");

        if (mysqli_num_rows($result) == 0) {
            redirect("rooms.php");
        }

        $room_data = mysqli_fetch_assoc($result);

        $_SESSION["room"] = [
            "id" => "$room_data[id]",
            "name" => "$room_data[name]",
            "price" => "$room_data[price]",
            "payment" => null,
            "available" => false,
        ];

        $user_query = "SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1";
        $user_values = [$_SESSION["userid"]];
        $user_result = select($user_query, $user_values, "i");
        $user_data = mysqli_fetch_assoc($user_result);


    ?>

    <!-- Body -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4 mb-4">
                <h2 class="fw-bold">Confirm Booking</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">/</span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                    <span class="text-secondary">/</span>
                    <a href="#" class="text-secondary text-decoration-none">Confirm</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <?php
                    // get thumbnail image of room
                    $default_thumbnail = ROOM_IMAGE_PATH."thumbnail.jpg";
                    $thumbnail_query = "SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]' AND `thumbnail`='1'";
                    $thumbnail_result = mysqli_query($connect, $thumbnail_query);

                    if (mysqli_num_rows($thumbnail_result) > 0) {
                        $thumbnail = mysqli_fetch_assoc($thumbnail_result);
                        $default_thumbnail = ROOM_IMAGE_PATH.$thumbnail["image"];
                    }

                    echo<<<data
                        <div class="card p-3 shadow-sm rounded">
                            <img src="$default_thumbnail" alt="$default_thumbnail" class="img-fluid rounded mb-3"/>
                            <h5>$room_data[name]</h5>
                            <h6>₹$room_data[price] per night</h6>
                        </div>
                    data;
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="payment.php" method="post" id="booking-form">
                            <h6 class="mb-3 fw-bold">Booking Details</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-1">Name</label>
                                    <input type="text" name="name" class="form-control shadow-none" value="<?php echo $user_data["username"]; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-1">Phone Number</label>
                                    <input type="number" name="phone" class="form-control shadow-none" value="<?php echo $user_data["phone"]; ?>" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label mb-1">Email Address</label>
                                    <input type="email" name="email" class="form-control shadow-none" value="<?php echo $user_data["email"]; ?>" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label mb-1">Permanent Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" style="resize: none;" required><?php echo $user_data["address"]; ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-1">Check-In</label>
                                    <input type="date" name="checkin" class="form-control shadow-none" onchange="checkAvailability()" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label mb-1">Check-Out</label>
                                    <input type="date" name="checkout" class="form-control shadow-none" onchange="checkAvailability()" required>
                                </div>
                                <div class="col-12 mb-1">
                                    <div class="spinner-border text-primary mb-3 d-none" role="status" id="info-loader">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="text-danger mb-3" id="payment-info">Provide check-in and check-out date!</h6>
                                    <button type="submit" name="payment" class="btn w-100 text-dark custom-background shadow-none" disabled>
                                        <i class="bi bi-credit-card"></i> Make Payment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>