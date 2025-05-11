<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    require_once("../include/sendgrid/sendgrid-php.php");
    date_default_timezone_set("Asia/Kolkata");

    function sendMail($user_email, $username, $token, $type) {
        if ($type == "email-confirmation") {
            $page = "auth/email_confirm.php";
            $subject = "Account verification link";
            $content = "Confirm your email address";
        } else {
            $page = "index.php";
            $subject = "Password reset link";
            $content = "Reset your password";
        }
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(SENDGRID_EMAIL_ADDRESS, SENDGRID_ORGANISATION);
        $email->setSubject($subject);
        $email->addTo($user_email, $username);

        $email->addContent(
            "text/html",
            "
                <strong>
                    Dear, $username
                    click the link below to $content <br/>
                    <a href='".SITE_URL."$page?$type&email=$user_email&token=$token"."'>click</a>
                </strong>
            "
        );

        $sendgrid = new \SendGrid(SENDGRID_API_KEY);
        
        try {
            $sendgrid->send($email);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    if (isset($_POST["register"])) {
        $filter_data = filteration($_POST);

        // check if the password and confirm-password are the same
        if ($filter_data["password"] != $filter_data["confirm-password"]) {
            echo "password-mismatch";
            exit;
        }

        // if any user already exists or not
        $query = "SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1";
        $values = [$filter_data["email"], $filter_data["phone"]];
        $user_exist = select($query, $values, "ss");

        if (mysqli_num_rows($user_exist) != 0) {
            $fetch_exist_user = mysqli_fetch_assoc($user_exist);
            echo ($fetch_exist_user["email"] == $filter_data["email"]) ? "email-exist" : "phone-exist";
            exit;
        }

        // upload user profile to the server
        $image = uploadUserImage($_FILES["profile"]);

        if ($image == "invalid-image") {
            echo "invalid-image";
            exit;
        } else if ($image == "upload-failed") {
            echo "upload-failed";
            exit;
        }

        // send confirmation link to user's email address
        $token = bin2hex(random_bytes(16));
        
        if (!sendMail($filter_data["email"], $filter_data["username"], $token, "email-confirmation")) {
            echo "mail-send-failed";
            exit;
        }

        // password hash
        $encrypt_password = password_hash($filter_data["password"], PASSWORD_BCRYPT);
        
        $query = "INSERT INTO `user_cred`(`username`, `email`, `phone`, `profile`, `address`, `pincode`, `dob`, `password`, `token`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$filter_data["username"], $filter_data["email"], $filter_data["phone"], $image, $filter_data["address"], $filter_data["pincode"], $filter_data["dob"], $encrypt_password, $token];
        
        if (insert($query, $values, "sssssssss")) {
            echo 1;
        } else {
            echo "registration-failed";
        }
    }

    if (isset($_POST["login"])) {
        $filter_data = filteration($_POST);

        // if any user already exists or not
        $query = "SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1";
        $values = [$filter_data["email-phone"], $filter_data["email-phone"]];
        $user_exist = select($query, $values, "ss");

        if (mysqli_num_rows($user_exist) == 0) {
            echo "invalid-details";
            exit;
        } else {
            $fetch_exist_user = mysqli_fetch_assoc($user_exist);

            if ($fetch_exist_user["is_verified"] == 0) {
                echo "not-verified";
            } else if ($fetch_exist_user["status"] == 0) {
                echo "status-blocked";
            } else {
                if (!password_verify($filter_data["password"], $fetch_exist_user["password"])) {
                    echo "invalid-password";
                } else {
                    session_start();
                    $_SESSION["login"] = true;
                    $_SESSION["userid"] = $fetch_exist_user["id"];
                    $_SESSION["username"] = $fetch_exist_user["username"];
                    $_SESSION["userprofile"] = $fetch_exist_user["profile"];
                    $_SESSION["userphone"] = $fetch_exist_user["phone"];
                    echo 1;
                }
            }
        }
    }

    if (isset($_POST["forgot-password"])) {
        $filter_data = filteration($_POST);

        // if any user already exists or not
        $query = "SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1";
        $values = [$filter_data["email"]];
        $user_exist = select($query, $values, "s");

        if (mysqli_num_rows($user_exist) == 0) {
            echo "invalid-user";
        } else {
            $fetch_exist_user = mysqli_fetch_assoc($user_exist);

            if ($fetch_exist_user["is_verified"] == 0) {
                echo "not-verified";
            } else if ($fetch_exist_user["status"] == 0) {
                echo "status-blocked";
            } else {
                // send reset password link to user email address
                $token = bin2hex(random_bytes(16));
                if (!sendMail($filter_data["email"], $fetch_exist_user["username"], $token, "reset-password")) {
                    echo "send-mail-failed";
                } else {
                    $date = date("Y-m-d");

                    $query = "UPDATE `user_cred` SET `token`='$token', `token_expire`='$date' WHERE `id`='$fetch_exist_user[id]'";
                    $result = mysqli_query($connect, $query);

                    if ($result) {
                        echo 1;
                    } else {
                        echo "update-failed";
                    }
                }
            }
        }
    }

    if (isset($_POST["recover-account"])) {
        $filter_data = filteration($_POST);

        $encrypt_password = password_hash($filter_data["password"], PASSWORD_BCRYPT);

        $query = "UPDATE `user_cred` SET `password`=?, `token`=?, `token_expire`=? WHERE `email`=? AND `token`=?";
        $values = [$encrypt_password, null, null, $filter_data["email"], $filter_data["token"]];

        if (update($query, $values, "sssss")) {
            echo 1;
        } else {
            echo "failed";
        }
    }
?>