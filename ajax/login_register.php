<?php
    require("../admin/include/connect.php");
    require("../admin/include/essential.php");
    require("../include/sendgrid/sendgrid-php.php");
    date_default_timezone_set("Asia/Kolkata");

    function sendMail($useremail, $token, $type){
        if($type == "emailConfirmation"){
            $page = "./auth/email_confirm.php";
            $subject = "Account Verification Link";
            $content = "Confirm Your Email";
        }else{
            $page = "index.php";
            $subject = "Account Reset Link";
            $content = "Reset Your Password";
        }
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(SENDGRID_EMAIL, SENDGRID_NAME);
        $email->setSubject($subject);
        $email->addTo($useremail);
        $email->addContent(
            "text/html",
            "Click the Link to $content: 
            <a href='".SITE_URL."$page?$type&email=$useremail&token=$token"."'>Click Here</a>"
        );
        $sendgrid = new \SendGrid(SENDGRID_API_KEY);
        try{
            $sendgrid->send($email);
            return 1;
        }catch(Exception $error){
            return 0;
        }
    }
    
    if(isset($_POST["register"])){
        $data = filteration($_POST);
        // Password and Confirm Password
        if($data["pass"] != $data["cpass"]){
            echo "passwordMisMatch";
            exit();
        }
        // Check User Exist or Not
        $userExist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1", [$data["email"], $data["phone"]], "ss");
        if(mysqli_num_rows($userExist) != 0){
            $userExistFetch = mysqli_fetch_assoc($userExist);
            echo ($userExistFetch["email"] == $data["email"]) ? "emailExist" : "phoneExist";
            exit();
        }
        // Upload User Image to Server
        $image = uploadUserImage($_FILES["profile"]);
        if($image == "invalidImage"){
            echo "invalidImage";
            exit();
        }else if($image == "uploadFailed"){
            echo "uploadFailed";
            exit();
        }else{
            // Send Confirmation Link to User Email
            $token = bin2hex(random_bytes(16));
            if(!(sendMail($data["email"], $token, "emailConfirmation"))){
                echo "mailFailed";
                exit();
            }
            $encryptPassword = password_hash($data["pass"], PASSWORD_BCRYPT);
            $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phone`, `pincode`, `dob`, `profile`, `password`, `token`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $values = [$data["name"], $data["email"], $data["address"], $data["phone"], $data["pincode"], $data["dob"], $image, $encryptPassword, $token];
            if(insert($query, $values, "sssssssss")){
                echo 1;
            }else{
                echo "insertFailed";
            }
        }
    }

    if(isset($_POST["login"])){
        $data = filteration($_POST);
        $userExist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1", [$data["email_mob"], $data["email_mob"]], "ss");
        if(mysqli_num_rows($userExist) == 0){
            echo "invalidEmailorPhone";
            exit();
        }else{
            $userFetch = mysqli_fetch_assoc($userExist);
            if($userFetch["isVerified"] == 0){
                echo "notVerified";
            }else if($userFetch["status"] == 0){
                echo "inactive";
            }else{
                if(!(password_verify($data["pass"], $userFetch["password"]))){
                    echo "invalidPassword";
                }else{
                    session_start();
                    $_SESSION["login"] = true;
                    $_SESSION["userid"] = $userFetch["id"];
                    $_SESSION["username"] = $userFetch["name"];
                    $_SESSION["userpic"] = $userFetch["profile"];
                    $_SESSION["userphone"] = $userFetch["phone"];
                    echo 1;
                }
            }
        }
    }

    if(isset($_POST["forgot"])){
        $data = filteration($_POST);
        $userExist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1", [$data["email"]], "s");
        if(mysqli_num_rows($userExist) == 0){
            echo "invalidEmail";
        }else{
            $userFetch = mysqli_fetch_assoc($userExist);
            if($userFetch["isVerified"] == 0){
                echo "notVerified";
            }else if($userFetch["status"] == 0){
                echo "inactive";
            }else{
                // Send Reset Link to Given Email
                $token = bin2hex(random_bytes(16));
                if(!(sendMail($data["email"], $token, "accountRecovery"))){
                    echo "mailFailed";
                }else{
                    $date = date("Y-m-d");
                    $query = "UPDATE `user_cred` SET `token`='$token', `tokenExpire`='$date' WHERE `id`='$userFetch[id]'";
                    $result = mysqli_query($connect, $query);
                    if($result){
                        echo 1;
                    }else{
                        echo "updateFailed";
                    }
                }
            }
        }
    }

    if(isset($_POST["recover"])){
        $data = filteration($_POST);
        $encryptPassword = password_hash($data["pass"], PASSWORD_BCRYPT);
        $query = "UPDATE `user_cred` SET `password`=?, `token`=?, `tokenExpire`=? WHERE `email`=? AND `token`=?";
        $values = [$encryptPassword, null, null, $data["email"], $data["token"]];
        if(update($query, $values, "sssss")){
            echo 1;
        }else{
            echo "failed";
        }
    }
?>