<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Our Rooms - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Rooms</h2>
        <div class="horizontal-line bg-dark"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch p-3">
                        <h4 class="mt-2 new-font">Filters</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="filterDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch" id="filterDropdown">
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Check Availability</h5>
                                <label class="form-label">Check-In</label>
                                <input type="date" name="" id="" class="form-control shadow-none mb-3">
                                <label class="form-label">Check-Out</label>
                                <input type="date" name="" id="" class="form-control shadow-none">
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Facilities</h5>
                                <div class="mb-2">
                                    <input type="checkbox" name="" id="f-one" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" for="f-one">Facility One</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" name="" id="f-two" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" for="f-two">Facility Two</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" name="" id="f-three" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" for="f-three">Facility Three</label>
                                </div>
                            </div>
                            <div class="border bg-light p-3 rounded">
                                <h5 class="mb-3" style="font-size: 18px;">Guests</h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label" for="f-one">Children</label>
                                        <input type="number" name="" id="" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label" for="f-one">Adults</label>
                                        <input type="number" name="" id="" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4">
                <?php
                    $query = "SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC";
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

                        // print room card
                        echo<<<data
                            <div class="card mb-4 border-0 shadow">
                                <div class="row g-0 p-3 align-items-center">
                                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                        <img src="$default_thumbnail" class="img-fluid rounded" alt="Room One" width="100%">
                                    </div>
                                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                        <h5 class="mb-2">$room_data[name]</h5>
                                        <div class="features mb-2">
                                            <h6 class="mb-1">Features</h6>
                                            $features_data
                                        </div>
                                        <div class="facilities mb-2">
                                            <h6 class="mb-1">Facilities</h6>
                                            $facilities_data
                                        </div>
                                        <div class="guests">
                                            <h6 class="mb-1">Guests</h6>
                                            <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[children] children</span>
                                            <span class="badge rounded-pill text-dark bg-light text-wrap">$room_data[adult] adult</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center mt-lg-0 mt-md-0 mt-4">
                                        <h6 class="mb-4">₹$room_data[price] per night</h6>
                                        <a href="#" class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                            <i class="bi bi-bookmark-fill"></i> Book Now
                                        </a>
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                            <i class="bi bi-exclamation-circle-fill"></i> More Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        data;
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>