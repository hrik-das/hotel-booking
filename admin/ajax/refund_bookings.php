<?php
    require("../include/connect.php");
    require("../include/essential.php");
    adminLogin();

    if(isset($_POST["getBookings"])){
        $filterData = filteration($_POST);
        $i = 1;
        $data = "";
        $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id WHERE (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.username LIKE ?) AND bo.booking_status=? AND bo.refund=? ORDER BY bo.booking_id ASC";
        $result = select($query, ["%$filterData[search]%", "%$filterData[search]%", "%$filterData[search]%", "cancelled", 0], "sssss");
        if(mysqli_num_rows($result) == 0){
            echo "<b>No data Found!</b>";
            exit();
        }
        while($row = mysqli_fetch_assoc($result)){
            $date = date("d-m-Y", strtotime($row["dateTime"]));
            $checkin = date("d-m-Y", strtotime($row["checkin"]));
            $checkout = date("d-m-Y", strtotime($row["checkout"]));
            $data .= "
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary'>
                            Order ID: $row[order_id]  
                        </span><br/>
                        <b>Name: </b> $row[username] <br/>
                        <b>Phone Number: </b> $row[phone] <br/>
                    </td>
                    <td>
                        <b>Room: </b> $row[room_name] <br/>
                        <b>Check In: </b> $checkin <br/>
                        <b>Check Out: </b> $checkout <br/>
                        <b>Date: </b> $date <br/>
                    </td>
                    <td>
                        <b>₹$row[transaction_amount]</b>
                    </td>
                    <td>
                        <button type='button' onclick='refundBooking($row[booking_id])' class='btn btn-sm btn-outline-success fw-bold shadow-none'>
                            <i class='bi bi-cash-stack'></i> Refund
                        </button>   
                    </td>
                </tr>";
            $i++;
        }
        echo $data;
        // Refund Booking doesn't Refund the Amount (Not Implemented Function Yet). Refund API Integration Pending!
    }

    if(isset($_POST["refundBookings"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=?";
        $values = [1, $filterData["booking_id"]];
        $result = update($query, $values, "ii");
        echo $result;
    }
?>