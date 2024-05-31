<?php
// artikel.php

namespace BasProject\classes;

class Artikel
{
    public $artOmschrijving;
    public $artInkoop;
    public $artVerkoop;
    public $artVoorraad;
    public $artMinVoorraad;
    public $artMaxVoorraad;
    public $artLocatie;

    public function insertArtikel(): bool
    {
        try {
            $connection = new Connection();
            $pdo = $connection->getPdo();

            $query = "INSERT INTO artikel (artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie) 
			          VALUES (:artOmschrijving, :artInkoop, :artVerkoop, :artVoorraad, :artMinVoorraad, :artMaxVoorraad, :artLocatie)";

            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':artOmschrijving', $this->artOmschrijving);
            $stmt->bindValue(':artInkoop', $this->artInkoop);
            $stmt->bindValue(':artVerkoop', $this->artVerkoop);
            $stmt->bindValue(':artVoorraad', $this->artVoorraad);
            $stmt->bindValue(':artMinVoorraad', $this->artMinVoorraad);
            $stmt->bindValue(':artMaxVoorraad', $this->artMaxVoorraad);
            $stmt->bindValue(':artLocatie', $this->artLocatie);
            $stmt->execute();
            
            return true;
        } catch (\PDOException $e) {
            error_log("Error inserting" . $e->getMessage());
            return false;
        }
    }

    public function validateInsertArtikel(): array
    {
        $errors = [];

        if (
            empty($this->artOmschrijving) || empty($this->artInkoop) || empty($this->artVerkoop) ||
            empty($this->artVoorraad) || empty($this->artMinVoorraad) || empty($this->artMaxVoorraad) || empty($this->artLocatie)
        ) {
            $errors[] = "Fields cannot be empty";
        }
        return $errors;
    }
}