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
?>