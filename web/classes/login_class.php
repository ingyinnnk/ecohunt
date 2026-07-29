<?php

class Login {

    private $error = ""; 

    public function evaluate($data){

        $username = $data['username'];
        $password = $data['password'];

        $query = "select * from users where username = ? limit 1";

        $DB = new Database();
        $result = $DB -> read($query, "s", [$username]);

        if ($result){
            $row = $result[0];

            if(password_verify($password, $row['password'])){

                //create session data
                $_SESSION['ecohunt_userid'] = $row['userid'];
            } else {
                $this->error .= "Wrong password";
            }
        } else {
            $this->error .= "No such username was found.";
        }

        return $this->error;
    }
    public function check_login($id){
        $query = "select userid from users where userid = ? limit 1";

        $DB = new Database();
        $result = $DB -> read($query, "s", [$id]);

        if ($result){
            return true;
        } return false;
    }

}