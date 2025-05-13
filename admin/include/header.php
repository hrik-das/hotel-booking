<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
    <h3 class="mb-0 new-font">Godlike Restaurant</h3>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
</div>

<div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light text-uppercase">Admin Panel</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="filterDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookingLink">
                            <span>Bookings</span>
                            <span>
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="bookingLink">
                            <ul class="nav nav-pills flex-column rounded border border-secondary">
                                <li class="nav-item">
                                    <a href="new_booking.php" class="nav-link text-light">New Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a href="refund_booking.php" class="nav-link text-light">Refund Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a href="booking_record.php" class="nav-link text-light">Booking Records</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="features_facilities.php">Features & Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_queries.php">Users Queries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carousel.php">Carousel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php">Users</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>