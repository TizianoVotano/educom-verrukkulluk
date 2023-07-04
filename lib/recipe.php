<?php
require_once("user.php");
require_once("ingredient.php");
require_once("recipe_info.php");
require_once("kitchen_type.php");

class Recipe {
    private $connection;
    private $user;
    private $ingredients;
    private $recipe_info;
    private $kitchen_type;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new User($connection);
        $this->ingredients = new Ingredient($connection);
        $this->recipe_info = new RecipeInfo($connection);
        $this->kitchen_type = new KitchenType($connection);
    }

    public function selectRecipe($gerecht_id) {
        $sql = "select * from gerecht where id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        $recipe = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user = $this->selectUser($recipe["user_id"]);
        $kitchen = $this->selectKitchen($recipe["keuken_id"]); 
        $type = $this->selectType($recipe["type_id"]);
        $ingredients = $this->selectIngredients($recipe["id"]);
        $recipe_info = $this->selectRecipeInfo($recipe["id"]);

        $price = $this->calcPrice($ingredients);
        $calories = $this->calcCalories($ingredients);

        $returnRecipe = ["user"=>$user, "price"=>$price, "calories"=>$calories, "recipe"=>$recipe, 
                        "recipe_info"=>$recipe_info, "kitchen"=>$kitchen, "type"=>$type, "ingredients"=>$ingredients];

        echo "<pre>";
        print_r($returnRecipe);
        echo "</pre>";
        return($recipe);
    }

    private function selectUser($user_id) {
        return $this->user->selectUser($user_id);
    }

    private function selectRecipeInfo($recipe_id) {
        return $this->recipe_info->selectRecipeInfo($recipe_id);
    }

    private function selectIngredients($recipe_id) {
        return $this->ingredients->selectIngredients($recipe_id);
    }

    private function calcCalories($ingredients) {
        $calories = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["aantal"];
            $unit = $ingredient["artikel"]["eenheid"];
            $unitCalorie = $ingredient["artikel"]["calories"];

            if ($quantity < 0)
                $quantity = 0;
            $calories += ceil($quantity / $unit) * $unitCalorie;
        }

        return $calories;
    }

    private function calcPrice($ingredients) {        
        $price = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["aantal"];
            $unit = $ingredient["artikel"]["eenheid"];
            $unitPrice = $ingredient["artikel"]["prijs"];

            if ($quantity < 0)
                $quantity = 0;
            $price += ceil($quantity / $unit) * $unitPrice;
        }

        return $price;
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

    public function determineFavourite($recipe_id, $user_id) {
        $favourites = $this->selectRecipeInfo($recipe_id)["favoriet"];
        foreach ($favourites as $favourite) {
            if($favourite["gerecht_id"] == $recipe_id && $favourite["user_id"] == $user_id){
                return true;
            }
        }
        return false;
    }
}