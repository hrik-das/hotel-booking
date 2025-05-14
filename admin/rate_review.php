<?php
    require_once("./include/connect.php");
    require_once("./include/essential.php");
    adminLogin();

    if (isset($_GET["seen"])) {
        $filter_data = filteration($_GET);

        if ($filter_data["seen"] == "all") {
            $query = "UPDATE `rating_review` SET `seen`=?";
            $values = [1];

            if (update($query, $values, "i")) {
                alert("success", "All messages marked as read.");
            } else {
                alert("error", "Couldn't marked the messages as read!");
            }
        } else {
            $query = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
            $values = [1, $filter_data["seen"]];

            if (update($query, $values, "ii")) {
                alert("success", "Message marked as read.");
            } else {
                alert("error", "Couldn't marked the message as read!");
            }
        }
    }

    if (isset($_GET["delete"])) {
        $filter_data = filteration($_GET);

        if ($filter_data["delete"] == "all") {
            $query = "DELETE FROM `rating_review`";

            if (mysqli_query($connect, $query)) {
                alert("success", "All messages deleted.");
            } else {
                alert("error", "Couldn't delete the messages!");
            }
        } else {
            $query = "DELETE FROM `rating_review` WHERE `sr_no`=?";
            $values = [$filter_data["delete"]];

            if (delete($query, $values, "i")) {
                alert("success", "Message deleted.");
            } else {
                alert("error", "Couldn't delete the message!");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("./include/include.php"); ?>
    <title>Rating & Review - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Ratings & Reviews</h3>

                <!-- Ratings & Reviews Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark btn-sm shadow-none">
                                <i class="bi bi-check-all"></i> Mark all read
                            </a>
                            <a href="?delete=all" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash-fill"></i> Delete All
                            </a>
                        </div>

                        <div class="table-responsive-md">
                            <table class="table table-striped table-hover border">
                                <thead>
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col" width="30%">Review</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        $query = "SELECT rr.*, uc.username, room.name AS room_name FROM `rating_review` rr INNER JOIN `user_cred` uc ON rr.user_id=uc.id INNER JOIN `rooms` room ON rr.room_id=room.id ORDER BY `sr_no` DESC";
                                        $result = mysqli_query($connect, $query);

                                        while ($data = mysqli_fetch_assoc($result)) {
                                            $seen = "";
                                            $date = date("d-m-Y", strtotime($data["date_time"]));

                                            if ($data["seen"] != 1) {
                                                $seen = "
                                                    <a href='?seen=$data[sr_no]' class='btn btn-sm btn-outline-primary rounded-pill mb-2'>
                                                        <i class='bi bi-check-all'></i> mark as read
                                                    </a><br/>
                                                ";
                                            }

                                            $seen .= "
                                                <a href='?delete=$data[sr_no]' class='btn btn-sm btn-outline-danger me-2 rounded-pill'>
                                                    <i class='bi bi-trash-fill'></i> delete
                                                </a>
                                            ";

                                            echo<<<data
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$data[username]</td>
                                                    <td>$data[room_name]</td>
                                                    <td>$data[rating]</td>
                                                    <td>$data[review]</td>
                                                    <td>$date</td>
                                                    <td>$seen</td>
                                                </tr>
                                            data;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>