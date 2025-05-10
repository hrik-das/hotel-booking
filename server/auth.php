<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");
    require_once("../include/sendgrid/sendgrid-php.php");

    function sendMail($user_email, $username, $token) {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("hrikdas123@gmail.com", "Godlike Restaurant");
        $email->setSubject("Account Verification Link");
        $email->addTo($user_email, $username);

        $email->addContent(
            "text/html",
            "
                <strong>
                    click the link below to confirm your email address: <br/>
                    <a href='".SITE_URL."auth/email_confirm.php?email-confirmation&email=$user_email&token=$token"."'>click</a>
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
        
        if (!sendMail($filter_data["email"], $filter_data["username"], $token)) {
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
?>