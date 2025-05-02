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

    if (isset($_POST["upload-member"])) {
        $filter_data = filteration($_POST);
        $result = uploadImage($_FILES["image"], TEAM_FOLDER);

        if (in_array($result, ["invalid-image", "invalid-size", "upload-failed"])) {
            echo $result;
        } else {
            $query = "INSERT INTO `team_details` (`name`, `image`) VALUES (?, ?)";
            $values = [$filter_data["name"], $result];
            $output = insert($query, $values, "ss");
            echo $output;
        }
    }

    if (isset($_POST["get-members"])) {
        $result = selectAllData("team_details");

        while($data = mysqli_fetch_assoc($result)) {
            $path = TEAM_IMAGE_PATH;

            echo<<<data
                <div class="col-md-2 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$data[image]" alt="$data[image]" class="card-image">
                        <div class="card-img-overlay text-end">
                            <button type="button" class="btn btn-danger btn-sm shadow-none" onclick="removeMember($data[sr_no])">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
                        </div>
                        <p class="card-text text-center px-3 py-2">$data[name]</p>
                    </div>
                </div>
            data;
        }
    }

    if (isset($_POST["remove-member"])) {
        $filter_data = filteration($_POST);
        $values = [$filter_data["remove-member"]];

        $pre_query = "SELECT * FROM `team_details` WHERE `sr_no`=?";
        $result = select($pre_query, $values, "i");
        $image = mysqli_fetch_assoc($result);

        if (deleteImage($image["image"], TEAM_FOLDER)) {
            $query = "DELETE FROM `team_details` WHERE `sr_no`=?";
            $result = delete($query, $values, "i");
            echo $result;
        } else {
            echo 0;
        }
    }
?>