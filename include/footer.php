<div class="container-fluid mt-5 bg-white">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="new-font fs-3 fw-bold mb-3"><?php echo $settings_r["site_title"]; ?></h3>
            <p><?php echo $settings_r["site_about"]; ?></p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a><br>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Follow Us</h5>
            <a href="<?php echo $contact_r['instagram']; ?>" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-instagram"></i> Instagram
            </a><br>
            <a href="<?php echo $contact_r['facebook']; ?>" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-facebook"></i> Facebook
            </a><br>
            <?php 
                if ($contact_r["twitter"] != "") {
                    echo<<<data
                        <a href="$contact_r[twitter]" class="d-inline-block text-dark text-decoration-none mb-2">
                            <i class="bi bi-twitter me-1"></i> Twitter
                        </a>
                    data;
                }
            ?>
        </div>
    </div>
</div>
<h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by Godlike-Creation.</h6>