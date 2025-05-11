<?php
    require_once("../admin/include/connect.php");
    require_once("../admin/include/essential.php");

    if (isset($_GET["email-confirmation"])) {
        $filter_data = filteration($_GET);

        $query = "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1";
        $values = [$filter_data["email"], $filter_data["token"]];
        $result = select($query, $values, "ss");

        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_assoc($result);

            if ($fetch["is_verified"] == 1) {
                echo "
                    <script>
                        alert('Email already verified!');
                    </script>
                ";
                
                redirect("".SITE_URL."index.php");
            } else {
                $update_query = "UPDATE `user_cred` SET `is_verified`=? WHERE `id`=?";
                $update_values = [1, $fetch["id"]];
                $update_result = update($update_query, $update_values, "ii");

                if ($update_result) {
                    echo "
                        <script>
                            alert('Email verification successful.');
                        </script>
                    ";
                } else {
                    echo "
                    <script>
                    alert('Email verification failed due to some internal server error!');
                    </script>
                    ";
                }

                redirect("".SITE_URL."index.php");
            }
        } else {
            echo "
                <script>
                    alert('Invalid link address!');
                </script>
            ";
        }
    }
?>