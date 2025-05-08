<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["upload-image"])) {
        $result = uploadImage($_FILES["image"], CAROUSEL_FOLDER);

        if (in_array($result, ["invalid-image", "invalid-size", "upload-failed"])) {
            echo $result;
        } else {
            $query = "INSERT INTO `carousel`(`image`) VALUES (?)";
            $values = [$result];
            $output = insert($query, $values, "s");
            echo $output;
        }
    }

    if (isset($_POST["get-carousel"])) {
        $result = selectAllData("carousel");

        while($data = mysqli_fetch_assoc($result)) {
            $path = CAROUSEL_IMAGE_PATH;

            echo<<<data
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$data[image]" alt="$data[image]" class="card-image">
                        <div class="card-img-overlay text-end">
                            <button type="button" class="btn btn-danger btn-sm shadow-none" onclick="removeImage($data[sr_no])">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            data;
        }
    }

    if (isset($_POST["remove-image"])) {
        $filter_data = filteration($_POST);
        
        $pre_query = "SELECT * FROM `carousel` WHERE `sr_no`=?";
        $values = [$filter_data["remove-image"]];
        $result = select($pre_query, $values, "i");
        $image = mysqli_fetch_assoc($result);

        if (deleteImage($image["image"], CAROUSEL_FOLDER)) {
            $query = "DELETE FROM `carousel` WHERE `sr_no`=?";
            $result = delete($query, $values, "i");
            echo $result;
        } else {
            echo 0;
        }
    }
?>