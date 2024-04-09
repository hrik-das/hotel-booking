<?php
    require("./include/connect.php");
    require("./include/essential.php");
    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <script src="./js/script.js" defer></script>
    <script src="./js/booking_records.js" defer></script>
    <title>Admin Panel - Booking Records</title>
</head>
<body class="bg-white">
    <?php require("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Booking Records</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" id="search-input" oninput="getBookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search User">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data"></tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="table-pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>