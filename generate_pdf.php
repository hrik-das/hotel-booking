<?php
    require_once("admin/include/connect.php");
    require_once("admin/include/essential.php");
    require_once("admin/include/mpdf/vendor/autoload.php");
    session_start();

    if (isset($_GET["generate-pdf"]) && isset($_GET["id"])) {
        $filter_data = filteration($_GET);

        $query = "SELECT book_order.*, book_detail.* FROM `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id WHERE 
        ((book_order.booking_status='booked' AND book_order.arrival=1) OR (book_order.booking_status='cancelled' AND book_order.refund=1) OR (book_order.booking_status='failed')) AND book_order.booking_id='$filter_data[id]'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 0) {
            header("Location: index.php");
        }

        $data = mysqli_fetch_assoc($result);
        $date = date("h:ia | d-m-Y", strtotime($data["date_time"]));
        $checkin = date("d-m-Y", strtotime($data["check_in"]));
        $checkout = date("d-m-Y", strtotime($data["check_out"]));

        $table_data = "
            <h2>Booking Recipt</h2>
            <table border='1'>
                <tr>
                    <td>Order ID: $data[order_id]</td>
                    <td>Booking Date: $date</td>
                </tr>
                <tr>
                    <td colspan='2'>Booking Status: $data[booking_status]</td>
                </tr>
                <tr>
                    <td>Username: $data[username]</td>
                    <td>Email Address: $data[email]</td>
                </tr>
                <tr>
                    <td>Phone Number: $data[phone]</td>
                    <td>Permanent Address: $data[address]</td>
                </tr>
                <tr>
                    <td>Room Name: $data[room_name]</td>
                    <td>Price: ₹$data[price] per night</td>
                </tr>
                <tr>
                    <td>Check-In Date: $checkin</td>
                    <td>Check-Out Date: $checkout</td>
                </tr>
        ";

        if ($data["booking_status"] == "cancelled") {
            $refund = ($data["refund"]) ? "Amount refunded" : "Not refunded yet";
            $table_data .= "
                <tr>
                    <td>Amount Paid: $data[transaction_amount]</td>
                    <td>Refund: $refund</td>
                </tr>
            ";
        } else if ($data["booking_status"] == "failed") {
            $table_data .= "
                <tr>
                    <td>Transaction Amount: $data[transaction_amount]</td>
                    <td>Transaction Response: $data[transaction_response]</td>
                </tr>
            ";
        } else {
            $table_data .= "
                <tr>
                    <td>Alloted Room Number: $data[room_no]</td>
                    <td>Amount Paid: $data[transaction_amount]</td>
                </tr>
            ";
        }
        $table_data .= "</table>";

        // create instance of the class
        $mpdf = new \Mpdf\Mpdf();
        // write some HTML code
        $mpdf -> WriteHTML($table_data);
        // Output a PDF file directly to the browser
        $mpdf -> Output($data["order_id"].".pdf", "D");
    } else {
        header("Location: index.php");
    }
?>