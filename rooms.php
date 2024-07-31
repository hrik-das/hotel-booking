<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("include/include.php"); ?>
    <title>Rooms - Godlike Restaurant</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("include/header.php"); ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Rooms</h2>
        <div class="horizontal-line bg-dark"></div>
    </div>

    <!-- Filters -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-4 ps-4 mb-lg-0 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="navbar-brand mt-2" href="#">Filter Rooms</h4>
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

            <!-- Room Cards -->
            <div class="col-lg-9 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-4">
                            <img src="./images/rooms/1.png" class="img-fluid rounded" alt="Room One">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-3">Simple Room</h5>
                            <div class="features mb-3">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                            </div>
                            <div class="facilities mb-3">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                            </div>
                            <div class="guests mb-3">
                                <h6 class="">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">3 Adults</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">2 Children</span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                            <h6 class="mb-4">₹499 Per Night</h6>
                            <button class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                <i class="bi bi-bookmark-fill"></i> Book Now
                            </button>
                            <a href="" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                <i class="bi bi-info-circle-fill"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-4">
                            <img src="./images/rooms/1.png" class="img-fluid rounded" alt="Room One">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-3">Simple Room</h5>
                            <div class="features mb-3">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                            </div>
                            <div class="facilities mb-3">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                            </div>
                            <div class="guests mb-3">
                                <h6 class="">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">3 Adults</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">2 Children</span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                            <h6 class="mb-4">₹499 Per Night</h6>
                            <button class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                <i class="bi bi-bookmark-fill"></i> Book Now
                            </button>
                            <a href="" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                <i class="bi bi-info-circle-fill"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-4">
                            <img src="./images/rooms/1.png" class="img-fluid rounded" alt="Room One">
                        </div>
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-3">Simple Room</h5>
                            <div class="features mb-3">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">2 Rooms</span>
                            </div>
                            <div class="facilities mb-3">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1 lh-base">Unlimited Wifi</span>
                            </div>
                            <div class="guests mb-3">
                                <h6 class="">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">3 Adults</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">2 Children</span>
                            </div>
                        </div>
                        <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                            <h6 class="mb-4">₹499 Per Night</h6>
                            <button class="btn btn-sm w-100 text-white custom-background shadow-none mb-2">
                                <i class="bi bi-bookmark-fill"></i> Book Now
                            </button>
                            <a href="" class="btn btn-sm w-100 btn-outline-dark shadow-none">
                                <i class="bi bi-info-circle-fill"></i> More Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("include/footer.php"); ?>
</body>
</html>