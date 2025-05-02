<?php
    require_once("admin/include/connect.php");
    require_once("admin/include/essential.php");

    $contact_query = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $contact_values = [1];
    $contact_result = mysqli_fetch_assoc(select($contact_query, $contact_values, "i"));
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand new-font me-5 fw-bold fs-3" href="index.php">Godlike Restaurant</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-2" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="rooms.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <div class="d-flex">
                <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            </div>
        </div>
    </div>
</nav>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel">
                        <i class="bi bi-person-vcard-fill fs-3 me-2"></i> User Registration
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill text-dark bg-light mb-3 text-wrap lh-base">
                        Note: Your details must match with your ID (Adhaar Card, PAN Card, Driving License, Passport etc). That will be required during check-in.
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person-fill"></i> Username
                                </label>
                                <input type="text" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-envelope-at-fill"></i> Email address
                                </label>
                                <input type="email" class="form-control shadow-none">        
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-telephone-inbound-fill"></i> Contact Details
                                </label>
                                <input type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person-bounding-box"></i> Profile Picture
                                </label>
                                <input type="file" class="form-control shadow-none">        
                            </div>
                            <div class="col-md-12 p-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-house-add-fill"></i> Permanent Address
                                </label>
                                <textarea class="form-control shadow-none" rows="1"></textarea>        
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-geo-alt-fill"></i> Pincode
                                </label>
                                <input type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-calendar-date"></i> Date of Birth
                                </label>
                                <input type="date" class="form-control shadow-none">        
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-shield-lock-fill"></i> Password
                                </label>
                                <input type="password" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-check-square-fill"></i> Confirm Password
                                </label>
                                <input type="password" class="form-control shadow-none">        
                            </div>
                        </div>
                        <div class="text-center my-1">
                            <button type="submit" class="btn btn-dark shadow-none">
                                <i class="bi bi-person-fill-add"></i> REGISTER
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="staticBackdropLabel">
                        <i class="bi bi-person-fill fs-3 me-2"></i> User Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">
                            <i class="bi bi-envelope-at-fill"></i> Email address
                        </label>
                        <input type="email" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">
                            <i class="bi bi-shield-lock-fill"></i> Password
                        </label>
                        <input type="password" class="form-control shadow-none" id="exampleInputPassword1">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" class="btn btn-dark shadow-none">
                            <i class="bi bi-box-arrow-in-right"></i> LOGIN
                        </button>
                        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>