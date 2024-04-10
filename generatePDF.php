<?php
    require("./admin/include/connect.php");
    require("./admin/include/essential.php");
    require("./admin/include/mpdf/vendor/autoload.php");    // Require composer autoload
    session_start();
    if(!(isset($_SESSION["login"]) || $_SESSION["login"] == true)){
        redirect("index.php");
    }

    if(isset($_GET["generatepdf"]) && isset($_GET["id"])){
        $filterData = filteration($_GET);
        $query = "SELECT bo.*, bd.*, uc.email FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id INNER JOIN `user_cred` uc ON bo.user_id = uc.id WHERE ((bo.booking_status='booked' AND bo.arrival=1) OR (bo.booking_status='cancelled' AND bo.refund=1) OR (bo.booking_status='payment failed')) AND bo.booking_id='$filterData[id]'";
        $result = mysqli_query($connect, $query);
        $totalRows = mysqli_num_rows($result);
        if($totalRows == 0){
            header("Location: index.php");
        }
        $data = mysqli_fetch_assoc($result);
        $date = date("h:iA | d-m-Y", strtotime($data["dateTime"]));
        $checkin = date("d-m-Y", strtotime($data["checkin"]));
        $checkout = date("d-m-Y", strtotime($data["checkout"]));
        $tableData = "
            <h2>Booking Recipt</h2>
            <table border='1'>
                <tr>
                    <td>Order ID: $data[order_id]</td>
                    <td>Booking Date: $date</td>
                </tr>
                <tr>
                    <td colspan='2'>Status: $data[booking_status]</td>
                </tr>
                <tr>
                    <td>Username: $data[username]</td>
                    <td>Email Address: $data[email]</td>
                </tr>
                <tr>
                    <td>Phone Number: $data[phone]</td>
                    <td>Location: $data[address]</td>
                </tr>
                <tr>
                    <td>Room Name: $data[room_name]</td>
                    <td>Cost: ₹$data[price] Per Night</td>
                </tr>
                <tr>
                    <td>Check In: $checkin</td>
                    <td>Check Out: $checkout</td>
                </tr>";
        if($data["booking_status"] == "cancelled"){
            $refund = ($data["refund"]) ? "Amount Refunded" : "Not Refunded Yet";
            $tableData .= "
            <tr>
                <td>Amount Paid: ₹$data[transaction_amount]</td>
                <td>Refund: $refund</td>
            </tr>";
        }else if($data["booking_status"] == "payment failed"){
            $refund = ($data["refund"]) ? "Amount Refunded" : "Not Refunded Yet";
            $tableData .= "
            <tr>
                <td>Transaction Amount: ₹$data[transaction_amount]</td>
                <td>Failure Response: $data[response_message]</td>
            </tr>";
        }else{
            $refund = ($data["refund"]) ? "Amount Refunded" : "Not Refunded Yet";
            $tableData .= "
            <tr>
                <td>Room Number: $data[room_no]</td>
                <td>Amount Paid: ₹$data[transaction_amount]</td>
            </tr>";
        }
        $tableData .= "</table>";

        $mpdf = new \Mpdf\Mpdf();    // Create an instance of the class
        $mpdf->WriteHTML($tableData);    // Write some HTML code
        $mpdf->Output($data["order_id"].".pdf", "D");    // Output a PDF file directly to the browser
        // "D" send to the browser and force a file download with the name given by $filename. This parameter sets HTTP headers using standard header PHP function.
    }else{
        header("Location: index.php");
    }
?>