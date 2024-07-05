<?php

namespace BasProject\classes;

class Klant
{
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function insertKlant(array $klantData): bool
	{
		try {
			$pdo = $this->connection->getPdo();
	
			$query = "INSERT INTO klant (klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats) 
					  VALUES (:klantNaam, :klantEmail, :klantAdres, :klantPostcode, :klantWoonplaats)";
	
			$stmt = $pdo->prepare($query);
	
			$stmt->bindValue(':klantNaam', $klantData['klantNaam']);
			$stmt->bindValue(':klantEmail', $klantData['klantEmail']);
			$stmt->bindValue(':klantAdres', $klantData['klantAdres']);
			$stmt->bindValue(':klantPostcode', $klantData['klantPostcode']);
			$stmt->bindValue(':klantWoonplaats', $klantData['klantWoonplaats']);
			
			$stmt->execute();
	
			return true;
		} catch (\PDOException $e) {
			error_log("Error inserting klant: " . $e->getMessage());
			return false;
		}
	}	

	public function validateKlant(array $klantData): array
	{
		$errors = [];

		if (
			empty($klantData['klantNaam']) || empty($klantData['klantEmail']) || empty($klantData['klantAdres']) ||
			empty($klantData['klantPostcode']) || empty($klantData['klantWoonplaats'])
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
			error_log("Error selecting klant: " . $e->getMessage());
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

	public function deleteKlant(int $klantId): bool
	{
		try {
			$pdo = $this->connection->getPdo();

			$query = "DELETE FROM klant WHERE klantId = :klantId";

			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':klantId', $klantId);
			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			error_log("Error deleting klant: " . $e->getMessage());
			return false;
		}
	}

	public function updateKlant(int $klantId, array $klantData): bool
	{
		try {
			$pdo = $this->connection->getPdo();
	
			$query = "UPDATE klant 
					  SET klantNaam = :klantNaam, 
						  klantEmail = :klantEmail, 
						  klantAdres = :klantAdres, 
						  klantPostcode = :klantPostcode, 
						  klantWoonplaats = :klantWoonplaats 
					  WHERE klantId = :klantId";
	
			$stmt = $pdo->prepare($query);
	
			$stmt->bindValue(':klantNaam', $klantData['klantNaam']);
			$stmt->bindValue(':klantEmail', $klantData['klantEmail']);
			$stmt->bindValue(':klantAdres', $klantData['klantAdres']);
			$stmt->bindValue(':klantPostcode', $klantData['klantPostcode']);
			$stmt->bindValue(':klantWoonplaats', $klantData['klantWoonplaats']);
			$stmt->bindValue(':klantId', $klantId);
	
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
