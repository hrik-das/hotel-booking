<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["addImage"])) {
        $img_r = uploadImage($_FILES["picture"], CAROUSEL_FOLDER);
        if ($img_r == "invalidImage") {
            echo $img_r;
        } else if ($img_r == "invalidSize") {
            echo $img_r;
        } else if ($img_r == "uploadFailed") {
            echo $img_r;
        } else {
            $query = "INSERT INTO `carousel` (`image`) VALUES (?)";
            $values = [$img_r];
            $result = executeCrud("insert", $query, $values, "s");
            echo $result;
        }
    }

    if (isset($_POST["getCarousel"])) {
        $result = selectAll("carousel");
        while ($data = mysqli_fetch_assoc($result)) {
            $path = CAROUSEL_IMG_PATH;
            echo<<<data
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$data[image]" class="card-img">
                        <div class="card-img-overlay text-end">
                            <button type="button" onclick="deleteCarousel($data[sr_no])" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            data;
        }
    }

    if (isset($_POST["deleteCarousel"])) {
        $filterData = filteration($_POST);
        $values = [$filterData["deleteCarousel"]];
        $preQurey = "SELECT * FROM `carousel` WHERE `sr_no`=?";
        $result = executeCrud("select", $preQurey, $values, "i");
        $image = mysqli_fetch_assoc($result);
        if (deleteImage($image["image"], CAROUSEL_FOLDER)) {
            $query = "DELETE FROM `carousel` WHERE `sr_no`=?";
            $result = executeCrud("delete", $query, $values, "i");
            echo $result;
        } else {
            echo 0;
        }
    }
?>