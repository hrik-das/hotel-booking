<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/rooms.js" defer></script>
    <title>Our Rooms - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php 
        require_once("./include/header.php");
    
        $checkin_default = $checkout_default = $adult = $children = "";

        if (isset($_GET["check-availability"])) {
            $filter_data = filteration($_GET);

            $checkin_default = $filter_data["checkin"];
            $checkout_default = $filter_data["checkout"];
            $adult = $filter_data["adult"];
            $children = $filter_data["children"];
        }
    ?>

    <!-- Body -->
    <div class="my-5 px-4">
        <h2 class="fw-bold new-font text-center">Our Rooms</h2>
        <div class="horizontal-line bg-dark"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch p-3">
                        <h4 class="mt-2 new-font">Filters</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="filterDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch" id="filterDropdown">
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Check Availability</span>
                                    <button class="btn btn-sm text-secondary shadow-none d-none" id="check-reset" onclick="checkAvailabilityClear()">Reset</button>
                                </h5>
                                <label class="form-label">Check-In</label>
                                <input type="date" id="check-in" class="form-control shadow-none mb-3" value="<?php echo $checkin_default; ?>" onchange="checkAvailabilityFilter()">
                                <label class="form-label">Check-Out</label>
                                <input type="date" id="check-out" class="form-control shadow-none" value="<?php echo $checkout_default; ?>" onchange="checkAvailabilityFilter()">
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Facilities</span>
                                    <button class="btn btn-sm text-secondary shadow-none d-none" id="facilites-reset" onclick="facilitiesClear()">Reset</button>
                                </h5>

                                <?php
                                    // fetch all facilities
                                    $facilities_result = selectAllData("facilities");

                                    while ($data = mysqli_fetch_assoc($facilities_result)) {
                                        echo<<<facilities
                                            <div class="mb-2">
                                                <input type="checkbox" name="facilities" id="$data[id]" class="form-check-input shadow-none me-1" value="$data[id]" onclick="fetchRooms()">
                                                <label class="form-check-label" for="$data[id]">$data[name]</label>
                                            </div>        
                                        facilities;
                                    }
                                ?>
                            </div>
                            <div class="border bg-light p-3 rounded">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Guests</span>
                                    <button class="btn btn-sm text-secondary shadow-none d-none" id="guest-reset" onclick="guestClear()">Reset</button>
                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label" for="f-one">Children</label>
                                        <input type="number" id="children" class="form-control shadow-none" min="1" value="<?php echo $children; ?>" oninput="guestFilter()">
                                    </div>
                                    <div>
                                        <label class="form-label" for="f-one">Adults</label>
                                        <input type="number" id="adult" class="form-control shadow-none" min="1" value="<?php echo $adult; ?>" oninput="guestFilter()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4" id="rooms-data"></div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>