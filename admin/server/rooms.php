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
        $result = selectAllData("rooms");

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
?>