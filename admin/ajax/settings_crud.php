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

    if(isset($_POST["updateShutdown"])){
        $filterData = ($_POST["updateShutdown"] == 0) ? 1 : 0;
        $query = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
        $values = [$filterData, 1];
        $result = update($query, $values, "ii");
        echo $result;
    }

    if(isset($_POST["getContact"])){
        $query = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
        $values = [1];
        $result = select($query, $values, "i");
        $data = mysqli_fetch_assoc($result);
        $jsonData = json_encode($data);
        echo $jsonData;
    }

    if(isset($_POST["updateContact"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `contact_details` SET `address`=?, `gmap`=?, `phone1`=?, `phone2`=?, `email`=?, `fb`=?, `insta`=?, `tw`=?, `iframe`=? WHERE `sr_no`=?";
        $values = [$filterData["address"], $filterData["gmap"], $filterData["ph1"], $filterData["ph2"], $filterData["email"], $filterData["fb"], $filterData["insta"], $filterData["tw"], $filterData["iframe"], 1];
        $result = update($query, $values, "sssssssssi");
        echo $result;
    }
?>