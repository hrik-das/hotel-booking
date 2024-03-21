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
    <title>Godlike Restaurant - Home</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("include/header.php"); ?>

    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./images/carousel/1.png" class="w-100 d-block"/>
                </div>
                <div class="swiper-slide">
                    <img src="./images/carousel/2.png" class="w-100 d-block"/>
                </div>
                <div class="swiper-slide">
                    <img src="./images/carousel/3.png" class="w-100 d-block"/>
                </div>
                <div class="swiper-slide">
                    <img src="./images/carousel/4.png" class="w-100 d-block"/>
                </div>
                <div class="swiper-slide">
                    <img src="./images/carousel/5.png" class="w-100 d-block"/>
                </div>
                <div class="swiper-slide">
                    <img src="./images/carousel/6.png" class="w-100 d-block"/>
                </div>
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
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./images/rooms/1.jpg" class="card-img-top" alt="Room 1">
                    <div class="card-body">
                        <h5>Simple Room</h5>
                        <h6 class="mb-4">₹200 Per Night</h6>
                        <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Rooms</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Bathrooms</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">1 Balcony</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">3 Sofa</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Bedrooms</span>
                        </div>
                        <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Wifi</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">AC</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Smart TV</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Geyser</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Massage</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Room Heater</span>
                        </div>
                        <div class="guests mb-4">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">5 Adults</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">4 Children</span>
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
                            <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
                            <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./images/rooms/1.jpg" class="card-img-top" alt="Room 1">
                    <div class="card-body">
                        <h5>Simple Room</h5>
                        <h6 class="mb-4">₹200 Per Night</h6>
                        <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Rooms</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Bathrooms</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">1 Balcony</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">3 Sofa</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Bedrooms</span>
                        </div>
                        <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Wifi</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">AC</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Smart TV</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Geyser</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Massage</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Room Heater</span>
                        </div>
                        <div class="guests mb-4">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">5 Adults</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">4 Children</span>
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
                            <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
                            <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./images/rooms/1.jpg" class="card-img-top" alt="Room 1">
                    <div class="card-body">
                        <h5>Simple Room</h5>
                        <h6 class="mb-4">₹200 Per Night</h6>
                        <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Rooms</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Bathrooms</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">1 Balcony</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">3 Sofa</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">2 Bedrooms</span>
                        </div>
                        <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Wifi</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">AC</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Smart TV</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Geyser</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Massage</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">Room Heater</span>
                        </div>
                        <div class="guests mb-4">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">5 Adults</span>
                            <span class="badge bg-light text-dark text-wrap rounded-pill">4 Children</span>
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
                            <a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>
                            <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="" class="btn btn-sm btn-outline-dark rounded fw-bold shadow-none">More Rooms >>></a>
        </div>
    </div>

    <!-- Our Facilities -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Our Facilities</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                <img src="./images/facilities/internet.svg" alt="" width="80px">
                <h5 class="mt-3">Unlimited Wifi</h5>
            </div>
            <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                <img src="./images/facilities/ac.svg" alt="" width="80px">
                <h5 class="mt-3">Unlimited Wifi</h5>
            </div>
            <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                <img src="./images/facilities/heater.svg" alt="" width="80px">
                <h5 class="mt-3">Unlimited Wifi</h5>
            </div>
            <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                <img src="./images/facilities/tv.svg" alt="" width="80px">
                <h5 class="mt-3">Unlimited Wifi</h5>
            </div>
            <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                <img src="./images/facilities/massage.svg" alt="" width="80px">
                <h5 class="mt-3">Unlimited Wifi</h5>
            </div>
            <div class="col-lg-12 text-center mt-5">
                <a href="" class="btn btn-sm btn-outline-dark rounded fw-bold shadow-none">More Facilities >>></a>
            </div>
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
            <a href="" class="btn btn-sm btn-outline-dark rounded fw-bold shadow-none">Know More >>></a>
        </div>
    </div>

    <!-- Reach Us -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold new-font">Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 bg-white rounded">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15249885.318783779!2d82.75252935!3d21.0680074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1710790360654!5m2!1sen!2sin" height="380" loading="lazy" class="w-100 rounded"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call Us</h5>
                    <a href="tel: +91123456789" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91123456789
                    </a><br>
                    <a href="tel: +91987654321" class="d-inline-block text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91987654321
                    </a>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow Us</h5>
                    <a href="" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-twitter me-1"></i> Twitter</span>
                    </a><br>
                    <a href="" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-facebook"></i> Facebook</span>
                    </a><br>
                    <a href="" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-instagram"></i> Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("include/footer.php"); ?>
</body>
</html>