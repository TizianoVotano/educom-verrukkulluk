<?php
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
require_once("./lib/database.php");
require_once("./lib/recipe.php");
require_once("./lib/recipe_info.php");
$db = new Database(); 
$recipe = new Recipe($db->getConnection());
$recipe_info = new RecipeInfo($db->getConnection());
$data = $recipe->selectRecipe();

// SEARCHBAR TEST
// $data = $recipe->selectRecipe();
// $dataAllRecipes = $recipe->selectRecipe();
// $recipe->findRecipes($dataAllRecipes, "bolog look pasta");
// FINAL TEST
// require_once("lib/boodschappen.php");
// $commisions = new Boodschappen($db->getConnection());
// $dataComissions = $commisions->boodschappenToevoegen(2, 2);

// URL: http://localhost/index.php?gerecht_id=4&action=detail
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
        $title = "detailpage";
        break;
    }

    case "edit_favourite": {
        header("content-type: application/json; charset=utf-8");
        $gerecht_id = json_decode($_GET['gerecht_id']);
        $user_id = json_decode($_GET['user_id']);
        
        $status;
        if (!$recipe->determineFavourite($gerecht_id, $user_id)) {
            $recipe_info->addFavourite($gerecht_id, $user_id);
            $status = 1;
        } else {
            $recipe_info->removeFavourite($gerecht_id, $user_id);
            $status = 0;
        }
        echo json_encode($status);
        exit();
        break;
    }

    case "add_rating": {
        header("content-type: application/json; charset=utf-8");
        $gerecht_id = json_decode($_GET['gerecht_id']);
        $rating = json_decode($_GET['rating']);
        $status = $recipe_info->addRating($gerecht_id, $rating);
        echo json_encode($status);
        exit();
        break;
    }
    /* TRANSACTIES:
    Homepage,
    detailpagina, 
    rating toevoegen  -  aantal, gerechtid
    favorieten / verw - gerechtid, userid
    boodschappen toevoegen - gerechtid, userid
    zoeken - keyword
    */

    /* Zoekfunctie
    template js of jquery call (eventlistener) > href (URL) met action zoals homepage en details (deze switch) > index.php $recipe->searchRecipes()
    case "search": {
        $data = $recipe->searchRecipes($recipe.selectRecipe(), $searchString);
        $template = 'homepage.html.twig';
        $title = "homepage";
        break;
    }
    */

    

        /// etc
}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$templ = $twig->load($template);

/// En tonen die handel!
echo $templ->render(["title" => $title, "data" => $data]);
