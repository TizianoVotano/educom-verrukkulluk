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

    public function selectRecipe($gerecht_id = null) {
        $sql = "SELECT * FROM gerecht";
        if ($gerecht_id != null)
            $sql .= " WHERE id = $gerecht_id";

        $returnRecipe = [];
        $result = mysqli_query($this->connection, $sql);
        while ($recipe = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $date = $recipe['datum_toegevoegd'];
            $title = $recipe['titel'];
            $shortDescription = $recipe['korte_omschrijving'];
            $longDescription = $recipe['lange_omschrijving'];
            $image = $recipe['afbeelding'];

            $user = $this->selectUser($recipe["user_id"]);
            $kitchenData = $this->selectKitchen($recipe["keuken_id"]); 
            $kitchen = $kitchenData['omschrijving'];
            $typeData = $this->selectType($recipe["type_id"]);
            $type = $typeData['omschrijving'];
            $ingredients = $this->selectIngredients($recipe["id"]);

            $comments = $this->selectRecipeInfo($recipe["id"], "O");
            $preparation = $this->selectRecipeInfo($recipe["id"], "B");
            $favorite = $this->selectRecipeInfo($recipe["id"], "F");

            $rating = $this->calcRating($this->selectRecipeInfo($recipe["id"], "W"));

            $price = $this->calcPrice($ingredients);
            $calories = $this->calcCalories($ingredients);
            
            $returnRecipe[] = ["date"=>$date, "title"=>$title, "shortDescription"=>$shortDescription, 
                        "longDescription"=>$longDescription, "image"=>$image, "user"=>$user, "price"=>$price, 
                        "calories"=>$calories, "comments"=>$comments, "preparation"=>$preparation, "favorite"=>$favorite, 
                        "rating"=>$rating, "kitchen"=>$kitchen, "type"=>$type, "ingredients"=>$ingredients];
        }
        return($returnRecipe);
    }

    private function selectUser($user_id) {
        return $this->user->selectUser($user_id);
    }

    private function selectRecipeInfo($recipe_id, $record_type) {
        return $this->recipe_info->selectRecipeInfo($recipe_id, $record_type);
    }

    private function selectIngredients($recipe_id) {
        return $this->ingredients->selectIngredients($recipe_id);
    }

    private function calcCalories($ingredients) {
        $calories = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["aantal"];
            $unit = $ingredient["eenheid"];
            $unitCalorie = $ingredient["calories"];

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
            $unit = $ingredient["eenheid"];
            $unitPrice = $ingredient["prijs"];

            if ($quantity < 0)
                $quantity = 0;
            $price += ceil($quantity / $unit) * $unitPrice;
        }

        return $price;
    }

    private function calcRating($ratings) {
        $total = 0;
        foreach ($ratings as $rating) {
            $total += $rating["nummeriekveld"];
        }
        $count = count($ratings);
        
        if ($count === 0 || $total === 0) 
            return null;
        $average = $total / $count;
        return $average;
    }

    private function selectKitchen($id) {
        return $this->kitchen_type->selectKitchenType($id);
    }
    
    private function selectType($id) {
        return $this->kitchen_type->selectKitchenType($id);
    }

    public function determineFavourite($recipe_id, $user_id) {
        $favourites = $this->selectRecipeInfo($recipe_id, "F")["favoriet"];
        foreach ($favourites as $favourite) {
            if($favourite["gerecht_id"] == $recipe_id && $favourite["user_id"] == $user_id){
                return true;
            }
        }
        return false;
    }

    public function findRecipes($recipes, $searchString) {
        $search = explode(" ", $searchString);
        $result = [];
        foreach ($search as $searchterm) {
            foreach ($recipes as $recipe) { 
                if (!in_array($recipe, $result)) { // filter
                    $strRecipe = json_encode($recipe);
                    $gevonden = str_contains($strRecipe, $searchterm);
                    if ($gevonden) {
                        $result[] = $recipe;
                    }
                }
            }
        }
            
        return $result;
    }
}