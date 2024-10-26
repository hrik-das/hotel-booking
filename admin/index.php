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
    <div class="error"></div>
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form action="" method="post">
            <h4 class="bg-dark text-white py-3">Admin Login Panel</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control shadow-none text-center" placeholder="Admin Name" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control shadow-none text-center" placeholder="Admin Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-sm text-white custom-background shadow-none">LOGIN</button>
            </div>
        </form>
    </div>

    <?php
        if (isset($_POST["login"])) {
            $filterData = filteration($_POST);

            $query = "SELECT * FROM `admin_cred` WHERE `username`=? AND `password`=?";
            $values = [$filterData["username"], $filterData["password"]];

            $result = select($query, $values, "ss");

            if ($result->num_rows == 1) {
                $data = mysqli_fetch_assoc($result);
                $_SESSION["adminLogin"] = true;
                $_SESSION["adminId"] = $data["id"];
                redirect("dashboard.php");
            } else {
                echo "
                    <script>
                        let error = document.querySelector('.error');
                        error.style.display = 'block';
                        error.innerText = 'Login Failed - Invalid Credentials!';
                        setTimeout(() => error.style.display = 'none', 5000);
                    </script>
                ";
            }
        }
    ?>
</body>
</html>