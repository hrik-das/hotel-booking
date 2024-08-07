<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Contact - <?php echo $settings_r["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Contact Us</h2>
        <div class="horizontal-line bg-dark"></div>
        <p class="text-center mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nihil <br> mollitia placeat aliquid ut voluptatem, animi iste esse ab nostrum.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe src="<?php echo $contact_r['iframe']; ?>" height="380" loading="lazy" class="w-100 rounded"></iframe>
                    <h5>Address</h5>
                    <a href="<?php echo $contact_r['google_map']; ?>" target="_blank" class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-geo-alt-fill"></i> XYZ, Assam, India
                    </a>
                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel: +91-<?php echo $contact_r['phone1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91-<?php echo $contact_r['phone1']; ?>
                    </a><br>
                    <?php
                        if ($contact_r["phone2"] != "") {
                            echo<<<data
                                <a href="tel: +$contact_r[phone2]" class="d-inline-block text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i> +91-$contact_r[phone2]
                                </a>
                            data;
                        }
                    ?>
                    <h5 class="mt-4">Email Address</h5>
                    <a href="mailto: <?php echo $contact_r['email']; ?>" class="d-inline-block text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']; ?></a>
                    <h5 class="mt-4">Follow Us</h5>
                    <?php
                        if ($contact_r["twitter"] != "") {
                            echo<<<data
                                <a href="$contact_r[twitter]" class="d-inline-block fs-5 text-dark me-1">
                                    <i class="bi bi-twitter me-1"></i>
                                </a>
                            data;
                        }
                    ?>
                    <a href="<?php echo $contact_r['facebook']; ?>" class="d-inline-block fs-5 text-dark me-2">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="<?php echo $contact_r['instagram']; ?>" class="d-inline-block fs-5 text-dark">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form action="" method="post">
                        <h5>Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Your Name</label>
                            <input type="text" name="name" class="form-control shadow-none" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control shadow-none" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Subject</label>
                            <input type="text" name="subject" class="form-control shadow-none" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Message</label>
                            <textarea rows="5" name="message" class="form-control shadow-none" style="resize: none;" required></textarea>
                        </div>
                        <button type="submit" name="send" class="btn custom-background text-white mt-3 shadow-none">
                            <i class="bi bi-send-fill"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST["send"])) {
            $filterData = filteration($_POST);
            $query = "INSERT INTO `user_queries` (`name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)";
            $values = [$filterData["name"], $filterData["email"], $filterData["subject"], $filterData["message"]];
            $result = executeCrud("insert", $query, $values, "ssss");
            if ($result) {
                alert("success", "Email Sent Successfully.");
            } else {
                alert("error", "Cannot Send Email!");
            }
        }
    ?>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>