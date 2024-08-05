<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["getUsers"])) {
        $i = 1;
        $data = "";
        $path = USER_IMG_PATH;
        $result = selectAll("user_cred");
        while ($row = mysqli_fetch_assoc($result)) {
            $deleteButton = "<button type='button' onclick='removeUser($row[id])' class='btn btn-danger shadow-none btn-sm'>
                                 <i class='bi bi-trash'></i>
                             </button>";
            $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
            if ($row["is_verified"]) {
                $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
                $deleteButton = "";
            }
            $status = "<button onclick='toggleStatus($row[id], 0)' class='btn btn-outline-success btn-sm shadow-none'>Active</button>";
            if (!$row["status"]) {
                $status = "<button onclick='toggleStatus($row[id], 1)' class='btn btn-outline-danger btn-sm shadow-none'>Inactive</button>";
            }
            $date = date("d-m-Y", strtotime($row["date_time"]));
            $data .= "
                <tr>
                    <td>$i</td>
                    <td>
                        <img src='$path$row[profile]' alt='profile' width='55px'/><br/>
                        $row[name]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[phone]</td>
                    <td>$row[address] | $row[pincode]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$deleteButton</td>
                </tr>";
            $i++;
        }
        echo $data;
    }

    if (isset($_POST["toggleStatus"])) {
        $filterData = filteration($_POST);
        $query = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
        $values = [$filterData["value"], $filterData["toggleStatus"]];
        if (executeCrud("update", $query, $values, "ii")) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["removeUser"])) {
        $filterData = filteration($_POST);
        $result = executeCrud("delete", "DELETE FROM `user_cred` WHERE `id`=? AND `is_verified`=?", [$filterData["user_id"], 0], "ii");
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if (isset($_POST["searchUser"])) {
        $filterData = filteration($_POST);
        $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";
        $values = ["%$filterData[username]%"];
        $result = executeCrud("select", $query, $values, "s");
        $i = 1;
        $path = USER_IMG_PATH;
        $data = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $deleteButton = "<button type='button' onclick='removeUser($row[id])' class='btn btn-danger shadow-none btn-sm'>
                                 <i class='bi bi-trash'></i>
                             </button>";
            $verified = "<span class='badge bg-danger'><i class='bi bi-x-lg'></i></span>";
            if ($row["is_verified"]) {
                $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
                $deleteButton = "";
            }
            $status = "<button onclick='toggleStatus($row[id], 0)' class='btn btn-outline-success btn-sm shadow-none'>Active</button>";
            if (!$row["status"]) {
                $status = "<button onclick='toggleStatus($row[id], 1)' class='btn btn-outline-danger btn-sm shadow-none'>Inactive</button>";
            }
            $date = date("d-m-Y", strtotime($row["date_time"]));
            $data .= "
                <tr>
                    <td>$i</td>
                    <td>
                        <img src='$path$row[profile]' width='55px' alt=''/><br/>
                        $row[name]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[phone]</td>
                    <td>$row[address] | $row[pincode]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$deleteButton</td>
                </tr>";
            $i++;
        }
        echo $data;
    }
?>