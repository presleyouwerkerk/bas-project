<?php
// klant.php

namespace BasProject\classes;

class Klant
{
	public string $klantNaam;
	public string $klantEmail;
	public string $klantAdres;
	public int $klantPostcode;
	public string $klantWoonplaats;

	// public function crudKlant(): void
	// {
	// 	$lijst = $this->getKlanten();

	// 	$this->showTable($lijst);
	// }

	// public function getKlanten(): array
	// {
	// 	$stmt = $this->conn->getPdo()->query("SELECT * FROM Klant");

	// 	return $stmt->fetchAll();
	// }

	// public function getKlant(int $klantId): array
	// {

	// 	// Doe een fetch op $klantId

	// 	$lijst = ['klantId' => 1, 'klantEmail' => 'test1@example.com', 'klantNaam' => 'Test 1', 'klantWoonplaats' => 'City 1'];

	// 	return $lijst;
	// }

	// public function dropDownKlant($row_selected = -1)
	// {
	// 	$lijst = $this->getKlanten();

	// 	echo "<label for='Klant'>Choose a klant:</label>";
	// 	echo "<select name='klantId'>";

	// 	foreach ($lijst as $row) {
	// 		if ($row_selected == $row["klantId"]) {
	// 			echo "<option value='$row[klantId]' selected='selected'> $row[klantnaam] $row[klantemail]</option>\n";
	// 		} else {
	// 			echo "<option value='$row[klantId]'> $row[klantnaam] $row[klantemail]</option>\n";
	// 		}
	// 	}
	// 	echo "</select>";
	// }

	// public function showTable($lijst): void
	// {
	// 	$txt = "<table>";

	// 	$txt .= getTableHeader($lijst[0]);

	// 	foreach ($lijst as $row) {
	// 		$txt .= "<tr>";
	// 		$txt .=  "<td>" . $row["klantId"] . "</td>";
	// 		$txt .=  "<td>" . $row["klantNaam"] . "</td>";
	// 		$txt .=  "<td>" . $row["klantEmail"] . "</td>";
	// 		$txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";

	// 		$txt .=  "<td>";
	// 		$txt .= " 
    //         <form method='post' action='update.php?klantId=$row[klantId]' >       
    //             <button name='update'>Wzg</button>	 
    //         </form> </td>";

	// 		$txt .=  "<td>";
	// 		$txt .= " 
    //         <form method='post' action='delete.php?klantId=$row[klantId]' >       
    //             <button name='verwijderen'>Verwijderen</button>	 
    //         </form> </td>";
	// 		$txt .= "</tr>";
	// 	}
	// 	$txt .= "</table>";
	// 	echo $txt;
	// }

	// public function deleteKlant(int $klantId): bool
	// {
	// 	return true;
	// }

	// public function updateKlant($row): bool
	// {
	// 	return true;
	// }

	public function insertKlant(): bool
	{
		try {
			$connection = new Connection();
			$pdo = $connection->getPdo();

			$query = "INSERT INTO Klant (klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats) 
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

	public function validateInsertKlant()
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
}
