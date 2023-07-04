<?php
class Ingredient {
    private $connection;
    private $article;
    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->article = new Article($connection);
    }

    public function selectIngredients($gerecht_id) {
        $sql = "select * from ingredient where gerecht_id = $gerecht_id;";
        $result = mysqli_query($this->connection, $sql);

        $ingredients = mysqli_fetch_all($result, MYSQLI_ASSOC); 
        
        //$articles = array();
        $ingredientsWithArticles = [];
        foreach ($ingredients as $ingredient) {
            //array_push($articles, $this->getArticle($ingredient['artikel_id']));
            array_push($ingredientsWithArticles, $ingredient + ["artikel" => $this->getArticle($ingredient['artikel_id'])]);
        }
        
        //$ingredientsWithArticles = array("ingredients"=>$ingredients, "articles"=>$articles);        
        return($ingredientsWithArticles);
    }

    private function getArticle($articleId) {
        return($this->article->selectArticle($articleId));
    }
}