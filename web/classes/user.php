<?php

class User {
    public function get_data($id){
        $query = "select * from users where userid = ? limit 1";
        $DB = new Database();
        $result = $DB -> read($query, "s", [$id]);

        if($result){
            $row = $result [0];
            return $row;
        } else {
            return false;
        }
    }
}