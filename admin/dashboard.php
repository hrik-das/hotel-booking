<?php
    require_once("./include/connect.php");
    require_once("./include/essential.php");
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <link rel="stylesheet" href="./css/dashboard.css">
    <script src="./js/dashboard.js" defer></script>
    <title>Dashboard - Admin Panel</title>
</head>
<body class="bg-light">
    <?php
        require_once("./include/header.php");
        
        $shutdown_query = "SELECT `shutdown` FROM `settings`";
        $shutdown_result = mysqli_fetch_assoc(mysqli_query($connect, $shutdown_query));

        $current_bookings = "SELECT COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS `new_bookings`, COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END) AS `refund_bookings` FROM `booking_order`";
        $bookings_result = mysqli_fetch_assoc(mysqli_query($connect, $current_bookings));

        $user_query = "SELECT COUNT(sr_no) AS `count` FROM `user_queries` WHERE `seen`=0";
        $user_result = mysqli_fetch_assoc(mysqli_query($connect, $user_query));

        $review_query = "SELECT COUNT(sr_no) AS `count` FROM `rating_review` WHERE `seen`=0";
        $review_result = mysqli_fetch_assoc(mysqli_query($connect, $review_query));

        $current_users = "SELECT COUNT(`id`) AS `total`, COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`, COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`, COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified` FROM `user_cred`";
        $users_data = mysqli_fetch_assoc(mysqli_query($connect, $current_users));
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>Dashboard</h3>
                    <?php
                        if ($shutdown_result["shutdown"]) {
                            echo<<<data
                                <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown mode is currently active!</h6>
                            data;
                        }
                    ?>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="new_booking.php" class="text-decoration-none">
                            <div class="card text-center p-3 custom-success text-success">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0">
                                    <?php echo $bookings_result["new_bookings"]; ?>
                                </h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="refund_booking.php" class="text-decoration-none">
                            <div class="card text-center p-3 custom-orange text-orange">
                                <h6>Refund Bookings</h6>
                                <h1 class="mt-2 mb-0">
                                    <?php echo $bookings_result["refund_bookings"]; ?>
                                </h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center p-3 custom-primary text-primary">
                                <h6>User Queries</h6>
                                <h1 class="mt-2 mb-0">
                                    <?php echo $user_result["count"]; ?>
                                </h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center p-3 custom-purple text-purple">
                                <h6>Reviews</h6>
                                <h1 class="mt-2 mb-0">
                                    <?php echo $review_result["count"]; ?>
                                </h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>Booking Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="bookingAnalytics(this.value)">
                        <option value="1">Past 30 days</option>
                        <option value="2">Past 90 days</option>
                        <option value="3">Past 1 year</option>
                        <option value="4">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 mb-4">
                        <div class="card text-center p-3 custom-primary text-primary">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0" id="total-bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total-amount">₹</h1>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-center p-3 custom-success text-success">
                            <h6>Active Bookings</h6>
                            <h1 class="mt-2 mb-0" id="active-bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active-amount">₹0</h1>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-center p-3 custom-danger text-danger">
                            <h6>Cancelled Bookings</h6>
                            <h1 class="mt-2 mb-0" id="cancelled-bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled-amount">₹0</h1>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>User Queries & Reviews Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="userAnalytics(this.value)">
                        <option value="1">Past 30 days</option>
                        <option value="2">Past 90 days</option>
                        <option value="3">Past 1 year</option>
                        <option value="4">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 mb-4">
                        <div class="card text-center p-3 custom-purple text-purple">
                            <h6>New Registrations</h6>
                            <h1 class="mt-2 mb-0" id="total-registration">0</h1>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-center p-3 custom-primary text-primary">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0" id="queries">0</h1>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-center p-3 custom-orange text-orange">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="reviews">0</h1>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3">Users</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center p-3 custom-success text-success">
                            <h6>Total Users</h6>
                            <h1 class="mt-2 mb-0">
                                <?php echo $users_data["total"]; ?>
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center p-3 custom-primary text-primary">
                            <h6>Active Users</h6>
                            <h1 class="mt-2 mb-0">
                                <?php echo $users_data["active"]; ?>
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center p-3 custom-orange text-orange">
                            <h6>Inactive Users</h6>
                            <h1 class="mt-2 mb-0">
                                <?php echo $users_data["inactive"]; ?>
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center p-3 custom-danger text-danger">
                            <h6>Unverified Users</h6>
                            <h1 class="mt-2 mb-0">
                                <?php echo $users_data["unverified"]; ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>