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
        // a.*, b.* this sequence is necessary because we need b.id, 
        // and selecting everything with * will overwrite b.id with a.id (final id will overwrite former one)
        $sql = "SELECT a.*, b.* FROM boodschappen b JOIN artikel a ON (b.artikel_id = a.id)";
        if ($user_id != null)
            $sql .= " WHERE b.user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $commissions = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $commissionsWithArticles = [];
        foreach ($commissions as $commission) {
            $quantity = $commission["aantal"];
            if ($quantity < 0)
                $quantity = 0;
            $unit = $commission["eenheid"];
            $unitPrice = $commission["prijs"];

            $commissionPrice = ceil($quantity / $unit) * $unitPrice;

            $commissionsWithArticles[] = [
                "id"=>$commission['id'],
                "user_id"=>$commission['user_id'],
                "artikel_id"=>$commission['artikel_id'],
                "aantal"=>$commission['aantal'],
                "naam"=>$commission['naam'],
                "omschrijving"=>$commission['omschrijving'],
                "prijs"=>$commission['prijs'],
                "eenheid"=>$commission['eenheid'],
                "verpakking"=>$commission['verpakking'],
                "calories"=>$commission['calories'],
                "commissie_prijs"=>$commissionPrice
            ];
        }

        //echo "<pre>"; print_r($commissionsWithArticles);echo "</pre>";

        return $commissionsWithArticles;
    }

    public function removeBoodschap($id = null) {
        $sql = "DELETE FROM `boodschappen`";
        if ($id)
            $sql .= " WHERE `id` = $id";
        return ($this->connection->query($sql) === TRUE);
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