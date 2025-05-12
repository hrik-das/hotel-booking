<?php
    require_once("admin/include/connect.php");
    require_once("admin/include/essential.php");

    require_once("include/paytm/config_paytm.php");
    require_once("include/paytm/encdec_paytm.php");

    date_default_timezone_set("Asia/Kolkata");
    session_start();
    unset($_SESSION["room"]);

    function regenerateSession($id) {
        $user_query = "SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1";
        $user_values = [$id];
        $user_result = select($user_query, $user_values, "i");
        $user_fetch = mysqli_fetch_assoc($user_result);

        $_SESSION["login"] = true;
        $_SESSION["userid"] = $user_fetch["id"];
        $_SESSION["username"] = $user_fetch["username"];
        $_SESSION["userprofile"] = $user_fetch["profile"];
        $_SESSION["userphone"] = $user_fetch["phone"];
    }

    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");

    $paytmChecksum = "";
    $paramList = array();
    $isValidChecksum = "FALSE";

    $paramList = $_POST;
    $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
    //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
    $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

    if($isValidChecksum == "TRUE") {
        $select_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`='$_POST[ORDERID]'";
        $select_result = mysqli_query($connect, $select_query);

        if (mysqli_num_rows($select_result) == 0) {
            redirect("index.php");
        }

        $select_fetch = mysqli_fetch_assoc($select_result);

        if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
            // regenerate session
            regenerateSession($select_fetch["user_id"]);
        }

        if ($_POST["STATUS"] == "TXN_SUCCESS") {
            $update_query = "UPDATE `booking_order` SET `booking_status`='booked', `transaction_id`='$_POST[TXNID]',`transaction_amount`='$_POST[TXNAMOUNT]', `transaction_status`='$_POST[STATUS]', `transaction_response`='$_POST[RESPMSG]' WHERE `booking_id`='$select_fetch[booking_id]'";

            mysqli_query($connect, $update_query);
        } else {
            $update_query = "UPDATE `booking_order` SET `booking_status`='failed', `transaction_id`='$_POST[TXNID]',`transaction_amount`='$_POST[TXNAMOUNT]', `transaction_status`='$_POST[STATUS]', `transaction_response`='$_POST[RESPMSG]' WHERE `booking_id`='$select_fetch[booking_id]'";

            mysqli_query($connect, $update_query);
        }
        redirect("payment_status.php?order=".$_POST["ORDERID"]);
    } else {
        redirect("index.php");
    }
?>