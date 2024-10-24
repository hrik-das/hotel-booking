<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Our Rooms - Godlike Restaurant</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Rooms</h2>
        <div class="horizontal-line bg-dark"></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-0">
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
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="./assets/rooms/1.jpg" class="img-fluid rounded" alt="Room One">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-2">Simple Room Name</h5>
                            <div class="features mb-2">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">2 Rooms</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">1 Bathroom</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">1 Balcony</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">3 Sofa</span>
                            </div>
                            <div class="facilities mb-2">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Unlimited Wifi</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Gyser</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Room Heater</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Air Conditioner</span>
                            </div>
                            <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill text-dark bg-light text-wrap">4 Children</span>
                            <span class="badge rounded-pill text-dark bg-light text-wrap">5 Adults</span>
                        </div>
                        </div>
                        <div class="col-md-2 text-center mt-lg-0 mt-md-0 mt-4">
                            <h6 class="mb-4">₹200 per night</h6>
                            <a href="#" class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                <i class="bi bi-bookmark-fill"></i> Book Now
                            </a>
                            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                <i class="bi bi-exclamation-circle-fill"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="./assets/rooms/1.jpg" class="img-fluid rounded" alt="Room One">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-2">Simple Room Name</h5>
                            <div class="features mb-2">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">2 Rooms</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">1 Bathroom</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">1 Balcony</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">3 Sofa</span>
                            </div>
                            <div class="facilities mb-2">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Unlimited Wifi</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Gyser</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Room Heater</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Air Conditioner</span>
                            </div>
                            <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill text-dark bg-light text-wrap">4 Children</span>
                            <span class="badge rounded-pill text-dark bg-light text-wrap">5 Adults</span>
                        </div>
                        </div>
                        <div class="col-md-2 text-center mt-lg-0 mt-md-0 mt-4">
                            <h6 class="mb-4">₹200 per night</h6>
                            <a href="#" class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                <i class="bi bi-bookmark-fill"></i> Book Now
                            </a>
                            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                <i class="bi bi-exclamation-circle-fill"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="./assets/rooms/1.jpg" class="img-fluid rounded" alt="Room One">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-2">Simple Room Name</h5>
                            <div class="features mb-2">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">2 Rooms</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">1 Bathroom</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">1 Balcony</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">3 Sofa</span>
                            </div>
                            <div class="facilities mb-2">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Unlimited Wifi</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Gyser</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Room Heater</span>
                                <span class="badge rounded-pill text-dark bg-light text-wrap">Air Conditioner</span>
                            </div>
                            <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill text-dark bg-light text-wrap">4 Children</span>
                            <span class="badge rounded-pill text-dark bg-light text-wrap">5 Adults</span>
                        </div>
                        </div>
                        <div class="col-md-2 text-center mt-lg-0 mt-md-0 mt-4">
                            <h6 class="mb-4">₹200 per night</h6>
                            <a href="#" class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                <i class="bi bi-bookmark-fill"></i> Book Now
                            </a>
                            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                <i class="bi bi-exclamation-circle-fill"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>