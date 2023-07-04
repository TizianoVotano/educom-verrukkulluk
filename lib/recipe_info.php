<?php
require_once("user.php");
class RecipeInfo {
    private $connection;
    private $user;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new User($connection);
    }

    public function selectRecipeInfo($gerecht_id, $record_type) {
        $sql = "SELECT * FROM gerecht_info WHERE gerecht_id = $gerecht_id AND record_type = '$record_type'";
        $result = mysqli_query($this->connection, $sql);
        $recipeInfo = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $infoWithUser = [];
        foreach($recipeInfo as $info) {
            if ($record_type == "F" || $record_type == "O") {
                $user = $this->selectUser($info["user_id"]);
                $infoWithUser[] = array_merge($info, $user);
            }
        }
        if (count($infoWithUser) > 0)
            return $infoWithUser;
        return($recipeInfo);
    }

    private function selectUser($user_id) {
        return $this->user->selectUser($user_id);
    }

    public function addFavourite($gerecht_id, $user_id) {
        $sql = "INSERT INTO `gerecht_info` (`record_type`, `gerecht_id`, `user_id`)
                VALUES ('F', $gerecht_id, $user_id)";
        if ($this->connection->query($sql) === TRUE){
            echo "Record inserted succesfully";
        } else {
            echo "Failed miserably";
        }
    }

    public function removeFavourite($gerecht_id, $user_id) {
        $sql = "DELETE FROM `gerecht_info` WHERE record_type = 'F' 
                                           AND `gerecht_id` = $gerecht_id 
                                           AND `user_id` = $user_id";

        if ($this->connection->query($sql) === TRUE) {
        echo "Record deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
        }
    }
}