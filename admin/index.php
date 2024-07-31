<?php
    require_once("./include/connect.php");
    require_once("./include/essential.php");
    session_start();
    if ((isset($_SESSION["adminLogin"]) && $_SESSION["adminLogin"] == true)) {
        header("Location: dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <?php require_once("./include/include.php"); ?>
    <title>Admin Login Panel</title>
</head>
<body class="bg-light">
    <p class="error"></p>
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form action="index.php" method="post">
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input type="text" name="adminName" class="form-control shadow-none text-center" placeholder="Admin Name" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="adminPass" class="form-control shadow-none text-center" placeholder="Enter Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-sm text-white custom-background shadow-none">LOGIN</button>
            </div>
        </form>
    </div>

    <?php
        if (isset($_POST["login"])) {
            $filterData = filteration($_POST);
            $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
            $values = [$filterData["adminName"], $filterData["adminPass"]];
            $datatypes = "ss";    // "s" -> String Type
            $result = executeCrud("select", $query, $values, $datatypes);
            if ($result->num_rows == 1) {
                $data = mysqli_fetch_assoc($result);
                $_SESSION["adminLogin"] = true;
                $_SESSION["adminId"] = $data["sr_no"];
                redirect("dashboard.php");
            } else {
                // Display error message using JavaScript for invalid credentials
                echo "<script>
                          let error = document.querySelector('.error');
                          error.style.display = 'block';
                          error.innerText = 'Login Failed - Invalid Credentials!';
                          setTimeout(() => error.style.display = 'none', 3000);
                      </script>";
            }
        }
    ?>
</body>
</html>