<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <link rel="stylesheet" href="./css/facilities.css">
    <title>Facilities - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Facilities</h2>
        <div class="horizontal-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod odit eius <br> praesentium error dolorem tempora eveniet magni exercitationem veniam neque!</p>
    </div>

    <div class="container">
        <div class="row">
            <?php
                $result = selectAllData("facilities");
                $path = FACILITY_IMAGE_PATH;

                while ($data = mysqli_fetch_assoc($result)) {
                    echo<<<data
                        <div class="col-lg-4 col-md-6 mb-5 px-4">
                            <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                                <div class="d-flex mb-2 align-items-center">
                                    <img src="$path$data[icon]" width="40px">
                                    <h5 class="m-0 ms-3">$data[name]</h5>
                                </div>
                                <p>$data[description]</p>
                            </div>
                        </div>
                    data;
                }
            ?>
        </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>