<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <script src="./js/bookings.js" defer></script>
    <title><?php echo $settings_r["site_title"]; ?> - Bookings</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php 
        require("./include/header.php");
        if(!(isset($_SESSION["login"]) || $_SESSION["login"] == true)){
            redirect("index.php");
        }
    ?>

    <!-- Filters -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Bookings</h2>
                <div id="room-style">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="" class="text-secondary text-decoration-none">Bookings</a>
                </div>
            </div>

            <?php
                $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id WHERE ((bo.booking_status='booked') OR (bo.booking_status='cancelled') OR (bo.booking_status='payment failed')) AND (bo.user_id=?) ORDER BY bo.booking_id DESC";
                $result = select($query, [$_SESSION["userid"]], "i");
                while($data = mysqli_fetch_assoc($result)){
                    $date = date("d-m-Y", strtotime($data["dateTime"]));
                    $checkin = date("d-m-Y", strtotime($data["checkin"]));
                    $checkout = date("d-m-Y", strtotime($data["checkout"]));
                    $statusBG = "";
                    $button = "";
                    if($data["booking_status"] == "booked"){
                        $statusBG = "bg-success";
                        if($data["arrival"] == 1){
                            $button = "<a href='generatePDF.php?generatepdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'><i class='bi bi-filetype-pdf'></i>Download PDF</a>
                            <button type='button' class='btn btn-sm btn-outline-dark shadow-none'>Rate & Review</button>";
                        }else{
                            $button = "<button type='button' onclick='cancelBooking($data[booking_id])' class='btn btn-sm btn-outline-danger shadow-none'>Cancel</button>";
                        }
                    }else if($data["booking_status"] == "cancelled"){
                        $statusBG = "bg-danger";
                        if($data["refund"] == 0){
                            $button = "<span class='badge bg-primary'>Refund in Process</span>";
                        }else{
                            $button = "<a href='generatePDF.php?generatepdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'><i class='bi bi-filetype-pdf'></i>Download PDF</a>";
                        }
                    }else{
                        $statusBG = "bg-warning";
                        $button = "<a href='generatePDF.php?generatepdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'><i class='bi bi-filetype-pdf'></i>Download PDF</a>";
                    }
                    echo<<<data
                        <div class="col-md-4 px-4 mb-4">
                            <div class="bg-white shadow-sm p-3 rounded">
                                <h5 class="fw-bold">$data[room_name]</h5>
                                <p>₹$data[price] Per Night</p>
                                <p>
                                    <b>Check In: </b> $checkin <br/>
                                    <b>Check Out: </b> $checkout
                                </p>
                                <p>
                                    <b>Order ID: </b> $data[order_id] <br/>
                                    <b>Amount: </b> $data[transaction_amount] <br/>
                                    <b>Date: </b> $date
                                </p>
                                <p>
                                    <span class="badge $statusBG">$data[booking_status]</span>
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
        if(isset($_GET["cancelStatus"])){
            alert("success", "Booking Cancelled!");
        }
    ?>

    <!-- Footer -->
    <?php require("./include/footer.php"); ?>
</body>
</html>