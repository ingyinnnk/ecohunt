<?php

class Signup {
    
    // Error checking
    private $error = "";

    public function evaluate($data){
        foreach ($data as $key => $value){
            if (empty($value)){
                $this->error = $this-> error . $key. " is empty <br>";
            }

            if($key == "username"){
                if(strstr($value, " ")) {
                    $this->error = $this->error . "username can't contain a space";
                }
            }
        }



        if ($this-> error == ""){
            // no error
            $this->create_user($data);

        } else {
            return $this->error;
        }
    }

    public function create_user($data){
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // create these
        $url_address = strtolower($username);
        $userid = $this->create_userid();

        $query = "insert into users (userid, username, password, url_address) values (?, ?, ?, ?)";
        $DB = new Database();
        $DB -> save($query, "ssss", [$userid, $username, $password, $url_address]);
    }

    private function create_url(){
        
    }

    private function create_userid(){
        $length = rand(4, 19);
        $number = "";
        for ($i=0; $i<$length; $i++ ){
            $new_rand = rand(0, 9);  // Fixed syntax here
            $number .= $new_rand;
        }

        return $number;
    }
}