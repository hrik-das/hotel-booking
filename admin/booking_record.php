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
    <script src="./js/booking_record.js" defer></script>
    <title>Booking Records - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Booking Records</h3>

                <!-- Rooms Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="search" id="search" class="form-control shadow-none w-25 ms-auto" placeholder="Search new bookings" oninput="getBookings(this.value)">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">User details</th>
                                        <th scope="col">Room details</th>
                                        <th scope="col">Booking details</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data"></tbody>
                            </table>
                        </div>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination mt-3" id="table-pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>