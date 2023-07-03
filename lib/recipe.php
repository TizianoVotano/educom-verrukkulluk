<?php
require_once("user.php");
require_once("ingredient.php");
require_once("recipe_info.php");
require_once("kitchen_type.php");

class Recipe {
    private $connection;
    private $user;
    private $ingredient;
    private $recipe_info;
    private $kitchen_type;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new User($connection);
        $this->ingredient = new Ingredient($connection);
        $this->recipe_info = new RecipeInfo($connection);
        $this->kitchen_type = new KitchenType($connection);
    }

    public function selectRecipe($gerecht_id) {
        $sql = "select * from gerecht where id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);


        $this->selectKitchen($recipe["keuken_id"]); 
        $this->selectType($recipe["type_id"]);
        $this->selectIngredients($recipe["id"]);
        $this->selectRecipeInfo($recipe["id"]);

        echo "<pre>";
        print_r($recipe);
        echo "</pre>";
        return($recipe);
    }

    // hoorde dit niet tot GerechtInfo?
    private function selectUser($user_id) {
        return $this->user->selectUser($user_id);
    }

    private function selectRecipeInfo($recipe_id) {
        return $this->recipe_info->selectRecipeInfo($recipe_id);
    }

    private function selectIngredients($recipe_id) {
        return $this->ingredient->selectIngredients($recipe_id);
    }

    private function calcCalories() {
        
    }

    private function calcPrice() {
        
    }

    private function selectRating() {
        return $this->recipe_info->selectRecipeInfo();
    }

    private function selectSteps() {
        return $this->recipe_info->selectRecipeInfo();
    }

    private function selectRemarks($user_id) {
        $this->selectUser($user_id);
        return $this->recipe_info->selectRecipeInfo();
    }

    private function selectKitchen($id) {
        return $this->kitchen_type->selectKitchenType($id);
    }
    
    private function selectType($id) {
        return $this->kitchen_type->selectKitchenType($id);
    }

    private function determineFavourite() {

    }
}