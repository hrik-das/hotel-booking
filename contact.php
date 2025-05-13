<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Contact - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Contact Us</h2>
        <div class="horizontal-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod odit eius <br> praesentium error dolorem tempora eveniet magni exercitationem veniam neque!</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe src="<?php echo $contact_result['iframe']; ?>" height="320px" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-100 rounded mb-4"></iframe>
                    <h5>Address</h5>
                    <a href="<?php echo $contact_result['gmap']; ?>" target="_blank" class="d-inline-block mb-2 text-dark text-decoration-none">
                        <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_result["address"]; ?>
                    </a>

                    <h5 class="mt-4">Contact Us</h5>
                    <a href="tel: +<?php echo $contact_result['phone_one']; ?>" class="d-inline-block mb-2 text-dark text-decoration-none">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_result["phone_one"]; ?>
                    </a><br>
                    
                    <?php
                        if ($contact_result["phone_two"] != "") {
                            echo<<<data
                                <a href="tel: +$contact_result[phone_two]" class="d-inline-block mb-2 text-dark text-decoration-none">
                                    <i class="bi bi-telephone-fill"></i> +$contact_result[phone_two]
                                </a>
                            data;
                        }
                    ?>
                    
                    <h5 class="mt-4">Email Adrress</h5>
                    <a href="mailto: <?php echo $contact_result['email']; ?>" class="d-inline-block text-dark text-decoration-none">
                        <i class="bi bi-envelope-at-fill"></i> <?php echo $contact_result["email"]; ?>
                    </a>
                    
                    <h5 class="mt-4">Social Media</h5>
                    <a href="<?php echo $contact_result['facebook']; ?>" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-facebook me-1"></i>
                    </a>
                    <a href="<?php echo $contact_result['instagram']; ?>" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-instagram me-1"></i>
                    </a>
                    
                    <?php
                        if ($contact_result["twitter"] != "") {
                            echo<<<data
                                <a href="$contact_result[twitter]" class="d-inline-block text-dark fs-5">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            data;
                        }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form action="" method="post">
                        <h5><i class="bi bi-envelope"></i> Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-person-fill"></i> Full Name
                            </label>
                            <input type="text" name="name" id="" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-envelope-at-fill"></i> Email Address
                            </label>
                            <input type="email" name="email" id="" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-journal-text"></i> Subject
                            </label>
                            <input type="text" name="subject" id="" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-chat-fill"></i> Message
                            </label>
                            <textarea name="message" class="form-control shadow-none" rows="5" style="resize: none;" required></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn text-white custom-background shadow-none mt-3">
                            <i class="bi bi-send-fill"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST["submit"])) {
            if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
                alert("error", "Please login to send feedback!");
                exit;
            }

            $filter_data = filteration($_POST);

            $query = "INSERT INTO `user_queries` (`name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)";
            $values = [$filter_data["name"], $filter_data["email"], $filter_data["subject"], $filter_data["message"]];
            $result = insert($query, $values, "ssss");

            if ($result == 1) {
                alert("success", "Query recieved, thank you for the feedback.");
            } else {
                alert("error", "Please try again later!");
            }
        }
    ?>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>