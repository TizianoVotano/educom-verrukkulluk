<?php
require_once("user.php");
class RecipeInfo {
    private $connection;
    private $user;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new User($connection);
    }

    public function selectRecipe($gerecht_id) {
        $sql = "select * from gerecht where gerecht_id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);
        $recipe = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return($recipe);
    }

    private function selectUser() {
        
    }

    private function selectIngredient() {
        
    }

    private function calcCalories() {
        
    }

    private function calcPrice() {
        
    }

    private function selectRating() {
        
    }

    private function selectSteps() {
        
    }

    private function selectRemarks() {
        
    }

    private function selectKitchen() {
        
    }
    
    private function selectType() {
        
    }

    private function determineFavourite() {

    }
}