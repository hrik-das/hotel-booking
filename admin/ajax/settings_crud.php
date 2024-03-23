<?php
    require("../include/connect.php");
    require("../include/essential.php");
    adminLogin();
    
    if(isset($_POST["getGeneral"])){
        $query = "SELECT * FROM `settings` WHERE `sr_no`=?";
        $values = [1];
        $result = select($query, $values, "i");
        $data = mysqli_fetch_assoc($result);
        $jsonData = json_encode($data);
        echo $jsonData;
    }

    if(isset($_POST["updateGeneral"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=?";
        $values = [$filterData["siteTitle"], $filterData["siteAbout"], 1];
        $result = update($query, $values, "ssi");
        echo $result;
    }
?>