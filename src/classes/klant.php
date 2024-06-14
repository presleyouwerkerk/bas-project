<?php
// klant.php

namespace BasProject\classes;

class Klant
{
	private $connection;
	public $klantNaam;
	public $klantEmail;
	public $klantAdres;
	public $klantPostcode;
	public $klantWoonplaats;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function insertKlant(): bool
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "INSERT INTO klant (klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats) 
			          VALUES (:klantnaam, :klantemail, :klantadres, :klantpostcode, :klantwoonplaats)";

			$stmt = $pdo->prepare($query);

			$stmt->BindValue(':klantnaam', $this->klantNaam);
			$stmt->BindValue(':klantemail', $this->klantEmail);
			$stmt->BindValue(':klantadres', $this->klantAdres);
			$stmt->BindValue(':klantpostcode', $this->klantPostcode);
			$stmt->BindValue(':klantwoonplaats', $this->klantWoonplaats);
			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			error_log("Error inserting" . $e->getMessage());
			return false;
		}
	}

	public function validateInsertKlant(): array
	{
		$errors = [];

		if (
			empty($this->klantNaam) || empty($this->klantEmail) || empty($this->klantAdres) ||
			empty($this->klantPostcode) || empty($this->klantWoonplaats)
		) {
			$errors[] = "Fields cannot be empty";
		}
		return $errors;
	}


	public function selectKlant(): array
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "SELECT * FROM klant";
			$stmt = $pdo->prepare($query);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			echo "Error: " . $e->getMessage();
			return [];
		}
	}

	public function searchKlant(string $query): array
	{
		try {
			$pdo = $this->connection->getPdo();

			$stmt = $pdo->prepare("SELECT * FROM klant WHERE klantNaam LIKE :query");
			$stmt->bindValue(':query', "%$query%");
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			error_log("Error searching klant: " . $e->getMessage());
			return [];
		}
	}

	public function deleteKlant(int $id): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "DELETE FROM klant WHERE klantId = :klantId";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':klantId', $id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            error_log("Error deleting klant: " . $e->getMessage());
            return false;
        }
    }
}