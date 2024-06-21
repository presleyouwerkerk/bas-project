<?php
// artikel.php

namespace BasProject\classes;

class Artikel
{
    private $connection;
    public $artOmschrijving;
    public $artInkoop;
    public $artVerkoop;
    public $artVoorraad;
    public $artMinVoorraad;
    public $artMaxVoorraad;
    public $artLocatie;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insertArtikel(): bool
    {
        try {
            $pdo = $this->connection->getPdo();

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

    public function validateArtikel(): array
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

    public function selectArtikel(): array
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT * FROM artikel";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function searchArtikel(string $searchTerm): array
	{
		try {
			$pdo = $this->connection->getPdo();

			$stmt = $pdo->prepare("SELECT * FROM artikel WHERE artOmschrijving LIKE :query");
			$stmt->bindValue(':query', "%$searchTerm%");
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			error_log("Error searching artikel: " . $e->getMessage());
			return [];
		}
	}

    public function deleteArtikel(int $id): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "DELETE FROM artikel WHERE artId = :artId";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':artId', $id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            error_log("Error deleting artikel: " . $e->getMessage());
            return false;
        }
    }

    public function updateArtikel(int $artId): bool
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "UPDATE artikel 
                      SET artOmschrijving = :artOmschrijving, 
					  artInkoop = :artInkoop, 
                      artVerkoop = :artVerkoop, 
					  artVoorraad = :artVoorraad, 
                      artMinVoorraad = :artMinVoorraad, 
                      artMaxVoorraad = :artMaxVoorraad, 
                      artLocatie = :artLocatie
                      WHERE artId = :artId";

			$stmt = $pdo->prepare($query);

			$stmt->bindValue(':artOmschrijving', $this->artOmschrijving);
			$stmt->bindValue(':artInkoop', $this->artInkoop);
			$stmt->bindValue(':artVerkoop', $this->artVerkoop);
			$stmt->bindValue(':artVoorraad', $this->artVoorraad);
			$stmt->bindValue(':artMinVoorraad', $this->artMinVoorraad);
            $stmt->bindValue(':artMaxVoorraad', $this->artMaxVoorraad);
            $stmt->bindValue(':artLocatie', $this->artLocatie);
			$stmt->bindValue(':artId', $artId);

			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			error_log("Error updating artikel: " . $e->getMessage());
			return false;
		}
	}

	public function getArtikelById(int $artId): array
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "SELECT * FROM artikel WHERE artId = :artId";
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':artId', $artId);
			$stmt->execute();

			$artikel = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $artikel;
		} catch (\PDOException $e) {
			error_log("Error fetching artikel by ID: " . $e->getMessage());
			return [];
		}
	}
}