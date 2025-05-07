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
    <script src="./js/rooms.js" defer></script>
    <title>Rooms - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Rooms</h3>

                <!-- Rooms Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-striped table-hover border text-center">
                                <thead>
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Room Modal -->
                <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="" id="add-room-form" autocomplete="off">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Rooms</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Name</label>
                                            <input type="text" name="name" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Area</label>
                                            <input type="number" name="area" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Price</label>
                                            <input type="number" name="price" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Quantity</label>
                                            <input type="number" name="quantity" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Adult (Max.)</label>
                                            <input type="number" name="adult" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Children (Max.)</label>
                                            <input type="number" name="children" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Features</label>
                                            <div class="row">
                                                <?php
                                                    $result = selectAllData("features");

                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        echo "
                                                            <div class='col-md-3 mb-1'>
                                                                <label>
                                                                    <input type='checkbox' name='features' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[name]
                                                                </label>
                                                            </div>
                                                        ";
                                                    }
                                                ?>    
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Facilities</label>
                                            <div class="row">
                                                <?php
                                                    $result = selectAllData("facilities");

                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        echo "
                                                            <div class='col-md-3 mb-1'>
                                                                <label>
                                                                    <input type='checkbox' name='facilities' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[name]
                                                                </label>
                                                            </div>
                                                        ";
                                                    }
                                                ?>    
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Description</label>
                                            <textarea name="desc" rows="4" class="form-control shadow-none" style="resize: none;" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn custom-background text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Room Modal -->
                <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="" id="edit-room-form" autocomplete="off">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Room</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Name</label>
                                            <input type="text" name="name" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Area</label>
                                            <input type="number" name="area" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Price</label>
                                            <input type="number" name="price" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Quantity</label>
                                            <input type="number" name="quantity" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Adult (Max.)</label>
                                            <input type="number" name="adult" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Children (Max.)</label>
                                            <input type="number" name="children" class="form-control shadow-none" min="1" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Features</label>
                                            <div class="row">
                                                <?php
                                                    $result = selectAllData("features");

                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        echo "
                                                            <div class='col-md-3 mb-1'>
                                                                <label>
                                                                    <input type='checkbox' name='features' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[name]
                                                                </label>
                                                            </div>
                                                        ";
                                                    }
                                                ?>    
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Facilities</label>
                                            <div class="row">
                                                <?php
                                                    $result = selectAllData("facilities");

                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        echo "
                                                            <div class='col-md-3 mb-1'>
                                                                <label>
                                                                    <input type='checkbox' name='facilities' value='$data[id]' class='form-check-input shadow-none'>
                                                                    $data[name]
                                                                </label>
                                                            </div>
                                                        ";
                                                    }
                                                ?>    
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Description</label>
                                            <textarea name="desc" rows="4" class="form-control shadow-none" style="resize: none;" required></textarea>
                                        </div>
                                        <input type="hidden" name="room_id">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn custom-background text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>