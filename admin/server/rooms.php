<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["add-room"])) {
        $flag = 0;
        $features = filteration(json_decode($_POST["features"]));
        $facilities = filteration(json_decode($_POST["facilities"]));
        $filter_data = filteration($_POST);

        $query = "INSERT INTO `rooms` (`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = [$filter_data["name"], $filter_data["area"], $filter_data["price"], $filter_data["quantity"], $filter_data["adult"], $filter_data["children"], $filter_data["desc"]];

        if (insert($query, $values, "siiiiis")) {
            $flag = 1;
        }

        $room_id = mysqli_insert_id($connect);
        $facilities_query = "INSERT INTO `room_facilities` (`room_id`, `facilities_id`) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($connect, $facilities_query)) {
            foreach ($facilities as $f) {
                mysqli_stmt_bind_param($stmt, "ii", $room_id, $f);
                mysqli_stmt_execute($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die("Query cannot be executed!");
        }

        $features_query = "INSERT INTO `room_features` (`room_id`, `features_id`) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($connect, $features_query)) {
            foreach ($features as $f) {
                mysqli_stmt_bind_param($stmt, "ii", $room_id, $f);
                mysqli_stmt_execute($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die("Query cannot be executed!");
        }

        if ($flag) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["get-all-rooms"])) {
        $i = 1;
        $data = "";

        $query = "SELECT * FROM `rooms` WHERE `removed`=?";
        $values = [0];
        $result = select($query, $values, "i");

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["status"] == 1) {
                $status = "
                    <button class='btn btn-sm btn-success shadow-none' onclick='toggleStatus($row[id], 0)'>active</button>
                ";
            }else {
                $status = "
                    <button class='btn btn-sm btn-warning shadow-none' onclick='toggleStatus($row[id], 1)'>inactive</button>
                ";
            }

            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[area] sqft.</td>
                    <td>
                        <span class='badge rounded-pill bg-light text-dark'>Adult: $row[adult]</span><br/>
                        <span class='badge rounded-pill bg-light text-dark'>Children: $row[children]</span>
                    </td>
                    <td>₹$row[price]</td>
                    <td>$row[quantity]</td>
                    <td>$status</td>
                    <td>
                        <button type='button' class='btn btn-sm btn-dark shadow-none' onclick='editDetails($row[id])' data-bs-toggle='modal' data-bs-target='#edit-room'>
                            <i class='bi bi-pencil-square'></i>
                        </button>
                        <button type='button' class='btn btn-sm custom-background text-white shadow-none' onclick=\"roomImages($row[id], '$row[name]')\" data-bs-toggle='modal' data-bs-target='#room-image'>
                            <i class='bi bi-images'></i>
                        </button>
                        <button type='button' class='btn btn-sm btn-danger shadow-none' onclick='removeRoom($row[id])'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if (isset($_POST["toggle-status"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
        $values = [$filter_data["value"], $filter_data["toggle-status"]];
        $result = update($query, $values, "ii");

        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["get-room"])) {
        $features = [];
        $facilities = [];
        $filter_data = filteration($_POST);

        $query_one = "SELECT * FROM `rooms` WHERE `id`=?";
        $values_one = [$filter_data["get-room"]];
        $result_one = select($query_one, $values_one, "i");

        $query_two = "SELECT * FROM `room_features` WHERE `room_id`=?";
        $values_two = [$filter_data["get-room"]];
        $result_two = select($query_two, $values_two, "i");

        $query_three = "SELECT * FROM `room_facilities` WHERE `room_id`=?";
        $values_three = [$filter_data["get-room"]];
        $result_three = select($query_three, $values_three, "i");

        $room_data = mysqli_fetch_assoc($result_one);

        if (mysqli_num_rows($result_two) > 0) {
            while ($row = mysqli_fetch_assoc($result_two)) {
                array_push($features, $row["features_id"]);
            }
        }

        if (mysqli_num_rows($result_three) > 0) {
            while ($row = mysqli_fetch_assoc($result_three)) {
                array_push($facilities, $row["facilities_id"]);
            }
        }

        $data = ["room_data" => $room_data, "features" => $features, "facilities" => $facilities];
        $data = json_encode($data);
        echo $data;
    }

    if (isset($_POST["edit-room"])) {
        $flag = 0;
        $features = filteration(json_decode($_POST["features"]));
        $facilities = filteration(json_decode($_POST["facilities"]));
        $filter_data = filteration($_POST);

        $query_one = "UPDATE `rooms` SET `name`=?, `area`=?, `price`=?, `quantity`=?, `adult`=?, `children`=?, `description`=? WHERE `id`=?";
        $values_one = [$filter_data["name"], $filter_data["area"], $filter_data["price"], $filter_data["quantity"], $filter_data["adult"], $filter_data["children"], $filter_data["desc"], $filter_data["room-id"]];

        if (update($query_one, $values_one, "siiiiisi")) {
            $flag = 1;
        }

        $features_query = "DELETE FROM `room_features` WHERE `room_id`=?";
        $features_values = [$filter_data["room-id"]];
        $delete_features = delete($features_query, $features_values, "i");

        $facilities_query = "DELETE FROM `room_facilities` WHERE `room_id`=?";
        $facilities_values = [$filter_data["room-id"]];
        $delete_facilities = delete($facilities_query, $facilities_values, "i");

        if (!($delete_features && $delete_facilities)) {
            $flag = 0;
        }

        $facilities_query = "INSERT INTO `room_facilities` (`room_id`, `facilities_id`) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($connect, $facilities_query)) {
            foreach ($facilities as $f) {
                mysqli_stmt_bind_param($stmt, "ii", $filter_data["room-id"], $f);
                mysqli_stmt_execute($stmt);
            }

            $flag = 1;
            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die("Query cannot be executed!");
        }

        $features_query = "INSERT INTO `room_features` (`room_id`, `features_id`) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($connect, $features_query)) {
            foreach ($features as $f) {
                mysqli_stmt_bind_param($stmt, "ii", $filter_data["room-id"], $f);
                mysqli_stmt_execute($stmt);
            }

            $flag = 1;
            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die("Query cannot be executed!");
        }

        if ($flag) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["upload-image"])) {
        $filter_data = filteration($_POST);
        $result = uploadImage($_FILES["image"], ROOM_FOLDER);

        if (in_array($result, ["invalid-image", "invalid-size", "upload-failed"])) {
            echo $result;
        } else {
            $query = "INSERT INTO `room_image` (`room_id`, `image`) VALUES (?, ?)";
            $values = [$filter_data["room-id"], $result];
            $output = insert($query, $values, "is");
            echo $output;
        }
    }

    if (isset($_POST["get-room-images"])) {
        $filter_data = filteration($_POST);

        $query = "SELECT * FROM `room_image` WHERE `room_id`=?";
        $values = [$filter_data["get-room-images"]];
        $result = select($query, $values, "i");
        $path = ROOM_IMAGE_PATH;

        while ($data = mysqli_fetch_assoc($result)) {
            
            if ($data["thumbnail"] == 1) {
                $thumbnail_button = "
                    <i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>
                ";
            } else {
                $thumbnail_button = "
                    <button class='btn btn-sm btn-secondary shadow-none' onclick='thumbnailImage($data[sr_no], $data[room_id])'>
                        <i class='bi bi-check-lg'></i>
                    </button>
                ";
            }

            echo<<<data
                <tr class="align-middle">
                    <td>
                        <img src="$path$data[image]" alt="$data[image] class="img-fluid" width="100%"/>
                    </td>
                    <td>$thumbnail_button</td>
                    <td>
                        <button class="btn btn-sm btn-danger shadow-none" onclick="removeImage($data[sr_no], $data[room_id])">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            data;
        }
    }

    if (isset($_POST["remove-image"])) {
        $filter_data = filteration($_POST);
        
        $pre_query = "SELECT * FROM `room_image` WHERE `sr_no`=? AND `room_id`=?";
        $values = [$filter_data["image-id"], $filter_data["room-id"]];
        $result = select($pre_query, $values, "ii");
        $image = mysqli_fetch_assoc($result);

        if (deleteImage($image["image"], ROOM_FOLDER)) {
            $query = "DELETE FROM `room_image` WHERE `sr_no`=? AND `room_id`=?";
            $result = delete($query, $values, "ii");
            echo $result;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["thumbnail-image"])) {
        $filter_data = filteration($_POST);
        
        $pre_query = "UPDATE `room_image` SET `thumbnail`=? WHERE `room_id`=?";
        $values = [0, $filter_data["room-id"]];
        $result = update($pre_query, $values, "ii");

        $query = "UPDATE `room_image` SET `thumbnail`=? WHERE `sr_no`=? AND `room_id`=?";
        $values = [1, $filter_data["image-id"], $filter_data["room-id"]];
        $result = update($query, $values, "iii");

        echo $result;
    }

    if (isset($_POST["remove-room"])) {
        $filter_data = filteration($_POST);
        
        $query_one = "SELECT * FROM `room_image` WHERE `room_id`=?";
        $values_one = [$filter_data["room-id"]];
        $result_one = select($query_one, $values_one, "i");

        while ($row = mysqli_fetch_assoc($result_one)) {
            deleteImage($row["image"], ROOM_FOLDER);
        }

        $query_two = "DELETE FROM `room_image` WHERE `room_id`=?";
        $values_two = [$filter_data["room-id"]];
        $result_two = delete($query_two, $values_two, "i");

        $query_three = "DELETE FROM `room_features` WHERE `room_id`=?";
        $values_three = [$filter_data["room-id"]];
        $result_three = delete($query_three, $values_three, "i");

        $query_four = "DELETE FROM `room_facilities` WHERE `room_id`=?";
        $values_four = [$filter_data["room-id"]];
        $result_four = delete($query_four, $values_four, "i");
        
        $query_five = "UPDATE `rooms` SET `removed`=? WHERE `id`=?";
        $values_five = [1, $filter_data["room-id"]];
        $result_five = update($query_five, $values_five, "ii");

        if ($result_two || $result_three || $result_four || $result_five) {
            echo 1;
        } else {
            echo 0;
        }
    }
?>