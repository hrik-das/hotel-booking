<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["get-all-users"])) {
        $i = 1;
        $data = "";
        $path = USERS_IMAGE_PATH;
        $result = selectAllData("user_cred");

        while ($row = mysqli_fetch_assoc($result)) {
            $verified = "
                <span class='badge bg-danger'>
                    <i class='bi bi-x-lg'></i>
                </span>
            ";

            $delete_button = "
                <button type='button' class='btn btn-sm btn-danger shadow-none' onclick='removeUser($row[id])'>
                    <i class='bi bi-trash'></i>
                </button>
            ";

            if ($row["is_verified"]) {
                $verified = "
                    <span class='badge bg-success'>
                        <i class='bi bi-check-lg'></i>
                    </span>
                ";
                $delete_button = "";
            }

            $status = "
                <button type='button' onclick='toggleStatus($row[id], 0)' class='btn btn-dark btn-sm shadow-none'>active</button>
            ";

            if (!$row["status"]) {
                $status = "
                    <button type='button' onclick='toggleStatus($row[id], 1)' class='btn btn-danger btn-sm shadow-none'>blocked</button>
                ";
            }

            $date = date("d-m-Y", strtotime($row["date_time"]));

            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>
                        <img src='$path$row[profile]' alt='$row[profile]' width='50px' class='rounded'/><br/>
                        $row[username]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[phone]</td>
                    <td>$row[address] | $row[pincode]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$delete_button</td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if (isset($_POST["toggle-status"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
        $values = [$filter_data["value"], $filter_data["toggle-status"]];
        $result = update($query, $values, "ii");

        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["remove-user"])) {
        $filter_data = filteration($_POST);

        $query_one = "SELECT `profile` FROM `user_cred` WHERE `id`=?";
        $values_one = [$filter_data["user-id"]];
        $result_one = select($query_one, $values_one, "i");
        $image = mysqli_fetch_assoc($result_one);

        if (deleteImage($image["profile"], USER_FOLDER)) {
            $query_two = "DELETE FROM `user_cred` WHERE `id`=?  AND `is_verified`=?";
            $values_two = [$filter_data["user-id"], 0];
            $result_two = delete($query_two, $values_two, "ii");
            echo $result_two;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["search-user"])) {
        $i = 1;
        $data = "";
        $path = USERS_IMAGE_PATH;
        $filter_data = filteration($_POST);

        $query = "SELECT * FROM `user_cred` WHERE `username` LIKE ?";
        $values = ["%$filter_data[username]%"];
        $result = select($query, $values, "s");

        while ($row = mysqli_fetch_assoc($result)) {
            $verified = "
                <span class='badge bg-danger'>
                    <i class='bi bi-x-lg'></i>
                </span>
            ";

            $delete_button = "
                <button type='button' class='btn btn-sm btn-danger shadow-none' onclick='removeUser($row[id])'>
                    <i class='bi bi-trash'></i>
                </button>
            ";

            if ($row["is_verified"]) {
                $verified = "
                    <span class='badge bg-success'>
                        <i class='bi bi-check-lg'></i>
                    </span>
                ";
                $delete_button = "";
            }

            $status = "
                <button type='button' onclick='toggleStatus($row[id], 0)' class='btn btn-dark btn-sm shadow-none'>active</button>
            ";

            if (!$row["status"]) {
                $status = "
                    <button type='button' onclick='toggleStatus($row[id], 1)' class='btn btn-danger btn-sm shadow-none'>blocked</button>
                ";
            }

            $date = date("d-m-Y", strtotime($row["date_time"]));

            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>
                        <img src='$path$row[profile]' alt='$row[profile]' width='50px' class='rounded'/><br/>
                        $row[username]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[phone]</td>
                    <td>$row[address] | $row[pincode]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$delete_button</td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }
?>