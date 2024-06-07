<?php
// verkooporder.php

namespace BasProject\classes;

class Verkooporder
{
    public $klantId;
    public $artId;
    public $verkOrdDatum;
    public $verkOrdBestAantal;
    public $verkOrdStatus;

    public function selectOrder(): array
    {
        try {
            $connection = new Connection();
            $pdo = $connection->getPdo();
            
            $query = "SELECT * FROM verkooporder";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getAllArtikelen(): array
    {
        try {
            $connection = new Connection();
            $pdo = $connection->getPdo();
            
            $query = "SELECT artId, artOmschrijving FROM artikel";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function insertVerkooporder(): bool
    {
        try {
            $connection = new Connection();
            $pdo = $connection->getPdo();
            
            $query = "INSERT INTO verkooporder (klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus) 
                      VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal, :verkOrdStatus)";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':klantId', $this->klantId);
            $stmt->bindParam(':artId', $this->artId);
            $stmt->bindParam(':verkOrdDatum', $this->verkOrdDatum);
            $stmt->bindParam(':verkOrdBestAantal', $this->verkOrdBestAantal);
            $stmt->bindParam(':verkOrdStatus', $this->verkOrdStatus);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function validateInsertVerkooporder(): array
	{
		$errors = [];

		if (
			empty($this->klantId) || empty($this->artId) || empty($this->verkOrdDatum) ||
			empty($this->verkOrdBestAantal) || empty($this->verkOrdStatus)
		) {
			$errors[] = "Fields cannot be empty";
		}
		return $errors;
	}
}