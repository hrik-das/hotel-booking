<?php
    require("../admin/include/connect.php");
    require("../admin/include/essential.php");
    date_default_timezone_set("Asia/Kolkata");
   
    if(isset($_POST["info-form"])){
        $filterData = filteration($_POST);
        session_start();
        $userExist = select("SELECT * FROM `user_cred` WHERE `phone`=? AND `id`!=? LIMIT 1", [$data["phone"], $_SESSION["userid"]], "ss");
        if(mysqli_num_rows($userExist) != 0){
            echo "phoneExist";
            exit();
        }
        $query = "UPDATE `user_cred` SET `name`=?, `address`=?, `phone`=?, `pincode`=?, `dob`=? WHERE `id`=?";
        $values = [$filterData["name"], $filterData["address"], $filterData["phone"], $filterData["pincode"], $filterData["dob"], $_SESSION["userid"]];
        if(update($query, $values, "sssssi")){
            $_SESSION["username"] = $filterData["name"];
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST["profile-form"])){
        session_start();
        $image = uploadUserImage($_FILES["profile"]);
        if($image == "invalidImage"){
            echo "invalidImage";
            exit();
        }else if($image == "uploadFailed"){
            echo "uploadFailed";
            exit();
        }
        $userExist = select("SELECT `profile` FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION["userid"]], "i");
        $userFetch = mysqli_fetch_assoc($userExist);
        deleteImage($userFetch["profile"], USER_FOLDER);
        $query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=?";
        $values = [$image, $_SESSION["userid"]];
        if(update($query, $values, "ss")){
            $_SESSION["userpic"] = $image;
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST["pass-form"])){
        $filterData = filteration($_POST);
        session_start();
        if($filterData["new_pass"] != $filterData["confirm_pass"]){
            echo "misMatched";
            exit();
        }
        $encryptPassword = password_hash($filterData["new_pass"], PASSWORD_BCRYPT);
        $query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";
        $values = [$encryptPassword, $_SESSION["userid"]];
        if(update($query, $values, "si")){
            echo 1;
        }else{
            echo 0;
        }
    }
?>