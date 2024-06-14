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

    public function validateInsertVerkooporder(): array
    {
        $errors = [];

        if (
            empty($this->klantId) || empty($this->artId) || empty($this->verkOrdDatum) ||
            empty($this->verkOrdBestAantal)
        ) {
            $errors[] = "Fields cannot be empty";
        }
        return $errors;
    }

    public function selectVerkooporder(): array
    {
        try {
            $pdo = $this->connection->getPdo();

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

    public function updateVerkooporderStatus($verkOrdId, $verkOrdStatus): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "UPDATE verkooporder SET verkOrdStatus = :verkOrdStatus WHERE verkOrdId = :verkOrdId";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':verkOrdStatus', $verkOrdStatus);
            $stmt->bindParam(':verkOrdId', $verkOrdId);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function searchVerkooporder(string $query): array
    {
        try {
            $pdo = $this->connection->getPdo();

            $stmt = $pdo->prepare("SELECT * FROM verkooporder WHERE verkOrdId LIKE :query");
            $stmt->bindValue(':query', "%$query%");
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
}
