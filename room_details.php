<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Room Details - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <?php
        if (!isset($_GET["id"])) {
            redirect("rooms.php");
        }

        $data = filteration($_GET);

        $query = "SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?";
        $values = [$data["id"], 1, 0];
        $result = select($query, $values, "iii");

        if (mysqli_num_rows($result) == 0) {
            redirect("rooms.php");
        }

        $room_data = mysqli_fetch_assoc($result);
    ?>

    <!-- Body -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4 mb-4">
                <h2 class="fw-bold"><?php echo $room_data["name"]; ?></h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">/</span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <div id="room-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                            // get thumbnail image of room
                            $room_image = ROOM_IMAGE_PATH."thumbnail.jpg";
                            $image_query = "SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]'";
                            $image_result = mysqli_query($connect, $image_query);

                            if (mysqli_num_rows($image_result) > 0) {
                                $active_class = "active";
                                
                                while ($image = mysqli_fetch_assoc($image_result)) {
                                    echo "
                                        <div class='carousel-item $active_class'>
                                            <img src='".ROOM_IMAGE_PATH.$image['image']."' class='d-block w-100 rounded' alt='room-image'>
                                        </div>
                                    ";
                                    $active_class = "";
                                }
                            } else {
                                echo "
                                    <div class='carousel-item active'>
                                        <img src='$room_image' class='d-block w-100' alt='room-image'>
                                    </div>
                                ";
                            }
                        ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#room-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#room-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                            echo<<<price
                                <h4>₹$room_data[price] per night</h4>
                            price;

                            $rating_data = "";

                            $rating_query = "SELECT  AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
                            $rating_result = mysqli_query($connect, $rating_query);
                            $rating_fetch = mysqli_fetch_assoc($rating_result);

                            if ($rating_fetch["avg_rating"] != null) {
                                for ($i=0; $i<$rating_fetch["avg_rating"]; $i++) {
                                    $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                                }
                            }

                            echo<<<rating
                                <div class="mb-3">
                                    $rating_data
                                </div>
                            rating;

                            // get features of room
                            $features_data = "";
                            $features_query = "SELECT feature.name FROM `features` feature INNER JOIN `room_features` room_feature ON feature.id=room_feature.features_id WHERE room_feature.room_id='$room_data[id]'";
                            $features_result = mysqli_query($connect, $features_query);

                            while ($feature_row = mysqli_fetch_assoc($features_result)) {
                                $features_data .= "
                                    <span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>$feature_row[name]</span>
                                ";
                            }

                            echo<<<features
                                <div class="features mb-2">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>
                            features;

                            // get facilities of room
                            $facilities_data = "";
                            $feacilities_query = "SELECT facility.name FROM `facilities` facility INNER JOIN `room_facilities` room_facility ON facility.id=room_facility.facilities_id WHERE room_facility.room_id='$room_data[id]'";
                            $feacilities_result = mysqli_query($connect, $feacilities_query);

                            while ($facility_row = mysqli_fetch_assoc($feacilities_result)) {
                                $facilities_data .= "
                                    <span class='badge rounded-pill text-dark bg-light text-wrap me-1 mb-1'>$facility_row[name]</span>
                                ";
                            }

                            echo<<<facilities
                                <div class="facilities mb-2">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                            facilities;

                            echo<<<guests
                                <div class="guests mb-3">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[children] children</span>
                                    <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[adult] adult</span>
                                </div>
                            guests;

                            echo<<<area
                                <div class="area mb-3">
                                    <h6 class="mb-1">Area</h6>
                                    <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[area] sqft</span>
                                </div>
                            area;

                            if (!$settings_result["shutdown"]) {
                                $login = 0;

                                if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
                                    $login = 1;
                                }

                                echo<<<book
                                    <button onclick="authorizeUser($login, $room_data[id])" class="btn w-100 text-white custom-background shadow-none mb-1">
                                        <i class="bi bi-bookmark-fill"></i> Book Now
                                    </button>
                                book;
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-12 px-4 mt-4">
                <div class="mb-5">
                    <h5>Description</h5>
                    <p>
                        <?php echo $room_data["description"]; ?>
                    </p>
                </div>

                <div class="review-rating">
                    <h5 class="mb-3">Review and Rating</h5>

                    <?php
                        $review_query = "SELECT rr.*, uc.username, uc.profile, room.name AS room_name FROM `rating_review` rr INNER JOIN `user_cred` uc ON rr.user_id=uc.id INNER JOIN `rooms` room ON rr.room_id=room.id WHERE rr.room_id='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 15";
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

                                echo<<<reviews
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="$user_image_path$data[profile]" width="30px" loading="lazy" class="rounded-circle">
                                            <h6 class="m-0 ms-2">$data[username]</h6>
                                        </div>
                                        <p class="mb-1">$data[review]</p>
                                        <div class="rating">$stars</div>
                                    </div>
                                reviews;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>