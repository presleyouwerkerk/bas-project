<?php

namespace BasProject\classes;

class Verkooporder
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insertVerkooporder(array $verkooporderData): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "INSERT INTO verkooporder (klantId, artId, verkOrdDatum, verkOrdBestAantal) 
                      VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal)";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':klantId', $verkooporderData['klantId']);
            $stmt->bindParam(':artId', $verkooporderData['artId']);
            $stmt->bindParam(':verkOrdDatum', $verkooporderData['verkOrdDatum']);
            $stmt->bindParam(':verkOrdBestAantal', $verkooporderData['verkOrdBestAantal']);

            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Error inserting verkooporder: " . $e->getMessage();
            return false;
        }
    }

    public function validateVerkooporder(array $verkooporderData): array
    {
        $errors = [];

        if (
            empty($verkooporderData['klantId']) || empty($verkooporderData['artId']) || 
            empty($verkooporderData['verkOrdDatum']) || empty($verkooporderData['verkOrdBestAantal'])
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
            error_log("Error inserting verkooporder: " . $e->getMessage());
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
            error_log("Error getting all artikelen: " . $e->getMessage());
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
            error_log("Error getting all klanten: " . $e->getMessage());
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

    public function deleteVerkooporder(int $verkOrdId): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "DELETE FROM verkooporder WHERE verkOrdId = :verkOrdId";

            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':verkOrdId', $verkOrdId);

            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            error_log("Error deleting verkooporder: " . $e->getMessage());
            return false;
        }
    }

    public function updateVerkooporder(int $verkOrdId, array $verkooporderData): bool
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

            $stmt->bindParam(':klantId', $verkooporderData['klantId']);
            $stmt->bindParam(':artId', $verkooporderData['artId']);
            $stmt->bindParam(':verkOrdDatum', $verkooporderData['verkOrdDatum']);
            $stmt->bindParam(':verkOrdBestAantal', $verkooporderData['verkOrdBestAantal']);
            $stmt->bindValue(':verkOrdStatus', $verkooporderData['verkOrdStatus']);
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
