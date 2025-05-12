<?php
    require_once("admin/include/connect.php");
    require_once("admin/include/essential.php");

    require_once("include/paytm/config_paytm.php");
    require_once("include/paytm/encdec_paytm.php");

    date_default_timezone_set("Asia/Kolkata");
    session_start();

    if (!(isset($_SESSION["login"]) && $_SESSION["login"] == true)) {
        redirect("rooms.php");
    }

    if (isset($_POST["payment"])) {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $checkSum = "";

        $ORDER_ID = "ORD_".$_SESSION["userid"].random_int(11111, 99999999);
        $CUST_ID = $_SESSION["userid"];
        $INDUSTRY_TYPE_ID = INDUSTRY_TYPE_ID;
        $CHANNEL_ID = CHANNEL_ID;
        $TXN_AMOUNT = $_SESSION["room"]["payment"];


        // create an array having all required parameters for creating checksum.
        $paramList = array();
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
        $paramList["CALLBACK_URL"] = CALLBACK_URL;

        // here checksum string will return by getCheckSumFromArray() function
        $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

        // Insert payment data into server (database)
        $filter_data = filteration($_POST);
        
        $query_one = "INSERT INTO `booking_order` (`user_id`, `room_id`, `check_in`, `check_out`, `order_id`) VALUES (?, ?, ?, ?, ?)";
        $values_one = [$CUST_ID, $_SESSION["room"]["id"], $filter_data["checkin"], $filter_data["checkout"], $ORDER_ID];
        $result_one = insert($query_one, $values_one, "issss");

        $booking_id = mysqli_insert_id($connect);

        $query_two = "INSERT INTO `booking_details` (`booking_id`, `room_name`, `price`, `total_payment`, `username`, `phone`, `email`, `address`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $values_two = [$booking_id, $_SESSION["room"]["name"], $_SESSION["room"]["price"], $TXN_AMOUNT, $filter_data["name"], $filter_data["phone"], $filter_data["email"], $filter_data["address"]];
        $result_two = insert($query_two, $values_two, "isssssss");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing payment</title>
</head>
<body>
    <h1>please do not refresh this page...</h1>

    <?php if (isset($_POST["payment"])): ?>
        <form action="<?php echo PAYTM_TXN_URL; ?>" methoD="post" name="f1">
            <?php
                foreach ($paramList as $name => $value) {
                    echo "<input type='hidden' name='".$name."' value='".$value."'>";
                }
            ?>

            <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum; ?>">
        </form>

        <script type="text/javascript">
            document.f1.submit();
        </script>
    <?php endif; ?>
</body>
</html>