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
    <script src="./js/new_booking.js" defer></script>
    <title>New Bookings - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">New Bookings</h3>

                <!-- Rooms Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="search" class="form-control shadow-none w-25 ms-auto" placeholder="Search new bookings" oninput="getBookings(this.value)">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover border">
                                <thead>
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">User details</th>
                                        <th scope="col">Room details</th>
                                        <th scope="col">Booking details</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Room Number Modal -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="assign-room-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Room</h5>
                    </div>
                    <div class="modal-body">
                        <span class="badge rounded-pill text-dark bg-light mb-3 text-wrap lh-base">
                            Note: Assign Room Number only when user has been arrived.
                        </span>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Room Number</label>
                            <input type="text" name="room_no" class="form-control shadow-none" required>
                        </div>
                        <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-background text-white shadow-none">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>