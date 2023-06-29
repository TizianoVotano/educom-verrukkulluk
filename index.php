<?php

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php");
require_once("lib/kitchen_type.php");
require_once("lib/ingredient.php");
require_once("lib/recipe_info.php");

/// INIT
$db = new Database();
$art = new Article($db->getConnection());
$user = new User($db->getConnection());
$kitchenType = new KitchenType($db->getConnection());
$ingredient = new Ingredient($db->getConnection());
$recipeInfo = new RecipeInfo($db->getConnection());


/// VERWERK 
$data = $art->selectArticle(8);
$dataUsers = $user->selectUser(2);
$dataKitchenType = $kitchenType->selectKitchenType(2);
$dataIngredient = $ingredient->selectIngredients(2);
$dataRecipeInfo = $recipeInfo->selectInfo(1);
$dataRecipeInfo = $recipeInfo->addFavourite(1, 2); // $gerecht_id, $user_id
//$dataRecipeInfo = $recipeInfo->removeFavourite(1, 2);

/// RETURN
// echo "<pre>"; var_dump($data); echo "</pre>";
// echo "<pre>"; var_dump($dataUsers); echo "</pre>";
// echo "<pre>"; var_dump($dataKitchenType); echo "</pre>";
// echo "<pre>"; var_dump($dataIngredient); echo "</pre>";
echo "<pre>"; var_dump($dataRecipeInfo); echo "</pre>";