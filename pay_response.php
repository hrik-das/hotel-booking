<?php
    require("admin/include/database.php");
    require("admin/include/essentials.php");
    require("include/paytm/config_paytm.php");
    require("include/paytm/encdec_paytm.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();
    unset($_SESSION["room"]);
    function regenerate_session($userId){
        $userQuery = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$userId], "i");
        $userFetch = mysqli_fetch_assoc($userQuery);
        $_SESSION["login"] = true;
        $_SESSION["userid"] = $userFetch["id"];
        $_SESSION["username"] = $userFetch["name"];
        $_SESSION["userpic"] = $userFetch["profile"];
        $_SESSION["userphone"] = $userFetch["phone"];
    }
    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");
    $paytmChecksum = "";
    $paramList = array();
    $isValidChecksum = "FALSE";
    $paramList = $_POST;
    $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
    $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);
    if($isValidChecksum == "TRUE"){
        $selectQuery = "SELECT `booking_id` FROM `booking_order` WHERE `order_id`='$_POST[ORDERID]'";
        $selectResult = mysqli_query($connect, $selectQuery);
        if(mysqli_num_rows($selectResult) == 0){
            redirect("index.php");
        }
        $selectFetch = mysqli_fetch_assoc($selectResult);
        if(!(isset($_SESSION["login"]) && $_SESSION["login"] == true)){
            regenerate_session($selectFetch["user_id"]);
        }
        if($_POST["STATUS"] == "TXN_SUCCESS"){
            $updateQuery = "UPDATE `booking_order` SET `booking_status`='booked', `transaction_id`='$_POST[TXNID]',`transaction_amount`='$_POST[TXNAMOUNT]', `transaction_status`='$_POST[STATUS]', `response_message`='$_POST[RESPMSG]' WHERE `booking_id`='$selectFetch[booking_id]'";
            mysqli_query($connect, $updateQuery);
        }else{
            $updateQuery = "UPDATE `booking_order` SET `booking_status`='payment failed', `transaction_id`='$_POST[TXNID]',`transaction_amount`='$_POST[TXNAMOUNT]',`transaction_status`='$_POST[STATUS]',`response_message`='$_POST[RESPMSG]' WHERE `booking_id`='$selectFetch[booking_id]'";
            mysqli_query($connect, $updateQuery);
        }
        redirect("pay_status.php?order=".$_POST["ORDERID"]);
    }else{
        redirect("index.php");
    }
?>