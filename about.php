<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <?php require("include/links.php"); ?>
    <link rel="stylesheet" href="./css/about.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./js/swiper.js" defer></script>
    <title><?php echo $settings_r["site_title"]; ?> - About</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("include/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">About Us</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nihil <br> mollitia placeat aliquid ut voluptatem, animi iste esse ab nostrum.</p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Lorem ipsum dolor sit</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui, veritatis delectus doloribus unde deserunt nemo? Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad quisquam nihil tempore molestias iste possimus similique architecto nobis vel harum!</p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <img src="./images/about/about.jpg" alt="" class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="./images/about/hotel.svg" alt="" width="70px">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="./images/about/staff.svg" alt="" width="70px">
                    <h4 class="mt-3">150+ Staffs</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="./images/about/customers.svg" alt="" width="70px">
                    <h4 class="mt-3">200+ Customers</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="./images/about/rating.svg" alt="" width="70px">
                    <h4 class="mt-3">150+ Ratings</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="new-font my-5 fw-bold text-center">Management Team</h3>
    <div class="container px-4">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php 
                    $path = ABOUT_IMG_PATH;
                    $aboutResult = selectAll("team_details");
                    while($data = mysqli_fetch_assoc($aboutResult)){
                        echo<<<data
                            <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                                <img src="$path$data[picture]" alt="" class="w-100">
                                <h5 class="mt-2">$data[name]</h5>
                            </div>
                        data;
                    }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("include/footer.php"); ?>
</body>
</html>