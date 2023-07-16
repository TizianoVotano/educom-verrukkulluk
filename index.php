<?php

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/recipe_info.php");
require_once("lib/recipe.php");
require_once("lib/boodschappen.php");

/// INIT
$db = new Database();
$art = new Article($db->getConnection());
$user = new User($db->getConnection());
$kitchenType = new KitchenType($db->getConnection());
$ingredient = new Ingredient($db->getConnection());
$recipeInfo = new RecipeInfo($db->getConnection());
$recipe = new Recipe($db->getConnection());
$commisions = new Boodschappen($db->getConnection());


/// VERWERK 
// $data = $art->selectArticle(8);
// $dataUsers = $user->selectUser(2);
// $dataKitchenType = $kitchenType->selectKitchenType(2);
// $dataIngredient = $ingredient->selectIngredients(2);
// $dataRecipeInfo = $recipeInfo->selectRecipeInfo(1);
// $dataRecipeInfo = $recipeInfo->addFavourite(1, 2); // $gerecht_id, $user_id
// $dataRecipeInfo = $recipeInfo->removeFavourite(1, 2);
// $dataRecipe = $recipe->selectRecipe(1);
// $dataFavourite = $recipe->determineFavourite(1, 3);
 $dataAllRecipes = $recipe->selectRecipe();
 findRecipes($dataAllRecipes, "knoflook");
// $dataComissions = $commisions->boodschappenToevoegen(2, 2);

/// RETURN
// echo "<pre>"; var_dump($data); echo "</pre>";
// echo "<pre>"; var_dump($dataUsers); echo "</pre>";
// echo "<pre>"; var_dump($dataKitchenType); echo "</pre>";
// echo "<pre>"; var_dump($dataIngredient); echo "</pre>";
// echo "<pre>"; print_r($dataAllRecipes); echo "</pre>";
// echo "<pre>"; print_r($dataAllRecipes); echo "</pre>";
// echo "<pre>"; print_r($dataComissions); echo "</pre>";
// var_dump($dataFavourite);

function findRecipes($recipes, $searchString) {
    $search = explode(" ", $searchString);
    $result = [];
   // echo json_encode($recipe); 
    foreach ($search as $searchterm) {
        foreach ($recipes as $recipe) { //echo "<pre>";print_r($recipe);echo "</pre>";
            $str = json_encode($recipe); 
            $gevonden = strcmp($searchterm, $str);
            if ($gevonden) {
                $result[] = $recipe;
            }
        }
    }

    echo "<pre>";print_r($result);echo "</pre>";

    return $result;
}