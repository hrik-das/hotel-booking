<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/facilities.css">
    <?php require("include/links.php"); ?>
    <title><?php echo $settings_r["site_title"]; ?> - Facilities</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("include/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Facilities</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nihil <br> mollitia placeat aliquid ut voluptatem, animi iste esse ab nostrum.</p>
    </div>

    <div class="container">
        <div class="row">
            <?php
                $result = selectAll("facilities");
                $path = FACILITIES_IMG_PATH;
                while($data = mysqli_fetch_assoc($result)){
                    echo<<<data
                    <div class="col-lg-4 col-md-6 mb-5 px-4">
                        <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                            <div class="d-flex align-items-center mb-2">
                                <img src="$path$data[icon]" alt="" width="40px">
                                <h5 class="m-0 ms-3">$data[name]</h5>
                            </div>
                            <p>$data[description]</p>
                        </div>
                    </div>
                    data;
                }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php require("include/footer.php"); ?>
</body>
</html>