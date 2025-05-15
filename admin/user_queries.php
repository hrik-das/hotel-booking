<?php
    require_once("./include/connect.php");
    require_once("./include/essential.php");
    adminLogin();

    if (isset($_GET["seen"])) {
        $filter_data = filteration($_GET);

        if ($filter_data["seen"] == "all") {
            $query = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];

            if (update($query, $values, "i")) {
                alert("success", "All messages marked as read.");
            } else {
                alert("error", "Couldn't marked the messages as read!");
            }
        } else {
            $query = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
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
            $query = "DELETE FROM `user_queries`";

            if (mysqli_query($connect, $query)) {
                alert("success", "All messages deleted.");
            } else {
                alert("error", "Couldn't delete the messages!");
            }
        } else {
            $query = "DELETE FROM `user_queries` WHERE `sr_no`=?";
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
    <title>User Queries - Admin Panel</title>
</head>
<body class="bg-light">
    <?php require_once("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">User Queries</h3>

                <!-- User Queries Section -->
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

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-striped table-hover border">
                                <thead class="sticky-top">
                                    <tr class="table-dark text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="20%">Subject</th>
                                        <th scope="col" width="25%">Message</th>
                                        <th scope="col" width="10%">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        $query = "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                                        $result = mysqli_query($connect, $query);

                                        while ($data = mysqli_fetch_assoc($result)) {
                                            $seen = "";
                                            $date = date("d-m-Y", strtotime($data["date_time"]));

                                            if ($data["seen"] != 1) {
                                                $seen = "
                                                    <a href='?seen=$data[sr_no]' class='btn btn-sm btn-outline-primary rounded-pill mb-2'>
                                                        <i class='bi bi-check-all'></i> mark as read
                                                    </a>
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
                                                    <td>$data[name]</td>
                                                    <td>$data[email]</td>
                                                    <td>$data[subject]</td>
                                                    <td>$data[message]</td>
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