<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");

    if (isset($_GET["email_confirmation"])) {
        $data = filteration($_GET);
        $query = "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1";
        $values = [$data["email"], $data["token"]];
        $result = executeCrud("select", $query, $values, "ss");
        if (mysqli_num_rows($result) > 0) {
            $fetch = mysqli_fetch_assoc($result);
            if ($fetch["is_verified"] == 1) {
                echo "<script> alert('Email Already Verified!'); </script>";
            } else {
                $updateQuery = "UPDATE `user_cred` SET `is_verified`=? WHERE `id`=?";
                $updateValues = [1, $fetch["id"]];
                $update = executeCrud("update", $updateQuery, $updateValues, "ii");
                if ($update) {
                    echo "<script> alert('Email Address Successfully Verified.'); </script>";
                } else {
                    echo "<script> alert('Email Verification Failed!'); </script>";
                }
            }
            redirect("../index.php");
        } else {
            echo "<script> alert('Invalid Link!'); </script>";
            redirect("../index.php");
        }
    }
?>