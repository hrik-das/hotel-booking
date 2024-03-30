<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <title><?php echo $settings_r["site_title"]; ?> - Room Details</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("./include/header.php"); ?>
    <?php
        if(!(isset($_GET["id"]))){
            redirect("rooms.php");
        }
        $data = filteration($_GET);
        $roomResult = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data["id"], 1, 0], "iii");
        if(mysqli_num_rows($roomResult) == 0){
            redirect("rooms.php");
        }
        $data = mysqli_fetch_assoc($roomResult);
    ?>

    <!-- Filters -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold"><?php echo $data["name"] ?></h2>
                <div id="room-style">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                            //Get Thumbnail of Rooms
                            $roomImage = ROOM_IMG_PATH."thumbnail.jpg";
                            $query = "SELECT * FROM `room_image` WHERE `room_id`='$data[id]'";
                            $imageQuery = mysqli_query($connect, $query);
                            if(mysqli_num_rows($imageQuery) > 0){
                                $activeClass = "active";
                                while($imageResult = mysqli_fetch_assoc($imageQuery)){
                                    echo "<div class='carousel-item $activeClass'>
                                              <img src='".ROOM_IMG_PATH.$imageResult['image']."' class='d-block w-100 rounded' alt='...'>
                                          </div>";
                                    $activeClass = "";
                                }
                            }else{
                                echo "<div class='carousel-item active'>
                                          <img src='$roomImage' class='d-block w-100' alt='...'>
                                      </div>";
                            }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                            echo <<<price
                                <h4>₹$data[price] Per Night</h4>
                            price;
                            echo <<<rating
                                <div class="mb-3">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                            rating;
                            $query1 = "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$data[id]'";
                            $featuresQuery = mysqli_query($connect, $query1);
                            $featuresData = "";
                            while($featuresRow = mysqli_fetch_assoc($featuresQuery)){
                                $featuresData .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base'>$featuresRow[name]</span>";
                            }
                            echo<<<features
                                <div class="mb-2">
                                    <h6 class="mb-1">Features</h6>
                                        $featuresData
                                </div>
                            features;
                            $query2 = "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$data[id]'";
                            $facilitiesQuery = mysqli_query($connect, $query2);
                            $facilitiesData = "";
                            while($facilitiesRow = mysqli_fetch_assoc($facilitiesQuery)){
                                $facilitiesData .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base'>$facilitiesRow[name]</span>";
                            }
                            echo<<<facilities
                                <div class="mb-2">
                                    <h6 class="mb-1">Facilities</h6>
                                        $facilitiesData
                                </div>
                            facilities;
                            echo<<<guests
                                <div class="mb-2">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">$data[adult] Adults</span>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">$data[children] Children</span>
                                </div>
                            guests;
                            echo<<<area
                                <div class="mb-2">
                                    <h6 class="mb-1">Area</h6>
                                    <span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base'>$data[area] sqft.</span>
                                </div>
                            area;
                            // if(!($settings_r['shutdown'])){
                            //     $login = 0;
                            //     if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                            //         $login = 1;
                            //     }
                            //     echo<<<book
                            //         <button onclick='checkLoginToBook($login, $data[id])' class='btn w-100 text-white custom-bg shadow-none mb-1'>Book Now</button>
                            //     book;
                            // }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-12 px-4 mt-4">
                <div class="mb-5">
                    <h5>Description</h5>
                    <p><?php echo $data["description"] ?></p>
                </div>

                <div class="review-rating">
                    <h5 class="mb-3">Reviews & Rating</h5>
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <img src="./images/facilities/massage.svg" alt="" width="30px">
                            <h6 class="m-0 ms-2">Random User 1</h6>
                        </div>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt qui inventore vero! Necessitatibus
                        distinctio illum culpa in consequuntur quod sed!</p>
                        <div class="rating">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("./include/footer.php"); ?>
</body>
</html>