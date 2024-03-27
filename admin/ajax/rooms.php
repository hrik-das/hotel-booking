<?php
    require("../include/connect.php");
    require("../include/essential.php");
    adminLogin();

    if(isset($_POST["addRoom"])){
        $flag = 0;
        $features = filteration(json_decode($_POST["features"]));
        $facilities = filteration(json_decode($_POST["facilities"]));
        $filterData = filteration($_POST);
        $query1 = "INSERT INTO `rooms`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = [$filterData["name"], $filterData["area"], $filterData["price"], $filterData["quantity"], $filterData["adult"], $filterData["children"], $filterData["desc"]];
        if(insert($query1, $values, "siiiiis")){
            $flag = 1;
        }
        $roomId = mysqli_insert_id($connect);
        $query2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?, ?)";
        if($stmt = mysqli_prepare($connect, $query2)){
            foreach($facilities as $f){
                mysqli_stmt_bind_param($stmt, "ii", $roomId, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }else{
            $flag = 0;
            die("Query cannot be Prepared - Insert");
        }
        $query3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?, ?)";
        if($stmt = mysqli_prepare($connect, $query3)){
            foreach($features as $f){
                mysqli_stmt_bind_param($stmt, "ii", $roomId, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }else{
            $flag = 0;
            die("Query cannot be Prepared - Insert");
        }
        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST["getAllRooms"])){
        $i = 1;
        $data = "";
        $result = selectAll("rooms");
        while($row = mysqli_fetch_assoc($result)){
            if($row["status"] == 1){
                $status = "<button onclick='toggleStatus($row[id], 0)' class='btn btn-success btn-sm shadow-none'>Active</button>";
            }else{
                $status = "<button onclick='toggleStatus($row[id], 1)' class='btn btn-warning btn-sm shadow-none'>Inactive</button>";
            }
            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[area] Sqft.</td>
                    <td>
                        <span class='badge rounded-pill bg-light text-dark'>
                            Adult: $row[adult]
                        </span><br>
                        <span class='badge rounded-pill bg-light text-dark'>
                            Children: $row[children]
                        </span>
                    </td>
                    <td>₹$row[price]</td>
                    <td>$row[quantity]</td>
                    <td>$status</td>
                    <td>
                        <button type='button' onclick='editDetails($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
                            <i class='bi bi-pencil-square'></i>
                        </button>
                        <button type='button' onclick=\"roomImages($row[id], '$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
                            <i class='bi bi-images'></i>
                        </button>
                        <button type='button' onclick='removeRoom($row[id])' class='btn btn-danger shadow-none btn-sm'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST["toggleStatus"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
        $values = [$filterData["value"], $filterData["toggleStatus"]];
        if(update($query, $values, "ii")){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST["getRoom"])){
        $filterData = filteration($_POST);
        $query1 = "SELECT * FROM `rooms` WHERE `id`=?";
        $values1 = [$filterData["getRoom"]];
        $result1 = select($query1, $values1, "i");
        $query2 = "SELECT * FROM `room_features` WHERE `room_id`=?";
        $values2 = [$filterData["getRoom"]];
        $result2 = select($query2, $values2, "i");
        $query3 = "SELECT * FROM `room_facilities` WHERE `room_id`=?";
        $values3 = [$filterData["getRoom"]];
        $result3 = select($query3, $values3, "i");
        $roomdata = mysqli_fetch_assoc($result1);
        $features = [];
        $facilities = [];
        if(mysqli_num_rows($result2) > 0){
            while($data = mysqli_fetch_assoc($result2)){
                array_push($features, $data["features_id"]);
            }
        }
        if(mysqli_num_rows($result3) > 0){
            while($data = mysqli_fetch_assoc($result3)){
                array_push($facilities, $data["facilities_id"]);
            }
        }
        $data = ["roomdata" => $roomdata, "features" => $features, "facilities" => $facilities];
        $data = json_encode($data);
        echo $data;
    }

    if(isset($_POST["editRoom"])){
        $flag = 0;
        $filterData = filteration($_POST);
        $features = filteration(json_decode($_POST["features"]));
        $facilities = filteration(json_decode($_POST["facilities"]));
        $query1 = "UPDATE `rooms` SET `name`=?, `area`=?, `price`=?, `quantity`=?, `adult`=?, `children`=?, `description`=? WHERE `id`=?";
        $values = [$filterData["name"], $filterData["area"], $filterData["price"], $filterData["quantity"], $filterData["adult"], $filterData["children"], $filterData["desc"], $filterData["room_id"]];
        if(update($query1, $values, "siiiiisi")){
            $flag = 1;
        }
        $deleteQuery1 = "DELETE FROM `room_features` WHERE `room_id`=?";
        $deleteValue1 = [$filterData["room_id"]]; 
        $deleteFeatures = delete($deleteQuery1, $deleteValue1, "i");
        $deleteQuery2 = "DELETE FROM `room_facilities` WHERE `room_id`=?";
        $deleteValue2 = [$filterData["room_id"]];
        $deleteFacilities = delete($deleteQuery2, $deleteValue2, "i");
        if(!($deleteFacilities && $deleteFeatures)){
            $flag = 0;
        }
        $query2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?, ?)";
        if($stmt = mysqli_prepare($connect, $query2)){
            foreach($facilities as $f){
                mysqli_stmt_bind_param($stmt, "ii", $filterData["room_id"], $f);
                mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
        }else{
            $flag = 0;
            die("Query cannot be Prepared - Insert");
        }
        $query3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?, ?)";
        if($stmt = mysqli_prepare($connect, $query3)){
            foreach($features as $f){
                mysqli_stmt_bind_param($stmt, "ii", $filterData["room_id"], $f);
                mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
        }else{
            $flag = 0;
            die("Query cannot be Prepared - Insert");
        }
        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }
?>