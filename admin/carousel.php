<?php
    require_once("./include/essential.php");
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/carousel.js" defer></script>
    <title>Carousel - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Carousel</h3>

                <!-- Carousel Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Carousel Images</h5>
                            <button type="button" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#carousel-image">
                                <i class="bi bi-plus-square"></i> Upload
                            </button>
                        </div>

                        <div class="row" id="carousel-data"></div>
                    </div>
                </div>

                <!-- Carousel Modal -->
                <div class="modal fade" id="carousel-image" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="carousel-image-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Carousel Image</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">                                
                                        <label class="form-label fw-bold">Image</label>
                                        <input type="file" id="carousel-image-input" name="carousel_image" class="form-control shadow-none" accept=".jpg, .jpeg, .png, .webp" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="carousel_image.value=''">Cancel</button>
                                    <button type="submit" class="btn custom-background text-white shadow-none">Upload</button>
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