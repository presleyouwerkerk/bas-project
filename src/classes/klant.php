<?php
// klant.php

namespace BasProject\classes;

include_once "functions.php";

class Klant
{
	private $conn;
	private $table_name = "klant";	

	public function __construct($connection)
    {
        $this->conn = $connection;
    }

	public function crudKlant() : void 
	{
		$lijst = $this->getKlanten();

		$this->showTable($lijst);
	}

	public function getKlanten() : array 
	{
        $stmt = $this->conn->getPdo()->query("SELECT * FROM {$this->table_name}");

        return $stmt->fetchAll();
	}

	public function getKlant(int $klantId) : array 
	{

		// Doe een fetch op $klantId
		
		$lijst = ['klantId' => 1, 'klantEmail' => 'test1@example.com', 'klantNaam' => 'Test 1', 'klantWoonplaats' => 'City 1'];

		return $lijst;
	}
	
	public function dropDownKlant($row_selected = -1)
	{
		$lijst = $this->getKlanten();
		
		echo "<label for='Klant'>Choose a klant:</label>";
		echo "<select name='klantId'>";

		foreach ($lijst as $row)
		{
			if ($row_selected == $row["klantId"])
			{
				echo "<option value='$row[klantId]' selected='selected'> $row[klantnaam] $row[klantemail]</option>\n";
			} 
			else 
			{
				echo "<option value='$row[klantId]'> $row[klantnaam] $row[klantemail]</option>\n";
			}
		}
		echo "</select>";
	}

	public function showTable($lijst) : void 
	{
		$txt = "<table>";

		$txt .= getTableHeader($lijst[0]);

		foreach($lijst as $row)
		{
			$txt .= "<tr>";
			$txt .=  "<td>" . $row["klantId"] . "</td>";
			$txt .=  "<td>" . $row["klantNaam"] . "</td>";
			$txt .=  "<td>" . $row["klantEmail"] . "</td>";
			$txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";
			
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update.php?klantId=$row[klantId]' >       
                <button name='update'>Wzg</button>	 
            </form> </td>";

			$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='delete.php?klantId=$row[klantId]' >       
                <button name='verwijderen'>Verwijderen</button>	 
            </form> </td>";	
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	public function deleteKlant(int $klantId) : bool 
	{
		return true;
	}

	public function updateKlant($row) : bool
	{
		return true;
	}
	
	private function BepMaxKlantId() : int 
	{
        $sql = "SELECT MAX(klantId)+1 FROM $this->table_name";
        return (int) $this->conn->getPdo()->query($sql)->fetchColumn();
	}
	
	public function insertKlant($row)
	{
		$klantId = $this->BepMaxKlantId();

		// query
		
		// Prepare
		
		// Execute 'klantId'=>$klantId,		
	}
}