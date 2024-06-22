<?php
// verkooporder.php

namespace BasProject\classes;

class Verkooporder
{
    private $connection;
    public $klantId;
    public $artId;
    public $verkOrdDatum;
    public $verkOrdBestAantal;
    public $verkOrdStatus;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insertVerkooporder(): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "INSERT INTO verkooporder (klantId, artId, verkOrdDatum, verkOrdBestAantal) 
                      VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal)";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':klantId', $this->klantId);
            $stmt->bindParam(':artId', $this->artId);
            $stmt->bindParam(':verkOrdDatum', $this->verkOrdDatum);
            $stmt->bindParam(':verkOrdBestAantal', $this->verkOrdBestAantal);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function validateVerkooporder(): array
    {
        $errors = [];

        if (
            empty($this->klantId) || empty($this->artId) || empty($this->verkOrdDatum) ||
            empty($this->verkOrdBestAantal || empty($this->verkOrdStatus))
        ) {
            $errors[] = "Fields cannot be empty";
        }
        return $errors;
    }

    public function selectVerkooporder(): array
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT verkooporder.verkOrdId, 
                             verkooporder.verkOrdDatum, 
                             verkooporder.verkOrdBestAantal, 
                             verkooporder.verkOrdStatus, 
                             klant.klantNaam, 
                             artikel.artOmschrijving 
                      FROM verkooporder 
                      JOIN klant ON verkooporder.klantId = klant.klantId 
                      JOIN artikel ON verkooporder.artId = artikel.artId";

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
            $pdo = $this->connection->getPdo();

            $query = "SELECT artId, artOmschrijving FROM artikel";

            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getAllKlanten(): array
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT klantId, klantNaam FROM klant";
            
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function searchVerkooporder(string $searchTerm): array
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT verkooporder.verkOrdId, 
                             verkooporder.verkOrdDatum, 
                             verkooporder.verkOrdBestAantal, 
                             verkooporder.verkOrdStatus, 
                             artikel.artOmschrijving, 
                             klant.klantNaam 
                      FROM verkooporder 
                      JOIN klant ON verkooporder.klantId = klant.klantId 
                      JOIN artikel ON verkooporder.artId = artikel.artId
                      WHERE klant.klantNaam LIKE :query";

            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':query', "%$searchTerm%");
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error searching verkooporder: " . $e->getMessage());
            return [];
        }
    }

    public function deleteVerkooporder(int $id): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "DELETE FROM verkooporder WHERE verkOrdId = :verkOrdId";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':verkOrdId', $id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            error_log("Error deleting verkooporder: " . $e->getMessage());
            return false;
        }
    }

    public function updateVerkooporder(int $verkOrdId): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "UPDATE verkooporder 
                      SET klantId = :klantId, 
                          artId = :artId, 
                          verkOrdDatum = :verkOrdDatum, 
                          verkOrdBestAantal = :verkOrdBestAantal,
                          verkOrdStatus = :verkOrdStatus
                      WHERE verkOrdId = :verkOrdId";

            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':klantId', $this->klantId);
            $stmt->bindValue(':artId', $this->artId);
            $stmt->bindValue(':verkOrdDatum', $this->verkOrdDatum);
            $stmt->bindValue(':verkOrdBestAantal', $this->verkOrdBestAantal);
            $stmt->bindValue(':verkOrdStatus', $this->verkOrdStatus);
            $stmt->bindValue(':verkOrdId', $verkOrdId);

            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            error_log("Error updating verkooporder: " . $e->getMessage());
            return false;
        }
    }

    public function getVerkooporderById(int $verkOrdId): array
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT verkooporder.*,
                             klant.klantNaam, 
                             artikel.artOmschrijving 
                      FROM verkooporder 
                      JOIN klant ON verkooporder.klantId = klant.klantId 
                      JOIN artikel ON verkooporder.artId = artikel.artId 
                      WHERE verkooporder.verkOrdId = :verkOrdId";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':verkOrdId', $verkOrdId);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error fetching verkooporder by ID: " . $e->getMessage());
            return [];
        }
    }
}
