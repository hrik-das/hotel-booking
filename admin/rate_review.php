<?php
    require("./include/essential.php");
    require("./include/connect.php");
    adminLogin();
    if(isset($_GET["seen"])){
        $filterData = filteration($_GET);
        if($filterData["seen"] == "all"){
            $query = "UPDATE `rating_review` SET `seen`=?";
            $values = [1];
            if(update($query, $values, "i")){
                alert("success", "Marked All as Read!");
            }else{
                alert("error", "Operation Failed!");
            }
        }else{
            $query = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
            $values = [1, $filterData["seen"]];
            if(update($query, $values, "ii")){
                alert("success", "Marked as Read!");
            }else{
                alert("error", "Operation Failed!");
            }
        }
    }
    if(isset($_GET["delete"])){
        $filterData = filteration($_GET);
        if($filterData["delete"] == "all"){
            $query = "DELETE FROM `rating_review`";
            if(mysqli_query($connect, $query)){
                alert("success", "All Deleted Successfully!");
            }else{
                alert("error", "Operation Failed!");
            }
        }else{
            $query = "DELETE FROM `rating_review` WHERE `sr_no`=?";
            $values = [$filterData["delete"]];
            if(delete($query, $values, "i")){
                alert("success", "Deleted Successfully!");
            }else{
                alert("error", "Operation Failed!");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <title>Admin Panel - Rate and Review</title>
</head>
<body class="bg-light">
    <?php require("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Rate and Review</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-sm btn-dark rounded-pill shadow-none me-2">
                                <i class="bi bi-check-all"></i> Mark all Read
                            </a>
                            <a href="?delete=all" class="btn btn-sm btn-danger rounded-pill shadow-none">
                                <i class="bi bi-trash"></i> Delete All
                            </a>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-hover border">
                                <thead class="sticky-top text-center">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col" width="30%">Review</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = "SELECT rr.*, uc.name AS username, r.name AS roomname FROM `rating_review` rr INNER JOIN `user_cred` uc ON rr.user_id = uc.id INNER JOIN `rooms` r ON rr.room_id = r.id ORDER BY `sr_no` DESC";
                                        $result = mysqli_query($connect, $query);
                                        $i = 1;
                                        while($data = mysqli_fetch_assoc($result)){
                                            $seen = "";
                                            $date = date("d-m-Y", strtotime($data["dateTime"]));
                                            if($data["seen"] != 1){
                                                $seen = "<a href='?seen=$data[sr_no]' class='btn btn-sm rounded-pill btn-primary me-2'>Read</a>";
                                            }
                                            $seen .= "<a href='?delete=$data[sr_no]' class='btn btn-sm rounded-pill btn-danger'>Delete</a>";
                                            echo<<<data
                                                <tr class='text-center'>
                                                    <td>$i</td>
                                                    <td>$data[roomname]</td>
                                                    <td>$data[username]</td>
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