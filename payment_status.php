<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Payment Status - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>

    <!-- Body -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4 mb-3">
                <h2 class="fw-bold">Payment Status</h2>
            </div>

            <?php
                $filter_data = filteration($_GET);

                if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
                    redirect("index.php");
                }

                $booking_query = "SELECT book_order.*, book_detail.* FROM `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id WHERE book_order.order_id=? AND book_order.user_id=? AND book_order.booking_status!=?";
                $booking_values = [$filter_data["order"], $_SESSION["userid"], "pending"];
                $booking_result = select($booking_query, $booking_values, "sis");

                if (mysqli_num_rows($booking_result) == 0) {
                    redirect("index.php");
                }

                $booking_data = mysqli_fetch_assoc($booking_result);

                if ($booking_data["transaction_status"] == "TXN_SUCCESS") {
                    echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-success">
                                <i class="bi bi-check-circle-fill"></i>
                                Payment successful, Room Booked.
                                <br/><br/>
                                <a href="bookings.php">View Bookings</a>
                            </p>
                        </div>
                    data;
                } else {
                    echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                payment failed! $booking_data[transaction_response]
                                <br/><br/>
                                <a href="bookings.php">View Bookings</a>
                            </p>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>