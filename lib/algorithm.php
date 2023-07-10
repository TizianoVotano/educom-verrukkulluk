<?php
require_once("recipe.php");
require_once("ingredient.php");
require_once("article.php");
require_once("boodschappen.php");

class Algorithm {
    private $connection;
    private $recipe;
    private $ingredients;
    private $boodschappen;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->recipe = new Recipe($connection);
        $this->ingredients = new Ingredient($connection);
        $this->boodschappen = new Boodschappen($connection);
    }

    public function boodschappenToevoegen($recipe_id, $user_id) {
        $ingredients = $this->ingredients->selectIngredients($recipe_id);

        $commisionsToUpdate = [];
        $commisionsToInsert = [];

        foreach ($ingredients as $ingredient) { 
            if ($boodschap = $this->artikelOpLijst($ingredient["artikel_id"], $user_id)) {
                // artikel aanpassen
                //$this->calcPrice($ingredient, $boodschap);
                $commisionsToUpdate[] = ["id"=>$boodschap['id'], "aantal"=>$boodschap['aantal'] + $ingredient['aantal']];
            } else {
                // artikel toevoegen
                $commisionsToInsert[] = ["artikel_id"=>$ingredient["artikel_id"], "aantal"=>$ingredient["aantal"]];
            }
        }

        // artikel aanpassen
        foreach ($commisionsToUpdate as $boodschap) {
            $query = "UPDATE boodschappen SET aantal = $boodschap[aantal] WHERE id = $boodschap[id];";
            if ($this->connection->query($query) === TRUE) 
                echo "Record updated successfully";
            else 
                echo "Error updating record: " . $this->connection->error;
        }

        // artikels toevoegen
        foreach ($commisionsToInsert as $boodschap) {
            print_r($boodschap);
            $sql = "INSERT INTO `boodschappen` (`user_id`, `artikel_id`, `aantal`) 
                    VALUES ($user_id, $boodschap[artikel_id], $boodschap[aantal]);"; // ingredients.aantal?
            if ($this->connection->query($sql) === TRUE)
                echo "Records inserted succesfully";
            else
                echo "Failed miserably";
        }

        echo "<pre>";print_r($commisionsToUpdate);echo "</pre>";
        echo "<pre>";print_r($commisionsToInsert);echo "</pre>";
    }

    public function artikelOpLijst($article_id, $user_id) {
        $commisionList = $this->ophalenBoodschappen($user_id);

        foreach ($commisionList as $commisionItem) {
            if ($commisionItem["artikel_id"] == $article_id) {
                // artikel is in de boodschappenlijst!
                return $commisionItem;
            }
        }
        return false;
        // artikel niet in lijst
    }

    public function ophalenBoodschappen($user_id) {
        return $this->boodschappen->selectBoodschappen($user_id);
    }

    private function calcAmount($ingredients, $boodschap) {        
        $amount = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["aantal"] + $boodschap["aantal"];
            $unit = $ingredient["eenheid"];
            $unitPrice = $ingredient["prijs"];

            if ($quantity < 0)
                $quantity = 0;
            $amount += ceil($quantity / $unit) * $unitPrice;
        }
        
        return $amount;
    }

    /*
    private function calcPrice($ingredients, $boodschap) {        
        $price = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["aantal"] + $boodschap["aantal"];
            $unit = $ingredient["eenheid"];
            $unitPrice = $ingredient["prijs"];

            if ($quantity < 0)
                $quantity = 0;
            $price += ceil($quantity / $unit) * $unitPrice;
        }
        
        return $price;
    }
    */
}