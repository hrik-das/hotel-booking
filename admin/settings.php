<?php
    require_once("./include/essential.php");
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/settings.js" defer></script>
    <title>Settings - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Settings</h3>

                <!-- General Settings Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#general-settings">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site-title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                        <p class="card-text" id="site-about"></p>
                    </div>
                </div>

                <!-- General Settings Modal -->
                <div class="modal fade" id="general-settings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="general-settings-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Settings</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Site Title</label>
                                        <input type="text" id="site-title-input" name="site_title" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">About Us</label>
                                        <textarea id="site-about-input" name="site_about" class="form-control shadow-none" rows="3" style="resize: none;" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about">Cancel</button>
                                    <button type="submit" class="btn custom-background text-white shadow-none">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Shutdown Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Services Shutdown</h5>
                            <div class="form-check form-switch">
                                <form action="">
                                    <input type="checkbox" name="" id="shutdown-toggle" class="form-check-input shadow-none" onchange="toggleShutdown(this.value)">
                                </form>
                            </div>
                        </div>
                        <p class="card-text">No customers will be allowed to book hotel rooms when shutdown is turned on.</p>
                    </div>
                </div>

                <!-- Contact Details Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contact Details</h5>
                            <button type="button" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#contact-details">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Maps</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone Numbers</h6>
                                    <p class="card-text mb-1">
                                        <span id="phone-one"></span>
                                    </p>
                                    <p class="card-text">
                                        <span id="phone-two"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Email Address</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-2 fw-bold">Social Media</h6>
                                    <p class="card-text">
                                        <i class="bi bi-facebook"></i>
                                        <span id="facebook"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-instagram"></i>
                                        <span id="instagram"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-twitter"></i>
                                        <span id="twitter"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                                    <iframe src="" frameborder="0" loading="lazy" id="iframe" class="border p-2 w-100"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Details Modal -->
                <div class="modal fade" id="contact-details" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="" id="contact-details-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Details</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Address</label>
                                                    <input type="text" id="address-input" name="address" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Google Map</label>
                                                    <input type="text" id="gmap-input" name="gmap" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Phone Numbers (with country code)</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-telephone-fill"></i>
                                                        </span>
                                                        <input type="number" id="phone-one-input" name="phone_one" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-telephone-fill"></i>
                                                        </span>
                                                        <input type="number" id="phone-two-input" name="phone_two" class="form-control shadow-none">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Email Address</label>
                                                    <input type="text" id="email-input" name="email" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Social Media</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-facebook"></i>
                                                        </span>
                                                        <input type="text" id="facebook-input" name="facebook" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-instagram"></i>
                                                        </span>
                                                        <input type="text" id="instagram-input" name="instagram" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-twitter"></i>
                                                        </span>
                                                        <input type="text" id="twitter-input" name="twitter" class="form-control shadow-none">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">iFrame Source</label>
                                                    <input type="text" id="iframe-input" name="iframe" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="contactsInput(contact_data)">Cancel</button>
                                    <button type="submit" class="btn custom-background text-white shadow-none">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Management Team Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team</h5>
                            <button type="button" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#management-team">
                                <i class="bi bi-cloud-plus-fill"></i> Upload
                            </button>
                        </div>

                        <div class="row" id="team-data"></div>
                    </div>
                </div>

                <!-- Management Team Modal -->
                <div class="modal fade" id="management-team" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="management-team-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Team Member</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="text" id="member-name-input" name="member_name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">                                
                                        <label class="form-label fw-bold">Image</label>
                                        <input type="file" id="member-image-input" name="member_image" class="form-control shadow-none" accept=".jpg, .jpeg, .png, .webp" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="member_name.value = '', member_image.value=''">Cancel</button>
                                    <button type="submit" class="btn custom-background text-white shadow-none">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>