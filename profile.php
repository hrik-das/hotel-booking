<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <script src="./js/profile.js" defer></script>
    <title><?php echo $settings_r["site_title"]; ?> - Profile</title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php 
        require("./include/header.php");
        if(!(isset($_SESSION["login"]) || $_SESSION["login"] == true)){
            redirect("index.php");
        }
        $userExist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION["userid"]], "s");
        if(mysqli_num_rows($userExist) == 0){
            redirect("index.php");
        }
        $userFetch = mysqli_fetch_assoc($userExist);
    ?>

    <!-- Filters -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Profile</h2>
                <div id="room-style">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="" class="text-secondary text-decoration-none">Profile</a>
                </div>
            </div>
            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" id="info-form">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="name" value="<?php echo $userFetch["name"] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phone" value="<?php echo $userFetch["phone"] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" value="<?php echo $userFetch["dob"] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="number" name="pincode" value="<?php echo $userFetch["pincode"] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Address</label>
                                <textarea rows="1" name="address" class="form-control shadow-none" required><?php echo $userFetch["address"]; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm custom-bg text-white shadow-none">Save Canges</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("./include/footer.php"); ?>
</body>
</html>