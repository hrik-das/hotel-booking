<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["add-feature"])) {
        $filter_data = filteration($_POST);

        $query = "INSERT INTO `features`(`name`) VALUES (?)";
        $values = [$filter_data["feature-name"]];
        $result = insert($query, $values, "s");
        echo $result;
    }

    if (isset($_POST["get-features"])) {
        $i = 1;
        $result = selectAllData("features");

        while($data = mysqli_fetch_assoc($result)) {
            echo<<<data
                <tr class="text-center">
                    <td>$i</td>
                    <td>$data[name]</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm shadow-none" onclick="removeFeature($data[id])">
                            <i class="bi bi-trash-fill"></i> Delete
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if (isset($_POST["remove-feature"])) {
        $filter_data = filteration($_POST);
        $values = [$filter_data["remove-feature"]];

        $feature_validation = select("SELECT * FROM `room_features` WHERE `features_id`=?", [$filter_data["remove-feature"]], "i");

        if (mysqli_num_rows($feature_validation) == 0) {
            $query = "DELETE FROM `features` WHERE `id`=?";
            $result = delete($query, $values, "i");
            echo $result;
        } else {
            echo "in-use";
        }

    }

    if (isset($_POST["add-facility"])) {
        $filter_data = filteration($_POST);
        $result = uploadSVGImage($_FILES["facility-icon"], FACILITY_FOLDER);

        if (in_array($result, ["invalid-image", "invalid-size", "upload-failed"])) {
            echo $result;
        } else {
            $query = "INSERT INTO `facilities` (`icon`, `name`, `description`) VALUES (?, ?, ?)";
            $values = [$result, $filter_data["facility-name"], $filter_data["facility-desc"]];
            $output = insert($query, $values, "sss");
            echo $output;
        }
    }

    if (isset($_POST["get-facilities"])) {
        $i = 1;
        $result = selectAllData("facilities");

        while($data = mysqli_fetch_assoc($result)) {
            $path = FACILITY_IMAGE_PATH;

            echo<<<data
                <tr class="text-center">
                    <td>$i</td>
                    <td>
                        <img src="$path$data[icon]" alt="$data[icon]" width="35px" />
                    </td>
                    <td>$data[name]</td>
                    <td>$data[description]</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm shadow-none" onclick="removeFacility($data[id])">
                            <i class="bi bi-trash-fill"></i> Delete
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if (isset($_POST["remove-facility"])) {
        $filter_data = filteration($_POST);
        $values = [$filter_data["remove-facility"]];

        $facility_validation = select("SELECT * FROM `room_facilities` WHERE `facilities_id`=?", [$filter_data["remove-facility"]], "i");

        if (mysqli_num_rows($facility_validation) == 0) {
            $pre_query = "SELECT * FROM `facilities` WHERE `id`=?";
            $result = select($pre_query, $values, "i");
            $image = mysqli_fetch_assoc($result);
    
            if (deleteImage($image["icon"], FACILITY_FOLDER)) {
                $query = "DELETE FROM `facilities` WHERE `id`=?";
                $result = delete($query, $values, "i");
                echo $result;
            } else {
                echo 0;
            }
        } else {
            echo "in-use";
        }

    }
?>