<?php
require_once("user.php");
require_once("recipe.php");
require_once("ingredient.php");
require_once("article.php");

class Boodschappen {
    private $connection;
    private $ingredients;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->ingredients = new Ingredient($connection);
    }

    public function selectBoodschappen($user_id = null) {
        $sql = "SELECT * FROM boodschappen";
        if ($user_id != null)
            $sql .= " WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $boodschappen = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $boodschappen;
    }

    private function calcPrice($ingredients) {        
        $price = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["aantal"];
            $unit = $ingredient["eenheid"];
            $unitPrice = $ingredient["prijs"];

            if ($quantity < 0)
                $quantity = 0;
            $price += ceil($quantity / $unit) * $unitPrice;
        }

        return $price;
    }

    public function boodschappenToevoegen($recipe_id, $user_id) {
        $ingredients = $this->ingredients->selectIngredients($recipe_id);

        $commisionsToUpdate = [];
        $commisionsToInsert = [];

        foreach ($ingredients as $ingredient) { 
            if ($boodschap = $this->artikelOpLijst($ingredient["artikel_id"], $user_id)) { // artikel aanpassen
                $commisionsToUpdate[] = ["id"=>$boodschap['id'], "aantal"=>$boodschap['aantal'] + $ingredient['aantal']];
            } else { // artikel toevoegen
                $commisionsToInsert[] = ["artikel_id"=>$ingredient["artikel_id"], "aantal"=>$ingredient["aantal"]];
            }
        }

        // artikels aanpassen
        foreach ($commisionsToUpdate as $boodschap) {
            $query = "UPDATE boodschappen SET aantal = $boodschap[aantal] WHERE id = $boodschap[id];";
            $this->connection->query($query);
        }

        // artikels toevoegen
        foreach ($commisionsToInsert as $boodschap) {
            $sql = "INSERT INTO `boodschappen` (`user_id`, `artikel_id`, `aantal`) 
                    VALUES ($user_id, $boodschap[artikel_id], $boodschap[aantal]);";
            $this->connection->query($sql);
        }
    }

    public function artikelOpLijst($article_id, $user_id) {
        $commisionList = $this->selectBoodschappen($user_id);

        foreach ($commisionList as $commisionItem) {
            if ($commisionItem["artikel_id"] == $article_id) { // artikel is in de boodschappenlijst
                return $commisionItem;
            }
        }
        return false;
    }
}