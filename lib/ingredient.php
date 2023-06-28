<?php
// require_once("database.php");

// $db = new Database();
// $ing = new Ingredient($db->getConnection());

// $data = $ing->selectIngredient(2);

// var_dump($data);



class Ingredient {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selectIngredient($ingredient_id) {
        $sql = "select * from ingredient where id = $ingredient_id;";
        

        $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        $article = getArticle(intval($ingredient["gerecht_id"]));
        return($article);
    }

    private function getArticle($articleId) {
        $article = new Article();
        $article->selectArticle($articleId);
        return($article);
    }
}