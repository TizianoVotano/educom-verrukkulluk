<?php
require_once("ingredient.php");
require_once("article.php");

class Algorithm {
    private $connection;
    private $ingredients;
    private $articles;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingredients = new Ingredient($connection);
        $this->articles = new Article($connection);
    }
    
    public function ophalenBoodschappen($user_id) {
        // waarschijnlijk een call van de frontend hier ontvangen en verwerken

    }

    public function boodschappenToevoegen($recipe_id, $user_id) {
        $ingredients = $this->ingredients->selectIngredients($recipe_id);
        foreach ($ingredients as $ingredient) {
            if ($this->artikelOpLijst($ingredients["artikel_id"], $user_id)) {
                // artikel bijwerken, efficiente aantallen etc
            } else {
                // artikel toevoegen
            }
        }
    }

    public function artikelOpLijst($article_id, $user_id) {
        $boodschappenLijst = ophalenBoodschappen($user_id);
        foreach ($boodschappenLijst as $boodschapItem) {
            if ($boodschapItem["artikel_id"] == $article_id) {
                // artikel is in lijst!
                return $boodschappenLijst;
            }
        }
        return false;
        // artikel niet in lijst
    }
}