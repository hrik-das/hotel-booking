<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="./css/index.css">
    <?php require_once("./include/include.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./js/swiper.js" defer></script>
    <script src="./js/reset_password.js" defer></script>
    <title>Home - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                    $result = selectAllData("carousel");

                    while ($data = mysqli_fetch_assoc($result)) {
                        $path = CAROUSEL_IMAGE_PATH;

                        echo<<<data
                            <div class="swiper-slide">
                                <img src="$path$data[image]" class="w-100 d-block" />
                            </div>
                        data;
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Check Availability Form -->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form action="rooms.php">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check In</label>
                            <input type="date" name="checkin" class="form-control shadow-none" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check Out</label>
                            <input type="date" name="checkout" class="form-control shadow-none" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Children</label>
                            <select name="children" class="form-select shadow-none">
                                <?php
                                    $guest_query = "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` FROM `rooms` WHERE `status`='1' AND `removed`='0'";
                                    $guest_result = mysqli_query($connect, $guest_query);
                                    $guest_data = mysqli_fetch_assoc($guest_result);

                                    for ($i=1; $i<=$guest_data["max_children"]; $i++) {
                                        echo "
                                            <option value='$i'>$i</option>
                                        ";
                                    }
                                ?>                                
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;">Adult</label>
                            <select name="adult" id="" class="form-select shadow-none">
                                <?php
                                    for ($i=1; $i<=$guest_data["max_adult"]; $i++) {
                                        echo "
                                            <option value='$i'>$i</option>
                                        ";
                                    }
                                
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="check-availability">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-background">Check</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Our Rooms -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Our Rooms</h2>
    <div class="container">
        <div class="row">
            <?php
                $query = "SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3";
                $values = [1, 0];
                $result = select($query, $values, "ii");

                while ($room_data = mysqli_fetch_assoc($result)) {
                    // get features of room
                    $features_data = "";
                    $features_query = "SELECT feature.name FROM `features` feature INNER JOIN `room_features` room_feature ON feature.id=room_feature.features_id WHERE room_feature.room_id='$room_data[id]'";
                    $features_result = mysqli_query($connect, $features_query);

                    while ($feature_row = mysqli_fetch_assoc($features_result)) {
                        $features_data .= "
                            <span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>$feature_row[name]</span>
                        ";
                    }

                    // get facilities of room
                    $facilities_data = "";
                    $feacilities_query = "SELECT facility.name FROM `facilities` facility INNER JOIN `room_facilities` room_facility ON facility.id=room_facility.facilities_id WHERE room_facility.room_id='$room_data[id]'";
                    $feacilities_result = mysqli_query($connect, $feacilities_query);

                    while ($facility_row = mysqli_fetch_assoc($feacilities_result)) {
                        $facilities_data .= "
                            <span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>$facility_row[name]</span>
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
                            <button onclick='authorizeUser($login, $room_data[id])' class='btn btn-sm text-white custom-background shadow-none'>
                                <i class='bi bi-bookmark-fill'></i> Book Now
                            </button>
                        ";
                    }
                    
                    $rating_data = "";

                    $rating_query = "SELECT  AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
                    $rating_result = mysqli_query($connect, $rating_query);
                    $rating_fetch = mysqli_fetch_assoc($rating_result);

                    if ($rating_fetch["avg_rating"] != null) {
                        $rating_data = "
                            <div class='rating mb-4'>
                                <h6 class='mb-1'>Rating</h6>
                                <span class='badge rounded-pill bg-light'>
                        ";

                        for ($i=0; $i<=$rating_fetch["avg_rating"]; $i++) {
                            $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                        }

                        $rating_data .= "
                                </span>
                            </div>
                        ";
                    }

                    // print room card
                    echo<<<data
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                <img src="$default_thumbnail" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">$room_data[name]</h5>
                                    <h6 class="mb-4">₹$room_data[price] per night</h6>
                                    <div class="features mb-4">
                                        <h6 class="mb-1">Features</h6>
                                        $features_data
                                    </div>
                                    <div class="facilities mb-4">
                                        <h6 class="mb-1">Facilities</h6>
                                        $facilities_data
                                    </div>
                                    <div class="guests mb-4">
                                        <h6 class="mb-1">Guests</h6>
                                        <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[children] children</span>
                                        <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[adult] Adults</span>
                                    </div>
                                    $rating_data
                                    <div class="d-flex justify-content-evenly mb-2">
                                        $book_button
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">
                                            <i class="bi bi-exclamation-circle-fill"></i> More Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    data;
                }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded fw-bold shadow-none">More Rooms >>></a>
            </div>
        </div>
    </div>

    <!-- Our Facilities -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Our Facilities</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
                $query = "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5";
                $result = mysqli_query($connect, $query);
                $path = FACILITY_IMAGE_PATH;

                while ($data = mysqli_fetch_assoc($result)) {
                    echo<<<data
                        <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                            <img src="$path$data[icon]" width="60px">
                            <h5 class="mt-3">$data[name]</h5>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>

    <!-- Testimonials -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Testimonials</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
                <?php
                    $review_query = "SELECT rr.*, uc.username, uc.profile, room.name AS room_name FROM `rating_review` rr INNER JOIN `user_cred` uc ON rr.user_id=uc.id INNER JOIN `rooms` room ON rr.room_id=room.id ORDER BY `sr_no` DESC LIMIT 6";
                    $review_result = mysqli_query($connect, $review_query);
                    $user_image_path = USERS_IMAGE_PATH;

                    if (mysqli_num_rows($review_result) == 0) {
                        echo "no-reviews-yet!";
                    } else {
                        while ($data = mysqli_fetch_assoc($review_result)) {
                            $stars = "<i class='bi bi-star-fill text-warning'></i> ";

                            for ($i=1; $i<$data["rating"]; $i++) {
                                $stars .= " <i class='bi bi-star-fill text-warning'></i>";
                            }

                            echo<<<data
                                <div class="swiper-slide bg-white p-4">
                                    <div class="profile d-flex align-items-center mb-3">
                                        <img src="$user_image_path$data[profile]" width="30px" loading="lazy" class="rounded-circle">
                                        <h6 class="m-0 ms-2">$data[username]</h6>
                                    </div>
                                    <p>$data[review]</p>
                                    <div class="rating">$stars</div>
                                </div>
                            data;
                        }
                    }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded fw-bold shadow-none">Know More >>></a>
        </div>
    </div>

    <!-- Reach Us -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 bg-white rounded">
                <iframe src="<?php echo $contact_result['iframe']; ?>" height="320px" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-100 rounded"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call Us</h5>
                    <a href="tel: +<?php echo $contact_result['phone_one']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_result["phone_one"]; ?>
                    </a><br>

                    <?php
                        if ($contact_result["phone_two"] != "") {
                            echo<<<data
                                <a href="tel: +$contact_result[phone_two]" class="d-inline-block text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i> +$contact_result[phone_two]
                                </a>
                            data;
                        }
                    ?>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow Us</h5>
                    <a href="<?php echo $contact_result['facebook']; ?>" target="_blank" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </span>
                    </a><br>
                    <a href="<?php echo $contact_result['instagram']; ?>" target="_blank" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </span>
                    </a><br>
                    
                    <?php
                        if ($contact_result["twitter"] != "") {
                            echo<<<data
                                <a href="$contact_result[twitter]" target="_blank" class="d-inline-block">
                                    <span class="badge bg-light text-dark fs-6 p-2">
                                        <i class="bi bi-twitter"></i> Twitter
                                    </span>
                                </a>
                            data;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="reset-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel">
                            <i class="bi bi-shield-lock fs-3 me-2"></i> Set New Password
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label">
                                <i class="bi bi-envelope-at-fill"></i> New Password
                            </label>
                            <input type="password" name="password" class="form-control shadow-none" required>
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0 me-2" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark shadow-none">
                                <i class="bi bi-box-arrow-in-right"></i> Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>

    <!-- Reset Password Modal Script -->
    <script src="./js/reset_password.js"></script>

    <?php
        if (isset($_GET["reset-password"])) {
            $filter_data = filteration($_GET);

            $current_date = date("Y-m-d");

            $query = "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `token_expire`=? LIMIT 1";
            $values = [$filter_data["email"], $filter_data["token"], $current_date];
            $result = select($query, $values, "sss");

            if (mysqli_num_rows($result) == 1) {
                echo<<<modal
                    <script>
                        showResetModal("{$filter_data['email']}", "{$filter_data['token']}");
                    </script>
                modal;
            } else {
                alert("error", "Invalid or expired link address!");
            }
        }
    ?>
</body>
</html>