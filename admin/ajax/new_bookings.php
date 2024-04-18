<?php
    require("../include/connect.php");
    require("../include/essential.php");
    adminLogin();

    if(isset($_POST["getBookings"])){
        $filterData = filteration($_POST);
        $i = 1;
        $data = "";
        $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id WHERE (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.username LIKE ?) AND bo.booking_status=? AND bo.arrival=? ORDER BY bo.booking_id ASC";
        $result = select($query, ["%$filterData[search]%", "%$filterData[search]%", "%$filterData[search]%", "booked", 0], "sssss");
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
                        <b>Room: </b> ₹$row[price] <br/>
                    </td>
                    <td>
                        <b>Check In: </b> $checkin <br/>
                        <b>Check Out: </b> $checkout <br/>
                        <b>Paid: </b> ₹$row[transaction_amount] <br/>
                        <b>Date: </b> $date <br/>
                    </td>
                    <td>
                        <button type='button' onclick='assignRoom($row[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assignRoom'>
                            <i class='bi bi-check2-square'></i> Assign Room
                        </button><br/>
                        <button type='button' onclick='cancelBooking($row[booking_id])' class='btn btn-sm mt-2 btn-outline-danger fw-bold shadow-none'>
                            <i class='bi bi-trash'></i> Cancel Booking
                        </button>
                    </td>
                </tr>";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST["assignRoom"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id SET bo.arrival=?, bo.rate_review=?, bd.room_no=? WHERE bo.booking_id=?";
        $values = [1, 0, $filterData["room_number"], $filterData["booking_id"]];
        $result = update($query, $values, "iisi");    // It will Update 2 Rows will Return 2
        echo ($result == 2) ? 1 : 0;
    }

    if(isset($_POST["cancelBooking"])){
        $filterData = filteration($_POST);
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
        $values = ["cancelled", 0, $filterData["booking_id"]];
        $result = update($query, $values, "sii");
        echo $result;
    }
?>