<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("include/links.php"); ?>
    <title>Godlike Restaurant - Contact</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("include/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Contact Us</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nihil <br> mollitia placeat aliquid ut voluptatem, animi iste esse ab nostrum.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15249885.318783779!2d82.75252935!3d21.0680074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1710790360654!5m2!1sen!2sin" height="380" loading="lazy" class="w-100 rounded"></iframe>
                    <h5>Address</h5>
                    <a href="https://maps.app.goo.gl/o3wkTANpFaJsVdFJ9" target="_blank" class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-geo-alt-fill"></i> XYZ, Hawrah, Kolkata
                    </a>
                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel: +91123456789" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91123456789
                    </a><br>
                    <a href="tel: +91987654321" class="d-inline-block text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91987654321
                    </a>
                    <h5 class="mt-4">Email Address</h5>
                    <a href="mailto: hrikdas012@gmail.com" class="d-inline-block text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i> hrikdas012@gmail.com</a>
                    <h5 class="mt-4">Follow Us</h5>
                    <a href="" class="d-inline-block fs-5 text-dark me-2">
                        <i class="bi bi-twitter me-1"></i>
                    </a>
                    <a href="" class="d-inline-block fs-5 text-dark me-2">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="" class="d-inline-block fs-5 text-dark">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form action="">
                        <h5>Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Your Name</label>
                            <input type="text" class="form-control shadow-none" aria-describedby="emailHelp">
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control shadow-none" aria-describedby="emailHelp">
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Subject</label>
                            <input type="text" class="form-control shadow-none" aria-describedby="emailHelp">
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Message</label>
                            <textarea rows="5" class="form-control shadow-none" style="resize: none;"></textarea>
                        </div>
                        <button type="submit" class="btn custom-bg text-white mt-3 shadow-none">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("include/footer.php"); ?>
</body>
</html>