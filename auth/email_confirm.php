<?php
    require("../admin/include/connect.php");
    require("../admin/include/essential.php");

    if(isset($_GET["emailConfirmation"])){
        $data = filteration($_GET);
        $query = "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1";
        $values = [$data["email"], $data["token"]];
        $result = select($query, $values, "ss");
        if(mysqli_num_rows($result) > 0){
            $fetch = mysqli_fetch_assoc($result);
            if($fetch["isVerified"] == 1){
                echo "<script> alert('Email Already Verified!'); </script>";
            }else{
                $updateQuery = "UPDATE `user_cred` SET `isVerified`=? WHERE `id`=?";
                $updateValues = [1, $fetch["id"]];
                $update = update($updateQuery, $updateValues, "ii");
                if($update){
                    echo "<script> alert('Successfully Verified!'); </script>";
                }else{
                    echo "<script> alert('Verification Failed!'); </script>";
                }
            }
            redirect("../index.php");
        }else{
            echo "<script> alert('Invalid Link!'); </script>";
            redirect("../index.php");
        }
    }
?>