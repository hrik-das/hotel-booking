<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "hotel-booking";

    $connect = mysqli_connect($hostname, $username, $password, $database);

    if (!$connect) {
        die("Connection failed".mysqli_connect_error());
    }

    // function filteration to filter the data
    function filteration($data) {
        foreach($data as $key => $value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $data[$key] = $value;
        }
        
        return $data;
    }

    function selectAllData($table) {
        $connect = $GLOBALS["connect"];
        $query = "SELECT * FROM `$table`";
        $result = mysqli_query($connect, $query);
        return $result;
    }

    function select($query, $values, $types) {
        $connect = $GLOBALS["connect"];

        if ($stmt = mysqli_prepare($connect, $query)) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query cannot be prepared - Select");
            }
        } else {
            die("Query cannot be executed - Select");
        }
    }

    function update($query, $values, $types) {
        $connect = $GLOBALS["connect"];

        if ($stmt = mysqli_prepare($connect, $query)) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Update");
            }
        } else {
            die("Query cannot be executed - Update");
        }
    }

    function insert($query, $values, $types) {
        $connect = $GLOBALS["connect"];

        if ($stmt = mysqli_prepare($connect, $query)) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Insert");
            }
        } else {
            die("Query cannot be executed - Insert");
        }
    }

    function delete($query, $values, $types) {
        $connect = $GLOBALS["connect"];

        if ($stmt = mysqli_prepare($connect, $query)) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Delete");
            }
        } else {
            die("Query cannot be executed - Delete");
        }
    }
?>