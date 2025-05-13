<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <script src="./js/profile.js" defer></script>
    <title>Profile - <?php echo $settings_result["site_title"]; ?></title>
</head>
<body class="bg-light">
    <!-- Header -->
    <?php 
        require_once("./include/header.php");
        
        if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
            redirect("index.php");
        }

        $exist_user = "SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1";
        $user_values = [$_SESSION["userid"]];
        $user_result = select($exist_user, $user_values, "s");

        if (mysqli_num_rows($user_result) == 0) {
            redirect("index.php");
        }

        $fetch_user_data = mysqli_fetch_assoc($user_result);
    ?>

    <!-- Body -->
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">User Profile</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">/</span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Profile</a>
                </div>
            </div>

            <!-- User Profile Section -->
            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shaodw-sm">
                    <form action="" id="profile-form">
                        <h5 class="fw-bold mb-3">Profile picture</h5>
                        <img src="<?php echo USERS_IMAGE_PATH.$fetch_user_data["profile"]; ?>" class="img-fluid w-100 mb-3 rounded-circle">
                        <label class="form-label">New Profile Image</label>
                        <input type="file" name="profile" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none mb-4">
                        <button type="submit" class="btn custom-background text-white shadow-none">Save changes</button>
                    </form>
                </div>
            </div>

            <!-- User Password Section -->
            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shaodw-sm">
                    <form action="" id="password-form">
                        <h5 class="mb-3 fw-bold">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn custom-background text-white shadow-none">Save changes</button>
                    </form>
                </div>
            </div>

            <!-- User Information Section -->
            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shaodw-sm">
                    <form action="" id="info-form">
                        <h5 class="fw-bold mb-3">User Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control shadow-none" value="<?php echo $fetch_user_data["username"]; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phone" class="form-control shadow-none" value="<?php echo $fetch_user_data["phone"]; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control shadow-none" value="<?php echo $fetch_user_data["dob"]; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="number" name="pincode" class="form-control shadow-none" value="<?php echo $fetch_user_data["pincode"]; ?>" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Permanent Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" style="resize: none;" required><?php echo $fetch_user_data["address"]; ?></textarea> 
                            </div>
                        </div>
                        <button type="submit" class="btn custom-background text-white shadow-none">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once("./include/footer.php"); ?>
</body>
</html>