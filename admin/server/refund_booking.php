<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["get-bookings"])) {
        $filter_data = filteration($_POST);

        $query = "SELECT book_order.*, book_detail.* FROM `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id WHERE (book_order.order_id LIKE ? OR book_detail.phone LIKE ? OR book_detail.username LIKE ? OR book_detail.email LIKE ?) AND (book_order.booking_status=? AND book_order.refund=?) ORDER BY book_order.booking_id ASC";
        $search_values = ["%$filter_data[search]%", "%$filter_data[search]%", "%$filter_data[search]%", "%$filter_data[search]%", "cancelled", 0];
        $result = select($query, $search_values, "ssssss");

        $i = 1;
        $data = "";

        if (mysqli_num_rows($result) == 0) {
            if (trim($filter_data["search"] !== "")) {
                echo "<b class='text-danger fw-bold'>No data found matching search results!</b>";
            } else {
                echo "<b class='text-muted fw-bold'>No data found!</b>";
            }
            exit;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $date = date("d-m-Y", strtotime($row["date_time"]));
            $checkin = date("d-m-Y", strtotime($row["check_in"]));
            $checkout = date("d-m-Y", strtotime($row["check_out"]));

            $data .= "
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary'>
                            Order Id: $row[order_id]
                        </span><br/>
                        <b>Username: </b> $row[username] <br/>
                        <b>Phone No.: </b> $row[phone] <br/>
                        <b>Email Address: </b> $row[email]
                    </td>
                    <td>
                        <b>Room name: </b> $row[room_name] <br/>
                        <b>Check In: </b> $checkin <br/>
                        <b>Check Out: </b> $checkout <br/>
                        <b>Date: </b> $date
                    </td>
                    <td>
                        <b>₹$row[transaction_amount]</b>
                    </td>
                    <td>    
                        <button type='button' onclick='refundBooking($row[booking_id])' class='btn btn-sm fw-bold btn-success shadow-none'>
                            <i class='bi bi-cash-stack'></i> Refund
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if (isset($_POST["refund-booking"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=?";
        $values = [1, $filter_data["booking-id"]];
        $result = update($query, $values, "ii");
        echo $result;
    }
?>