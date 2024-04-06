<?php
    require("admin/include/connect.php");
    require("admin/include/essential.php");
    require("include/paytm/config_paytm.php");
    require("include/paytm/encdec_paytm.php");
    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if(!(isset($_SESSION["login"]) && $_SESSION["login"] == true)){
        redirect("index.php");
    }
    if(isset($_POST["paynow"])){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $ORDER_ID = "ORD_".$_SESSION["userid"].random_int(11111, 9999999);
        $CUST_ID = $_SESSION["userid"];
        $INDUSTRY_TYPE_ID = INDUSTRY_TYPE_ID;
        $CHANNEL_ID = CHANNEL_ID;
        $TXN_AMOUNT = $_SESSION["room"]["payment"];
        $paramList = array();
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
        $paramList["CALLBACK_URL"] = CALLBACK_URL;
    	//Here checksum string will return by getChecksumFromArray() function.
    	$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
        // Insert Payment Data into Database
        $filterData = filteration($_POST);
        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `checkin`, `checkout`, `order_id`) VALUES (?, ?, ?, ?, ?)";
        insert($query1, [$CUST_ID, $_SESSION["room"]["id"], $filterData["checkin"], $filterData["checkout"], $ORDER_ID], "issss");
        $bookingId = mysqli_insert_id($connect);
        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `username`, `phone`, `address`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        insert($query2, [$bookingId, $_SESSION["room"]["name"], $_SESSION["room"]["price"], $TXN_AMOUNT, $filterData["name"], $filterData["phone"], $filterData["address"]], "issssss");
    }
?>
<html>
    <head>
        <title>Payment Processing...</title>
    </head>
    <body>
        <center><h1>Please do not refresh this page...</h1></center>
        <form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
            <?php
                foreach($paramList as $name => $value) {
                    echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                }
            ?>
            <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
        </form>
        <script type="text/javascript">
            document.f1.submit();
        </script>
    </body>
</html>