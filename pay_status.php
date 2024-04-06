<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <title><?php echo $settings_r["site_title"]; ?> - Booking Status</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require("./include/header.php"); ?>
    <!-- Filters -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-3 px-4">
                <h2>Payment Status</h2>
            </div>
            <?php
                $filterDara = filteration($_GET);
                if(!(isset($_SESSION["login"]) && $_SESSION["login"] == true)){
                    redirect("index.php");
                }
                $bookingQuery = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status!=?";
                $bookingResult = select($bookingQuery, [$filterDara["order"], $_SESSION["userid"], "pending"], "sis");
                if(mysqli_num_rows($bookingResult) == 0){
                    redirect("index.php");
                }
                $bookingFetch = mysqli_fetch_assoc($bookingResult);
                if($bookingFetch["transaction_status"] == "TXN_SUCCESS"){
                    echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-success">
                                <i class="bi bi-check-circle-fill"></i>
                                Payment Done! Booking Successful.
                                <br><br>
                                <a href="bookings.php">Go to your Bookings.</a>
                            </p>
                        </div>
                    data;
                }else{
                    echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Payment Failed! $bookingFetch[response_message]
                                <br><br>
                                <a href="bookings.php">Go to your Bookings.</a>
                            </p>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php require("./include/footer.php"); ?>
</body>
</html>