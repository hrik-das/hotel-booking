<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if (isset($_POST["info-form"])) {
        $filter_data = filteration($_POST);

        // if any user already exists or not
        $query = "SELECT * FROM `user_cred` WHERE `phone`=? AND `id`!=? LIMIT 1";
        $values = [$filter_data["phone"], $_SESSION["userid"]];
        $user_exist = select($query, $values, "ss");

        if (mysqli_num_rows($user_exist) != 0) {
            $fetch_exist_user = mysqli_fetch_assoc($user_exist);
            echo "phone-exist";
            exit;
        }

        $update_query = "UPDATE `user_cred` SET `username`=?, `phone`=?, `dob`=?, `pincode`=?, `address`=? WHERE `id`=?";
        $update_values = [$filter_data["username"], $filter_data["phone"], $filter_data["dob"], $filter_data["pincode"], $filter_data["address"], $_SESSION["userid"]];
        $update_result = update($update_query, $update_values, "sssssi");

        if ($update_result) {
            echo 1;
            $_SESSION["username"] = $filter_data["username"];
        } else {
            echo 0;
        }
    }

    if (isset($_POST["profile-form"])) {
        $image = uploadUserImage($_FILES["profile"]);

        if ($image == "invalid-image") {
            echo "invalid-image";
            exit;
        } else if ($image == "upload-failed") {
            echo "upload-failed";
            exit;
        }

        // fetch previous image and delete from server
        $query = "SELECT `profile` FROM `user_cred` WHERE `id`=? LIMIT 1";
        $values = [$_SESSION["userid"]];
        $user_exist = select($query, $values, "i");
        $user_fetch = mysqli_fetch_assoc($user_exist);
        deleteImage($user_fetch["profile"], USER_FOLDER);

        // upload a new profile image to server
        $update_query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=?";
        $update_values = [$image, $_SESSION["userid"]];
        $update_result = update($update_query, $update_values, "si");

        if ($update_result) {
            echo 1;
            $_SESSION["userprofile"] = $image;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["password-form"])) {
        $filter_data = filteration($_POST);

        // check if the password and confirm-password are the same
        if ($filter_data["password"] != $filter_data["confirm-password"]) {
            echo "mismatch";
            exit;
        }

        $encrypt_password = password_hash($filter_data["password"], PASSWORD_BCRYPT);

        $update_query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";
        $update_values = [$encrypt_password, $_SESSION["userid"]];
        $update_result = update($update_query, $update_values, "si");

        if ($update_result) {
            echo 1;
        } else {
            echo 0;
        }
    }
?>