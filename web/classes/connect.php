<?php

// connecting stuff with functions lol

class DATABASE {
    private $host = "localhost";
    private $username = "root";
    private $password ="";
    private $db = "ecohunt_db";

    function connect(){
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $connection;
    }

    // $query uses ? placeholders; $types is the mysqli bind_param type string (e.g. "ss"); $params are the values
    function read($query, $types = "", $params = []){
        $conn = $this->connect();
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt){
            error_log("Prepare failed: $query\nError: " . mysqli_error($conn));
            return false;
        }
        if ($types !== ""){
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    function save($query, $types = "", $params = []){
        $conn = $this->connect();
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt){
            error_log("Prepare failed: $query\nError: " . mysqli_error($conn));
            return false;
        }
        if ($types !== ""){
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        return mysqli_stmt_execute($stmt);
    }
}