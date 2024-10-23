<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Contact - Godlike Restaurant</title>
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15283674.799797209!2d72.09858950579333!3d20.73595779415586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1729630910616!5m2!1sen!2sin" height="320px" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-100 rounded mb-4"></iframe>
                    <h5>Address</h5>
                    <a href="https://maps.app.goo.gl/C291p9opm3xkUpBC7" target="_blank" class="d-inline-block mb-2 text-dark text-decoration-none">
                        <i class="bi bi-geo-alt-fill"></i> XYZ, Assam, India
                    </a>

                    <h5 class="mt-4">Contact Us</h5>
                    <a href="tel: +911234567890" class="d-inline-block mb-2 text-dark text-decoration-none">
                        <i class="bi bi-telephone-fill"></i> +911234567890
                    </a><br>
                    <a href="tel: +911234567890" class="d-inline-block text-dark text-decoration-none">
                        <i class="bi bi-telephone-fill"></i> +911234567890
                    </a>
                    
                    <h5 class="mt-4">Email Adrress</h5>
                    <a href="mailto: emptynull01@gmail.com" class="d-inline-block text-dark text-decoration-none">
                        <i class="bi bi-envelope-at-fill"></i> emptynull01@gmail.com
                    </a>
                    
                    <h5 class="mt-4">Social Media</h5>
                    <a href="#" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-facebook me-1"></i>
                    </a>
                    <a href="#" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-instagram me-1"></i>
                    </a>
                    <a href="#" class="d-inline-block text-dark fs-5">
                        <i class="bi bi-twitter"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form action="">
                        <h5><i class="bi bi-envelope"></i> Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-person-fill"></i> Full Name
                            </label>
                            <input type="text" name="" id="" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-envelope-at-fill"></i> Email Address
                            </label>
                            <input type="email" name="" id="" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-journal-text"></i> Subject
                            </label>
                            <input type="text" name="" id="" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">
                                <i class="bi bi-chat-fill"></i> Message
                            </label>
                            <textarea class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                        <button type="submit" class="btn text-white custom-background mt-3">
                            <i class="bi bi-send-fill"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>