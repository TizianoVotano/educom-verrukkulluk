<?php

require_once("lib/database.php");
require_once("lib/recipe.php");
require_once("lib/boodschappen.php");

/// INIT
$db = new Database();
$recipe = new Recipe($db->getConnection());
// $commisions = new Boodschappen($db->getConnection());


/// VERWERK 
 $dataAllRecipes = $recipe->selectRecipe();
 $recipe->findRecipes($dataAllRecipes, "bolog look pasta");
// $dataComissions = $commisions->boodschappenToevoegen(2, 2);

/// RETURN






//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("fase-2/lib/gerecht.php");
require_once("./lib/recipe.php");
require_once("./lib/recipe.php");
$recipe = new Recipe($db->getConnection());
$data = $recipe->selectRecipe();
//var_dump($data);

/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";

$template = "homepage.html.twig";
$title = "homepage";

switch($action) {

        case "homepage": {
            $data = $recipe->selectRecipe();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $recipe->selectRecipe($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$templ = $twig->load($template);


/// En tonen die handel!
echo $templ->render(["title" => $title, "data" => $data]);
