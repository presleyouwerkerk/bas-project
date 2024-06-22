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

	public function validateKlant(): array
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

	public function searchKlant(string $searchTerm): array
	{
		try {
			$pdo = $this->connection->getPdo();

			$stmt = $pdo->prepare("SELECT * FROM klant WHERE klantNaam LIKE :query");
			
			$stmt->bindValue(':query', "%$searchTerm%");
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

	public function updateKlant(int $klantId): bool
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "UPDATE klant 
                      SET klantNaam = :klantnaam, 
					      klantEmail = :klantemail, 
						  klantAdres = :klantadres, 
						  klantPostcode = :klantpostcode, 
						  klantWoonplaats = :klantwoonplaats 
                      WHERE klantId = :klantid";

			$stmt = $pdo->prepare($query);

			$stmt->bindValue(':klantnaam', $this->klantNaam);
			$stmt->bindValue(':klantemail', $this->klantEmail);
			$stmt->bindValue(':klantadres', $this->klantAdres);
			$stmt->bindValue(':klantpostcode', $this->klantPostcode);
			$stmt->bindValue(':klantwoonplaats', $this->klantWoonplaats);
			$stmt->bindValue(':klantid', $klantId);

			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			error_log("Error updating klant: " . $e->getMessage());
			return false;
		}
	}

	public function getKlantById(int $klantId): array
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "SELECT * FROM klant WHERE klantId = :klantId";

			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':klantId', $klantId);
			$stmt->execute();

			$klant = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $klant;
		} catch (\PDOException $e) {
			error_log("Error fetching klant by ID: " . $e->getMessage());
			return null;
		}
	}
}
