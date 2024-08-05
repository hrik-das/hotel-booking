<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/profile.js" defer></script>
    <title>Profile - <?php echo $settings_r["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php require_once("./include/header.php"); ?>
    
    <?php 
        if (!(isset($_SESSION["login"]) || $_SESSION["login"] == true)) {
            redirect("index.php");
        }
        $userExist = executeCrud("select", "SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION["userid"]], "s");
        if (mysqli_num_rows($userExist) == 0) {
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
                        <button type="submit" class="btn btn-sm custom-background text-white shadow-none">Save Canges</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" id="profile-form">
                        <h5 class="mb-3 fw-bold">Picture</h5>
                        <img src="<?php echo USER_IMG_PATH.$userFetch['profile']; ?>" class="img-fluid mb-3" alt="">
                        <label class="form-label">New Picture</label>
                        <input type="file" name="profile" class="form-control shadow-none mb-4" accept=".jpg, .png, .jpeg, .webp" required>
                        <button type="submit" class="btn btn-sm custom-background text-white shadow-none">Save Canges</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" id="pass-form">
                        <h5 class="mb-3 fw-bold">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_pass" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="con_pass" class="form-control shadow-none" required>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-sm custom-background text-white shadow-none">Save Canges</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>