<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("include/links.php"); ?>
    <title><?php echo $settings_r["site_title"]; ?> - Rooms</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("include/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Rooms</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <!-- Filters -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-4 ps-4 mb-lg-0 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="navbar-brand mt-2" href="#">Filters</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="filterDropDown">
                        <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Check Availability</h5>
                                <label class="form-label">Check-In</label>
                                <input type="date" class="form-control shadow-none mb-3">
                                <label class="form-label">Check-Out</label>
                                <input type="date" class="form-control shadow-none">
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Facilities</h5>
                                <div class="mb-2">
                                    <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" for="f1">Facility One</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" for="f2">Facility Two</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" for="f3">Facility Three</label>
                                </div>
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Guests</h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input type="number" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label">Childrens</label>
                                        <input type="number" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9 col-md-12 px-4">
                <?php
                    $query = "SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?";
                    $values = [1, 0];
                    $roomResult = select($query, $values, "ii");
                    while($data = mysqli_fetch_assoc($roomResult)){
                        // Get Features of Rooms
                        $featuresQuery = "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$data[id]'";
                        $featuresResult = mysqli_query($connect, $featuresQuery);
                        $featuresData = "";
                        while($featuresRow = mysqli_fetch_assoc($featuresResult)){
                            $featuresData .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base'>$featuresRow[name]</span>";
                        }
                        // Get Facilities of Rooms
                        $facilitiesQuery = "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$data[id]'";
                        $facilitiesResult = mysqli_query($connect, $facilitiesQuery);
                        $facilitiesData = "";
                        while($facilitiesRow = mysqli_fetch_assoc($facilitiesResult)){
                            $facilitiesData .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base'>$facilitiesRow[name]</span>";
                        }
                        // Get Thumbnail of Rooms
                        $roomThumbnail = ROOM_IMG_PATH."thumbnail.jpg";
                        $query = "SELECT * FROM `room_image` WHERE `room_id`=$data[id] AND `thumbnail`='1'";
                        $thumbnailQuery = mysqli_query($connect, $query);
                        if(mysqli_num_rows($thumbnailQuery) > 0){
                            $thumbnailResult = mysqli_fetch_assoc($thumbnailQuery);
                            $roomThumbnail = ROOM_IMG_PATH.$thumbnailResult["image"];
                        }
                        // $bookButton = "";
                        // if(!($settings_r["shutdown"])){
                        //     $login = 0;
                        //     if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
                        //         $login = 1;
                        //     }
                        //     $bookButton = "<button onclick='checkLoginToBook($login, $data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>";
                        // }
                        // Print Room Card
                        echo<<<data
                            <div class="card mb-4 border-0 shadow">
                                <div class="row g-0 p-3 align-items-center">
                                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-4">
                                        <img src="$roomThumbnail" class="img-fluid rounded" alt="Room One">
                                    </div>
                                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                        <h5 class="">$data[name]</h5>
                                        <div class="features mb-2">
                                            <h6 class="mb-1">Features</h6>
                                            $featuresData
                                        </div>
                                        <div class="facilities mb-2">
                                            <h6 class="mb-1">Facilities</h6>
                                            $facilitiesData
                                        </div>
                                        <div class="guests">
                                            <h6 class="mb-1">Guests</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">$data[adult] Adults</span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">$data[children] Children</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h6 class="mb-4">₹$data[price] Per Night</h6>
                                        $bookButton
                                        <a href="room_details.php?id=$data[id]" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
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
    <?php require("include/footer.php"); ?>
</body>
</html>