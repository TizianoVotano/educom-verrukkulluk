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

        $oudeBoodschappen = [];
        $nieuweBoodschappen = [];

        foreach ($ingredients as $ingredient) { 
            if ($boodschap = $this->artikelOpLijst($ingredient["artikel_id"], $user_id)) {
                // artikel aanpassen
                //$this->calcPrice($ingredient, $boodschap);
                $oudeBoodschappen[] = ["id"=>$boodschap['id'], "aantal"=>$boodschap['aantal'] + $ingredient['aantal']];
            } else {
                // artikel toevoegen
                $nieuweBoodschappen[] = ["artikel_id"=>$ingredient["artikel_id"], "aantal"=>$ingredient["aantal"]];
            }
        }

        echo "<pre>";print_r($oudeBoodschappen);echo "</pre>";
        echo "<pre>";print_r($nieuweBoodschappen);echo "</pre>";

        // artikel aanpassen
        $query = "";
        foreach ($oudeBoodschappen as $boodschap) {
            $query = "UPDATE boodschappen SET aantal = $boodschap[aantal] WHERE id = $boodschap[id];";
            if ($this->connection->query($query) === TRUE) 
                echo "Record updated successfully";
            else 
                echo "Error updating record: " . $this->connection->error;
        }

        echo $query;

        
        ///////////////////

        // artikels toevoegen
        
        foreach ($nieuweBoodschappen as $boodschap) {
            print_r($boodschap);
            $sql = "INSERT INTO `boodschappen` (`user_id`, `artikel_id`, `aantal`) 
                    VALUES ($user_id, $boodschap[artikel_id], $boodschap[aantal]);"; // ingredients.aantal?
            if ($this->connection->query($sql) === TRUE)
                echo "Records inserted succesfully";
            else
                echo "Failed miserably";
        }
                
        
        /////////////////////
    }

    public function artikelOpLijst($article_id, $user_id) {
        $boodschappenLijst = $this->ophalenBoodschappen($user_id);

        foreach ($boodschappenLijst as $boodschapItem) {
            if ($boodschapItem["artikel_id"] == $article_id) {
                // artikel is in de boodschappenlijst!
                return $boodschapItem;
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