<?php

class KitchenType {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selectKitchenType($kitchenType_id) {
        $sql = "select * from keuken_type where id = $kitchenType_id";

        $result = mysqli_query($this->connection, $sql);
        $kitchenType = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($kitchenType);
    }
}