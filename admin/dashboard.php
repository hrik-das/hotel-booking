<?php
    require("include/essential.php");
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("include/links.php"); ?>
    <title>Admin Panel - Dashboard</title>
</head>
<body class="bg-light">
    <div class="container-fluid bg-dark p-3 text-light d-flex align-items-center justify-content-between">
        <h3 class="mb-0">Admin Panel</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>
</body>
</html>