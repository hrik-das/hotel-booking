<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="./css/index.css">
    <?php require("include/links.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./js/swiper.js" defer></script>
    <script src="./js/recover_password.js" defer></script>
    <title><?php echo $settings_r["site_title"]; ?> - Home</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("include/header.php"); ?>

    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                    $result = selectAll("carousel");
                    while($data = mysqli_fetch_assoc($result)){
                        $path = CAROUSEL_IMG_PATH;
                        echo<<<data
                            <div class="swiper-slide">
                                <img src="$path$data[image]" class="w-100 d-block"/>
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
                <form action="">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-In</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-Out</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Adults</label>
                            <select class="form-select shadow-none">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;">Childrens</label>
                            <select class="form-select shadow-none">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
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
                $query = "SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3 ";
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
                    $bookButton = "";
                    if(!($settings_r["shutdown"])){
                        $login = 0;
                        if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
                            $login = 1;
                        }
                        $bookButton = "<button onclick='checkLoginToBook($login, $data[id])' class='btn btn-sm text-white custom-bg shadow-none mb-2'>Book Now</button>";
                    }
                    // Print Room Card
                    echo<<<data
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                <img src="$roomThumbnail" class="card-img-top" alt="Room 1">
                                <div class="card-body">
                                    <h5>$data[name]</h5>
                                    <h6 class="mb-4">₹$data[price] Per Night</h6>
                                    <div class="features mb-4">
                                        <h6 class="mb-1">Features</h6>
                                        $featuresData
                                    </div>
                                    <div class="facilities mb-4">
                                        <h6 class="mb-1">Facilities</h6>
                                        $facilitiesData
                                    </div>
                                    <div class="guests mb-4">
                                        <h6 class="mb-1">Guests</h6>
                                        <span class="badge bg-light text-dark text-wrap rounded-pill">$data[adult] Adults</span>
                                        <span class="badge bg-light text-dark text-wrap rounded-pill">$data[children] Children</span>
                                    </div>
                                    <div class="rating mb-4">
                                        <h6 class="mb-1">Rating</h6>
                                        <span class="badge rounded-pill bg-light">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-evenly mb-2">
                                        $bookButton
                                        <a href="room_details.php?id=$data[id]" class="btn btn-sm btn-outline-dark shadow-none mb-2">More Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    data;
                }
            ?>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded fw-bold shadow-none">More Rooms >>></a>
        </div>
    </div>

    <!-- Our Facilities -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Our Facilities</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
                $result = mysqli_query($connect, "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
                $path = FACILITIES_IMG_PATH;
                while($data = mysqli_fetch_assoc($result)){
                    echo<<<data
                        <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                            <img src="$path$data[icon]" alt="" width="60px">
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
                <div class="swiper-slide bg-white p-4">
                    <div class="profile align-items-center mb-3">
                        <img src="./images/about/staff.svg" alt="" width="30px">
                        <h6 class="mt-2">Random User</h6>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis, reiciendis eligendi voluptates possimus corrupti iste magni excepturi atque sapiente laudantium!</p>
                        <div class="rating">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile align-items-center mb-3">
                        <img src="./images/about/staff.svg" alt="" width="30px">
                        <h6 class="mt-2">Random User</h6>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis, reiciendis eligendi voluptates possimus corrupti iste magni excepturi atque sapiente laudantium!</p>
                        <div class="rating">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile align-items-center mb-3">
                        <img src="./images/about/staff.svg" alt="" width="30px">
                        <h6 class="mt-2">Random User</h6>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis, reiciendis eligendi voluptates possimus corrupti iste magni excepturi atque sapiente laudantium!</p>
                        <div class="rating">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>
                </div>
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
                <iframe src="<?php echo $contactResult['iframe']; ?>" height="380" loading="lazy" class="w-100 rounded"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call Us</h5>
                    <a href="tel: <?php echo $contactResult['phone1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contactResult["phone1"]; ?>
                    </a><br>
                    <?php
                        if($contactResult["phone2"] != ""){
                            echo<<<data
                                <a href="tel: +$contactResult[phone2]" class="d-inline-block text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i> +$contactResult[phone2]
                                </a>
                            data;
                        }
                    ?>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow Us</h5>
                    <?php 
                        if($contactResult["tw"] != ""){
                            echo<<<data
                                <a href="$contactResult[tw]" class="d-inline-block mb-3">
                                    <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-twitter me-1"></i> Twitter</span>
                                </a><br>
                            data;
                        }
                    ?>
                    <a href="<?php echo $contactResult['fb']; ?>" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-facebook"></i> Facebook</span>
                    </a><br>
                    <a href="<?php echo $contactResult['insta']; ?>" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-instagram"></i> Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Reset Modal -->
    <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="recovery-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-shield-lock fs-3 me-2"></i> Set Up New Password
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="pass" class="form-control shadow-none" required>
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>
                        <div class="text-end mb-2">
                            <button type="button" class="btn shadow-none" data-bs-toggle="modal" data-bs-target="#recoveryModal" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require("./ajax/recovery_password.php"); ?>
    <!-- Footer -->
    <?php require("include/footer.php"); ?>
</body>
</html>