<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <script src="./js/confirm_booking.js" defer></script>
    <title><?php echo $settings_r["site_title"]; ?> - Confirm Booking</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("./include/header.php"); ?>
    <?php
        if(!isset($_GET["id"]) || $settings_r["shutdown"] == true){
            redirect("rooms.php");
        }else if(!(isset($_SESSION["login"]) && $_SESSION["login"] == true)){
            redirect("rooms.php");
        }
        $data = filteration($_GET);
        $roomResult = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data["id"], 1, 0], "iii");
        if(mysqli_num_rows($roomResult) == 0){
            redirect("rooms.php");
        }
        $data = mysqli_fetch_assoc($roomResult);
        $_SESSION["room"] = [
            "id" => $data["id"],
            "name" => $data["name"],
            "price" => $data["price"],
            "payment" => null,
            "available" => false
        ];
        $user = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION["userid"]], "i");
        $userData = mysqli_fetch_assoc($user);
    ?>

    <!-- Filters -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4 mb-4">
                <h2 class="fw-bold">Confirm Booking</h2>
                <div id="room-style">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                    <span class="text-secondary"> > </span>
                    <a href="" class="text-secondary text-decoration-none">Confirm</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <?php
                    $roomThumbnail = ROOM_IMG_PATH."thumbnail.jpg";
                    $query = "SELECT * FROM `room_image` WHERE `room_id`='$data[id]' AND `thumbnail`='1'";
                    $thumbnailQuery = mysqli_query($connect, $query);
                    if(mysqli_num_rows($thumbnailQuery) > 0){
                        $thumbnailResult = mysqli_fetch_assoc($thumbnailQuery);
                        $roomThumbnail = ROOM_IMG_PATH.$thumbnailResult["image"];
                    }
                    echo <<<data
                        <div class="card p-3 shadow-sm rounded">
                            <img src="$roomThumbnail" class="img-fluid rounded mb-3" alt="Room One">
                            <h5>$data[name]</h5>
                            <h6>₹$data[price] Per Night</h6>
                        </div>
                    data;
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="pay_now.php" method="post" id="booking-form">
                            <h6 class="mb-3 fw-bold">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" value="<?php echo $userData['name']; ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="number" name="phone" value="<?php echo $userData['phone']; ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control shadow-none" name="address" rows="1" required><?php echo $userData["address"]; ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check In</label>
                                    <input type="date" onchange="checkAvailability()" name="checkin" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check Out</label>
                                    <input type="date" onchange="checkAvailability()" name="checkout" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info-loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="mb-3 text-danger" id="pay-info">Provide Check-In and Check-Out Date!</h6>
                                    <button class="btn w-100 text-white custom-bg shadow-none mb-1" name="paynow" disabled>Pay Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("./include/footer.php"); ?>
</body>
</html>