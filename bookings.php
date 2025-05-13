<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/bookings.js" defer></script>
    <title>Bookings - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php 
        require_once("./include/header.php");
        
        if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
            redirect("index.php");
        }
    ?>

    <!-- Body -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Bookings</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">/</span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Bookings</a>
                </div>
            </div>

            <?php
                $query = "SELECT book_order.*, book_detail.* FROM `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id WHERE ((book_order.booking_status='booked') OR (book_order.booking_status='cancelled') OR (book_order.booking_status='failed')) AND (book_order.user_id=?) ORDER BY book_order.booking_id DESC";
                $values = [$_SESSION["userid"]];
                $result = select($query, $values, "i");

                while ($data = mysqli_fetch_assoc($result)) {
                    $date = date("d-m-Y", strtotime($data["date_time"]));
                    $checkin = date("d-m-Y", strtotime($data["check_in"]));
                    $checkout = date("d-m-Y", strtotime($data["check_out"]));

                    $status_background = $button = "";

                    if ($data["booking_status"] == "booked") {
                        $status_background = "bg-success";
                        
                        if ($data["arrival"] == 1) {
                            $button = "
                                <a href='generate_pdf.php?generate-pdf&id=$data[booking_id]' class='btn btn-sm btn-dark shadow-none'>
                                    <i class='bi bi-file-pdf-fill'></i> Download PDF
                                </a>

                                <button type='button' class='btn btn-sm btn-outline-dark shadow-none'>
                                    <i class='bi bi-star-fill'></i> Rate & Review
                                </button>
                            ";
                        } else {
                            $button = "
                                <button type='button' onclick='cancelBooking($data[booking_id])' class='btn btn-sm btn-danger shadow-none'>
                                    <i class='bi bi-trash-fill'></i> Cancel
                                </button>
                            ";
                        }
                    } else if ($data["booking_status"] == "cancelled") {
                        $status_background = "bg-danger";

                        if ($data["refund"] == 0) {
                            $button = "
                                <span class='badge bg-primary'>Refund in process</span>
                            ";
                        } else {
                            $button = "
                                <a href='generate_pdf.php?generate-pdf&id=$data[booking_id]' class='btn btn-sm btn-dark shadow-none'>
                                    <i class='bi bi-file-pdf-fill'></i> Download PDF
                                </a>
                            ";
                        }
                    } else {
                        $status_background = "bg-warning";
                        $button = "
                            <a href='generate_pdf.php?generate-pdf&id=$data[booking_id]' class='btn btn-sm btn-dark shadow-none'>
                                <i class='bi bi-file-pdf-fill'></i> Download PDF
                            </a>
                        ";
                    }

                    echo<<<data
                        <div class="col-md-4 px-4 mb-4">
                            <div class="bg-white p-3 rounded shadow-sm">
                                <h5 class="fw-bold">$data[room_name]</h5>
                                <b>Order ID: </b>$data[order_id]<br/>
                                <p>Price: ₹$data[price]</p>
                                <p>
                                    <b>Check-In: </b>$checkin<br/>
                                    <b>Check-Out: </b>$checkout
                                </p>
                                <p>
                                    <b>Price: </b>$data[price]<br/>
                                    <b>Date: </b>$date
                                </p>
                                <p>
                                    <span class="badge $status_background">$data[booking_status]</span>
                                </p>
                                $button
                            </div>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>

    <?php
        if (isset($_GET["cancel-status"])) {
            alert("success", "Booking cancelled.");
        }
    ?>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>