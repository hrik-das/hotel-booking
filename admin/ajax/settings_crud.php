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

    if(isset($_POST["addMember"])){
        $filterData = filteration($_POST);
        $img_r = uploadImage($_FILES["picture"], ABOUT_FOLDER);
        if($img_r == "invalidImage"){
            echo $img_r;
        }else if($img_r == "invalidSize"){
            echo $img_r;
        }else if($img_r == "uploadFailed"){
            echo $img_r;
        }else{
            $query = "INSERT INTO `team_details` (`name`, `picture`) VALUES (?, ?)";
            $values = [$filterData["name"], $img_r];
            $result = insert($query, $values, "ss");
            echo $result;
        }
    }

    if(isset($_POST["getMember"])){
        $result = selectAll("team_details");
        while($data = mysqli_fetch_assoc($result)){
            $path = ABOUT_IMG_PATH;
            echo<<<data
                <div class="col-md-2 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$data[picture]" class="card-img">
                        <div class="card-img-overlay text-end">
                            <button type="button" onclick="deleteMember($data[sr_no])" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                        <p class="card-text text-center px-3 py-2">$data[name]</p>
                    </div>
                </div>
            data;
        }
    }

    if(isset($_POST["deleteMember"])){
        $filterData = filteration($_POST);
        $values = [$filterData["deleteMember"]];
        $preQurey = "SELECT * FROM `team_details` WHERE `sr_no`=?";
        $result = select($preQurey, $values, "i");
        $image = mysqli_fetch_assoc($result);
        if(deleteImage($image["picture"], ABOUT_FOLDER)){
            $query = "DELETE FROM `team_details` WHERE `sr_no`=?";
            $result = delete($query, $values, "i");
            echo $result;
        }else{
            echo 0;
        }
    }
?>