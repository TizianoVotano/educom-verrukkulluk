<?php
require_once("user.php");

class Boodschappen {
    private $connection;
    private $user;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new User($connection);
    }

    public function selectBoodschappen($user_id = null) {
        $sql = "SELECT * FROM boodschappen";
        if ($user_id != null)
            $sql .= " WHERE user_id = $user_id";

        $sql = "SELECT * FROM boodschappen WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $boodschappen = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $boodschappen;
    }
}