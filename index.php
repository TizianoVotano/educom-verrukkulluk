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
$recipe = new Recipe($db->getConnection());
$commisions = new Boodschappen($db->getConnection());


/// VERWERK 
 $dataAllRecipes = $recipe->selectRecipe();
 $recipe->findRecipes($dataAllRecipes, "bolog look pasta");
// $dataComissions = $commisions->boodschappenToevoegen(2, 2);

/// RETURN