<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["get-general"])) {
        $query = "SELECT * FROM `settings` WHERE `sr_no`=?";
        $values = [1];
        $result = select($query, $values, "i");
        $data = mysqli_fetch_assoc($result);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if (isset($_POST["update-general"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=?";
        $values = [$filter_data["site_title"], $filter_data["site_about"], 1];
        $result = update($query, $values, "ssi");
        echo $result;
    }

    if (isset($_POST["update-shutdown"])) {
        $filter_data = ($_POST["update-shutdown"] == 0) ? 1 : 0;

        $query = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
        $values = [$filter_data, 1];
        $result = update($query, $values, "ii");
        echo $result;
    }

    if (isset($_POST["get-contacts"])) {
        $query = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
        $values = [1];
        $result = select($query, $values, "i");
        $data = mysqli_fetch_assoc($result);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if (isset($_POST["update-contacts"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `contact_details` SET `address`=?, `gmap`=?, `phone_one`=?, `phone_two`=?, `email`=?, `facebook`=?, `instagram`=?, `twitter`=?, `iframe`=? WHERE `sr_no`=?";
        $values = [$filter_data["address"], $filter_data["gmap"], $filter_data["phone_one"], $filter_data["phone_two"], $filter_data["email"], $filter_data["facebook"], $filter_data["instagram"], $filter_data["twitter"], $filter_data["iframe"], 1];
        $result = update($query, $values, "sssssssssi");
        echo $result;
    }
?>