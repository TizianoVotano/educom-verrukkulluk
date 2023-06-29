<?php
require_once("user.php");
class RecipeInfo {
    private $connection;
    private $user;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new User($connection);
    }

    public function selectInfo($gerecht_id) {
        $sql = "select * from gerecht_info where gerecht_id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);
        $recipeInfo = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($this->sortRecipeInfo($recipeInfo));
    }

    private function sortRecipeInfo($recipeInfo) {
        $sortedInformation = array("bereidingswijze"=>[], 
                                    "opmerkingen"=>[], 
                                    "waardering"=>[], 
                                    "favoriet"=>[]);
        foreach ($recipeInfo as $infoItem) {
            if ("B" == $infoItem["record_type[O,B,W,F]"]) {
                array_push($sortedInformation["bereidingswijze"], $infoItem);
            } else if ("O" == $infoItem["record_type[O,B,W,F]"]) {
                $infoItem["user"] = $this->getUser($infoItem["user_id"]);
                array_push($sortedInformation["opmerkingen"], $infoItem);
            } else if ("W" == $infoItem["record_type[O,B,W,F]"]) {
                array_push($sortedInformation["waardering"], $infoItem);
            } else if ("F" == $infoItem["record_type[O,B,W,F]"]) {
                $infoItem["user"] = $this->getUser($infoItem["user_id"]);
                array_push($sortedInformation["favoriet"], $infoItem);
            }
        }

        return $sortedInformation;
    }

    private function getUser($user_id) {
        return $this->user->selectUser($user_id);
    }

    public function addFavourite($gerecht_id, $user_id) {
        // het skelet van wat ik ervan zal maken
        $sql = "INSERT INTO recept_info (firstname, lastname, email)
        VALUES ('John', 'Doe', 'john@example.com')";

        if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function removeFavourite($gerecht_id, $user_id) {
        // het skelet van wat ik ervan zal maken
        $sql = "DELETE FROM MyGuests WHERE id=3";

        if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
        }
    }

    // public function addRating() {

    // }
}