<?php
require_once("article.php");
class Ingredient {
    private $connection;
    private $article;
    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->article = new Article($connection);
    }

    public function selectIngredients($gerecht_id) {
        $sql = "SELECT * FROM ingredient WHERE gerecht_id = $gerecht_id;";
        $result = mysqli_query($this->connection, $sql);

        $ingredients = mysqli_fetch_all($result, MYSQLI_ASSOC); 
        
        $ingredientsWithArticles = [];
        foreach ($ingredients as $ingredient) {
            //array_push($ingredientsWithArticles, $ingredient + ["artikel" => $this->getArticle($ingredient['artikel_id'])]);
            $article = $this->getArticle($ingredient["artikel_id"]);
            $ingredientsWithArticles[] = [
                "id" => $ingredient["id"],
                "gerecht_id" => $ingredient["gerecht_id"],
                "artikel_id" => $ingredient["artikel_id"],
                "aantal" => $ingredient["aantal"],
                "naam" => $article["naam"],
                "omschrijving" => $article["omschrijving"],
                "prijs" => $article["prijs"],
                "eenheid" => $article["eenheid"],
                "verpakking" => $article["verpakking"],
                "calories" => $article["calories"]
            ];
        }
             
        return($ingredientsWithArticles);
    }

    private function getArticle($articleId) {
        return($this->article->selectArticle($articleId));
    }
}