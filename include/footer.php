<div class="container-fluid mt-5 bg-white">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="new-font fw-bold fs-3 mb-3">Godlike Restaurant</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure, quia. Illum nesciunt tempora provident cupiditate porro repellendus asperiores hic odio tempore recusandae explicabo, vel nobis odit reprehenderit quibusdam, debitis id!</p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Support</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact Us</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Scoial</h5>
            <a href="<?php echo $contact_result['facebook']; ?>" class="d-inline-block mb-2 text-dark text-decoration-none">
                <i class="bi bi-facebook me-1"></i> Facebook
            </a><br>
            <a href="<?php echo $contact_result['instagram']; ?>" class="d-inline-block mb-2 text-dark text-decoration-none">
                <i class="bi bi-instagram me-1"></i> Instagram
            </a><br>
            
            <?php
                if ($contact_result["twitter"] != "") {
                    echo<<<data
                        <a href="$contact_result[twitter]" target="_blank" class="d-inline-block text-dark text-decoration-none">
                            <span class="badge bg-light text-dark fs-6 p-2">
                                <i class="bi bi-twitter"></i> Twitter
                            </span>
                        </a>
                    data;
                }
            ?>
        </div>
    </div>
</div>
<h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by Godlike-Creation.</h6>