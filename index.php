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
require_once("./lib/boodschappen.php");
require_once("./lib/article.php");
$db = new Database(); 
$recipe = new Recipe($db->getConnection());
$recipe_info = new RecipeInfo($db->getConnection());
$data = $recipe->selectRecipe();

$commisions = new Boodschappen($db->getConnection());
$article = new Article($db->getConnection());

// SEARCHBAR TEST
// $data = $recipe->selectRecipe();
// $dataAllRecipes = $recipe->selectRecipe();
// $recipe->findRecipes($dataAllRecipes, "bolog look pasta");
// FINAL TEST
// require_once("lib/boodschappen.php");
// $commisions = new Boodschappen($db->getConnection());
// $dataComissions = $commisions->boodschappenToevoegen(2, 2); //var_dump($dataComissions);

// URL: http://localhost/index.php?gerecht_id=4&action=detail
$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";
$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : "";

$template = "homepage.html.twig";
$title = "homepage";

switch($action) {
    case "homepage": {
        $data = $recipe->selectRecipe();
        $template = "homepage.html.twig";
        $title = "Homepage";
        break;
    }

    case "detail": {
        $data = $recipe->selectRecipe($gerecht_id);
        $template = "detail.html.twig";
        $title = "Detailpage";
        break;
    }

    case "groceries": {
        $commisions->boodschappenToevoegen($gerecht_id, $user_id);
        $data = $commisions->selectBoodschappen($user_id);
        $template = "groceries.html.twig";
        $title = "Groceries";
        break;
    }
    
    case "deleteCommission" : {
        $id = json_decode(isset($_GET["id"]) ? $_GET["id"] : null);
        $commisions->removeBoodschap($id);
        echo json_encode($id);
        exit();
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
