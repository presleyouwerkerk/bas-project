<?php
// klant.php

namespace BasProject\classes;

class Klant
{
	public $klantNaam;
	public $klantEmail;
	public $klantAdres;
	public $klantPostcode;
	public $klantWoonplaats;

	public function insertKlant(): bool
	{
		try {
			$connection = new Connection();
			$pdo = $connection->getPdo();

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
            $connection = new Connection();
            $pdo = $connection->getPdo();
            
            $query = "SELECT * FROM klant";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}