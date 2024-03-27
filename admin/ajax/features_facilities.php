<?php
    require("../include/connect.php");
    require("../include/essential.php");
    adminLogin();

    if(isset($_POST["addFeature"])){
        $filterData = filteration($_POST);
        $query = "INSERT INTO `features` (`name`) VALUES (?)";
        $values = [$filterData["name"]];
        $result = insert($query, $values, "s");
        echo $result;
    }

    if(isset($_POST["getFeatures"])){
        $result = selectAll("features");
        $i = 1;
        while($data = mysqli_fetch_assoc($result)){
            echo <<<data
                <tr>
                    <td>$i</td>
                    <td>$data[name]</td>
                    <td>
                        <button type="button" onclick="deleteFeature($data[id])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if(isset($_POST["deleteFeature"])){
        $filterData = filteration($_POST);
        $values = [$filterData["deleteFeature"]];
        // $checkQuery = "SELECT * FROM `room_features` WHERE `features_id`=?";
        // $checkValues = [$filterData['deleteFeature']];
        // $check = select($checkQuery, $checkValues, "i");
        // if(mysqli_num_rows($check) == 0){
            $query = "DELETE FROM `features` WHERE `id`=?";
            $result = delete($query, $values, "i");
            echo $result;
        // }else{
            // echo "room_added";
        // }
    }

    if(isset($_POST["addFacility"])){
        $filterData = filteration($_POST);
        $img_r = uploadSVG($_FILES["icon"], FACILITIES_FOLDER);
        if($img_r == "invalidImage"){
            echo $img_r;
        }else if($img_r == "invalidSize"){
            echo $img_r;
        }else if($img_r == "uploadFailed"){
            echo $img_r;
        }else{
            $query = "INSERT INTO `facilities` (`icon`, `name`, `description`) VALUES (?, ?, ?)";
            $values = [$img_r, $filterData["name"], $filterData["desc"]];
            $result = insert($query, $values, "sss");
            echo $result;
        }
    }

    if(isset($_POST["getFacilities"])){
        $result = selectAll("facilities");
        $i = 1;
        $path = FACILITIES_IMG_PATH;
        while($data = mysqli_fetch_assoc($result)){
            echo<<<data
                <tr class="align-middle">
                    <td>$i</td>
                    <td><img src="$path$data[icon]" width="100px"></td>
                    <td>$data[name]</td>
                    <td>$data[description]</td>
                    <td>
                        <button type="button" onclick="deleteFacility($data[id])" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if(isset($_POST["deleteFacility"])){
        $filterData = filteration($_POST);
        $values = [$filterData["deleteFacility"]];
        // $checkQuery = "SELECT * FROM `room_facilities` WHERE `facilities_id`=?";
        // $checkValues = [$filterData["deleteFacility"]];
        // $check = select($checkQuery, $checkValues, "i");
        // if(mysqli_num_rows($check) == 0){
        // }else{
        //     echo "room_added";
        // }
        $preQurey = "SELECT * FROM `facilities` WHERE `id`=?";
        $result = select($preQurey, $values, "i");
        $image = mysqli_fetch_assoc($result);

        if(deleteImage($image["icon"], FACILITIES_FOLDER)){
            $query = "DELETE FROM `facilities` WHERE `id`=?";
            $result = delete($query, $values, "i");
            echo $result;
        }else{
            echo 0;
        }
        $query = "DELETE FROM `facilities` WHERE `id`=?";
        $result = delete($query, $values, "i");
        echo $result;
    }
?>