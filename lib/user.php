<?php

class User {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selectUser($user_id) {
        $sql = "select user_name, email from user where id = $user_id";

        $result = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($user);
    }

    // private function validatePassword() {

    // }
}