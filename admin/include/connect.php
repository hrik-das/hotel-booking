<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "hotel-booking";
    $connect = mysqli_connect($hostname, $username, $password, $database);
    if (!$connect) {
        die("Something went Wrong! ".mysqli_connect_error());
    }

    /**
     * Sanitizes an array of input data.
     *
     * @param array $data The array of data to be sanitized.
     * @return array The sanitized data.
     */
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

    /**
     * Retrieves all rows from a specified table.
     *
     * @param string $table The name of the table.
     * @return mysqli_result|false The result set on success, or false on failure.
     */
    function selectAll($table) {
        $connect = $GLOBALS["connect"];
        $query = "SELECT * FROM $table";
        $result = mysqli_query($connect, $query);
        return $result;
    }

    /**
     * Executes a SQL query based on the specified operation.
     *
     * @param string $operation The type of operation to perform ('select', 'update', 'insert', 'delete').
     * @param string $sql The SQL query string with placeholders for parameterized values.
     * @param array $values An array of values to bind to the SQL query.
     * @param string $datatypes A string representing the types of the bound variables ('i' for integer, 'd' for double, 's' for string, 'b' for blob).
     * 
     * @return mixed The result of the query execution. For 'select', it returns the result set. For 'update', 'insert', and 'delete', it returns the number of affected rows.
     */
    function executeCrud($operation, $sql, $values, $datatypes) {
        $connect = $GLOBALS["connect"];
        if ($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if (mysqli_stmt_execute($stmt)) {
                if ($operation == "select") {
                    $result = mysqli_stmt_get_result($stmt);
                } else {
                    $result = mysqli_stmt_affected_rows($stmt);
                }
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query Cannot be Executed - $operation");
            }
        } else {
            die("Query Cannot be Prepared - $operation");
        }
    }

    /**
     * Executes a select query with the provided parameters.
     *
     * @param string $sql The SQL query string with placeholders.
     * @param array $values The values to bind to the placeholders.
     * @param string $datatypes The data types of the bound values.
     * @return mysqli_result|false The result set on success, or false on failure.
     */
    function select($sql, $values, $datatypes) {
        $connect = $GLOBALS["connect"];
        if ($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query Cannot be Executed - Select");
            }
        } else {
            die("Query Cannot be Prepared - Select");
        }
    }

    /**
     * Executes an update query with the provided parameters.
     *
     * @param string $sql The SQL query string with placeholders.
     * @param array $values The values to bind to the placeholders.
     * @param string $datatypes The data types of the bound values.
     * @return int The number of affected rows.
     */
    function update($sql, $values, $datatypes) {
        $connect = $GLOBALS["connect"];
        if ($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query Cannot be Executed - Update");
            }
        } else {
            die("Query Cannot be Prepared - Update");
        }
    }

    /**
     * Executes an insert query with the provided parameters.
     *
     * @param string $sql The SQL query string with placeholders.
     * @param array $values The values to bind to the placeholders.
     * @param string $datatypes The data types of the bound values.
     * @return int The number of affected rows.
     */
    function insert($sql, $values, $datatypes) {
        $connect = $GLOBALS["connect"];
        if ($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query Cannot be Executed - Insert");
            }
        } else {
            die("Query Cannot be Prepared - Insert");
        }
    }

    /**
     * Executes a delete query with the provided parameters.
     *
     * @param string $sql The SQL query string with placeholders.
     * @param array $values The values to bind to the placeholders.
     * @param string $datatypes The data types of the bound values.
     * @return int The number of affected rows.
     */
    function delete($sql, $values, $datatypes) {
        $connect = $GLOBALS["connect"];
        if ($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                mysqli_stmt_close($stmt);
                die("Query Cannot be Executed - Delete");
            }
        } else {
            die("Query Cannot be Prepared - Delete");
        }
    }
?>