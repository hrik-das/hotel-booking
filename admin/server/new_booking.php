<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["get-bookings"])) {
        $filter_data = filteration($_POST);

        $query = "SELECT book_order.*, book_detail.* FROM `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id WHERE (book_order.order_id LIKE ? OR book_detail.phone LIKE ? OR book_detail.username LIKE ? OR book_detail.email LIKE ?) AND (book_order.booking_status=? AND book_order.arrival=?) ORDER BY book_order.booking_id ASC";
        $search_values = ["%$filter_data[search]%", "%$filter_data[search]%", "%$filter_data[search]%", "%$filter_data[search]%", "booked", 0];
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
                        <b>Room Price: </b> ₹$row[price] per night
                    </td>
                    <td>
                        <b>Check In: </b> $checkin <br/>
                        <b>Check Out: </b> $checkout <br/>
                        <b>Amount Paid: </b> ₹$row[transaction_amount] <br/>
                        <b>Date: </b> $date
                    </td>
                    <td>
                        <button type='button' onclick='assignRoom($row[booking_id])' class='btn btn-sm text-white fw-bold custom-background shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                            <i class='bi bi-check2-square'></i> Assign
                        </button><br/>
                        <button type='button' onclick='cancelBooking($row[booking_id])' class='btn btn-sm fw-bold btn-outline-danger shadow-none mt-2'>
                            <i class='bi bi-trash-fill'></i> Cancel
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if (isset($_POST["assign-room"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id SET book_order.arrival=?, book_order.rate_review=?, book_detail.room_no=? WHERE book_order.booking_id=?";
        $values = [1, 0, $filter_data["room-no"], $filter_data["booking-id"]];
        $result = update($query, $values, "iisi");
        echo ($result == 2) ? 1 : 0;    // it will update 2 rows so it will return 2 instead of 1
    }

    if (isset($_POST["cancel-booking"])) {
        $filter_data = filteration($_POST);

        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
        $values = ["cancelled", 0, $filter_data["booking-id"]];
        $result = update($query, $values, "sii");
        echo $result;
    }
?>