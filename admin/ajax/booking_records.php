<?php
    require("../include/connect.php");
    require("../include/essential.php");
    adminLogin();

    if(isset($_POST["getBookings"])){
        $filterData = filteration($_POST);
        $limit = 1;    // Change this limit variable to Select How many Rows of data you wanna show in the pagination
        $page = $filterData["page"];
        $start = ($page - 1) * $limit;
        $i = $start + 1;
        $data = "";
        $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id WHERE ((bo.booking_status='booked' AND bo.arrival=1) OR (bo.booking_status='cancelled' AND bo.refund=1) OR (bo.booking_status='payment failed')) AND (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.username LIKE ?) ORDER BY bo.booking_id DESC";
        $result = select($query, ["%$filterData[search]%", "%$filterData[search]%", "%$filterData[search]%"], "sss");
        $limitQuery = $query." LIMIT $start, $limit";
        $limitResult = select($limitQuery, ["%$filterData[search]%", "%$filterData[search]%", "%$filterData[search]%"], "sss");
        $totalRows = mysqli_num_rows($result);
        if($totalRows == 0){
            $output = json_encode(["table_data"=>"<b>No Data Found!</b>", "pagination"=>""]);
            echo $output;
            exit();
        }
        while($row = mysqli_fetch_assoc($limitResult)){
            $date = date("d-m-Y", strtotime($row["dateTime"]));
            $checkin = date("d-m-Y", strtotime($row["checkin"]));
            $checkout = date("d-m-Y", strtotime($row["checkout"]));
            if($row["booking_status"] == "booked"){
                $statusBG = "bg-success";
            }else if($row["booking_status"] == "cancelled"){
                $statusBG = "bg-danger";
            }else{
                $statusBG = "bg-warning text-dark";
            }
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
                        <b>Amount: </b> ₹$row[transaction_amount] <br/>
                        <b>Date: </b> $date <br/>
                    </td>
                    <td>
                        <span class='badge $statusBG'>$row[booking_status]</span>
                    </td>
                    <td>
                        <button type='button' onclick='downloadPDF($row[booking_id])' class='btn btn-sm ms-3 btn-outline-danger fw-bold shadow-none'>
                            <i class='bi bi-filetype-pdf'></i>
                        </button>
                    </td>
                </tr>";
            $i++;
        }
        $pagination = "";
        if($totalRows > $limit){
            $totalPages = ceil($totalRows / $limit);
            $disabled = ($page == 1) ? "disabled" : "";
            $prev = $page - 1;
            if($page != 1){
                $pagination .= "<li class='page-item'><button onclick='changePage(1)' class='page-link text-dark shadow-none'>First</button></li>";
            }
            $pagination .= "<li class='page-item $disabled'><button onclick='changePage($prev)' class='page-link shadow-none'>Prev</button></li>";
            $disabled = ($page == $totalPages) ? "disabled" : "";
            $next = $page + 1;
            $pagination .= "<li class='page-item $disabled'><button onclick='changePage($next)' class='page-link shadow-none'>Next</button></li>";
            if($page != $totalPages){
                $pagination .= "<li class='page-item'><button onclick='changePage($totalPages)' class='page-link text-dark shadow-none'>Last</button></li>";
            }
        }
        $output = json_encode(["table_data"=>$data, "pagination"=>$pagination]);
        echo $output;
    }
?>