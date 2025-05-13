<?php
    require_once("../include/connect.php");
    require_once("../include/essential.php");
    adminLogin();

    if (isset($_POST["get-bookings"])) {
        $filter_data = filteration($_POST);

        $limit = 10;
        $page = $filter_data["page"];
        $start = ($page - 1) * $limit;

        $query = "SELECT book_order.*, book_detail.* FROM `booking_order` book_order INNER JOIN `booking_details` book_detail ON book_order.booking_id=book_detail.booking_id WHERE 
        ((book_order.booking_status='booked' AND book_order.arrival=1) OR (book_order.booking_status='cancelled' AND book_order.refund=1) OR (book_order.booking_status='failed')) AND (book_order.order_id LIKE ? OR book_detail.phone LIKE ? OR book_detail.username LIKE ? OR book_detail.email LIKE ?) ORDER BY book_order.booking_id DESC";
        $search_values = ["%$filter_data[search]%", "%$filter_data[search]%", "%$filter_data[search]%", "%$filter_data[search]%"];
        $result = select($query, $search_values, "ssss");

        $limit_query = $query ." LIMIT $start, $limit";
        $limit_result = select($limit_query, $search_values, "ssss");

        $i = $start + 1;
        $data = "";
        $total_rows = mysqli_num_rows($result);

        if ($total_rows == 0) {
            $message = trim($filter_data["search"]) !== "" ? "<b class='text-danger fw-bold'>No data found matching the search results!</b>" : "<b class='fw-bold'>No data found!</b>";
            echo json_encode(["table_data" => $message, "pagination" => ""]);
            exit;
        }

        while ($row = mysqli_fetch_assoc($limit_result)) {
            $date = date("d-m-Y", strtotime($row["date_time"]));
            $checkin = date("d-m-Y", strtotime($row["check_in"]));
            $checkout = date("d-m-Y", strtotime($row["check_out"]));

            if ($row["booking_status"] == "booked") {
                $status_background = "bg-success";
            } else if ($row["booking_status"] == "cancelled") {
                $status_background = "bg-danger";
            } else {
                $status_background = "bg-warning text-dark";
            }

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
                        <b>Amount: </b> ₹$row[transaction_amount] <br/>
                        <b>Date: </b> $date
                    </td>
                    <td>
                        <span class='badge $status_background'>$row[booking_status]</span>
                    </td>
                    <td>
                        <button type='button' onclick='downloadPDF($row[booking_id])' class='btn btn-sm fw-bold btn-outline-danger shadow-none' title='Download PDF'>
                            <i class='bi bi-file-pdf-fill'></i>
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        $pagination = "";

        if ($total_rows > $limit) {
            $total_pages = ceil($total_rows / $limit);

            if ($page != 1) {
                $pagination .= "
                    <li class='page-item'>
                        <button class='page-link shadow-none' onclick='changePage(1)'>first</button>
                    </li>
                ";
            }

            $disabled = ($page == 1) ? "disabled" : "";
            $prev = $page - 1;
            $pagination .= "
                <li class='page-item $disabled'>
                    <button class='page-link shadow-none' onclick='changePage($prev)'>prev</button>
                </li>
            ";

            $disabled = ($page == $total_pages) ? "disabled" : "";
            $next = $page + 1;
            $pagination .= "
                <li class='page-item $disabled'>
                    <button class='page-link shadow-none' onclick='changePage($next)'>next</button>
                </li>
            ";

            if ($page != $total_pages) {
                $pagination .= "
                    <li class='page-item'>
                        <button class='page-link shadow-none' onclick='changePage($total_pages)'>last</button>
                    </li>
                ";  
            }
        }

        $output = json_encode(["table_data" => $data, "pagination" => $pagination]);
        echo $output;
    }
?>