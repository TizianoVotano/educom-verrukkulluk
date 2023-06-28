<?php
require_once("database.php");
require_once("article.php");

$db = new Database();
$ing = new Ingredient($db->getConnection());

$data = $ing->selectIngredients(2);

//var_dump($data);



class Ingredient {
    private $connection;
    private $article;
    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->article = new Article($connection);
    }

    public function selectIngredients($gerecht_id) {
        // -haalt ingredienten op
        $sql = "select * from ingredient where gerecht_id = $gerecht_id;";
        $result = mysqli_query($this->connection, $sql);
        $ingredients = mysqli_fetch_all($result, MYSQLI_ASSOC); 
       // print_r($ingredients);
        
        // haal articles op
        // ingredients worden opgehaald
        foreach ($ingredients as $ingredient) {
            // $articles = array_push($this->getArticle($ingredient['artikel_id']));
            // print_r($articles);
            $test = $this->getArticle(2);
        }

        // maak van ingredients en articles een lange array

        return($ingredients);
    }

    private function getArticle($articleId) {
        return($this->article->selectArticle($articleId));
    }
}