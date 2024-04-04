<?php
    require("./include/essential.php");
    require("./include/connect.php");
    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("./include/links.php"); ?>
    <script src="./js/script.js" defer></script>
    <script src="./js/users.js" defer></script>
    <title>Admin Panel - Users</title>
</head>
<body class="bg-light">
    <?php require("./include/header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Users</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="searchUser(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search User">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover border text-center" style="width: 1300px;">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Date of Birth</th>
                                        <th scope="col">Verified</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="user-data"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>