<?php

require 'Connection.php';

use Bas_project\ontwerp\Connection;

$connection = new Connection();

$pdo = $connection->getPdo();


$sql = "SELECT klant.klantNaam, klant.klantEmail, 
        artikel.artOmschrijving, verkooporder.verkOrdDatum, verkooporder.verkOrdBestAantal
        FROM klant
        JOIN verkooporder ON klant.klantId = verkooporder.klantId
        JOIN artikel ON verkooporder.artId = artikel.artId";

$stmt = $pdo->query($sql);

if ($stmt) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Naam: " . 
        $row["klantNaam"]. " - E-mail: " . 
        $row["klantEmail"]. " - Artikel: " . 
        $row["artOmschrijving"]. " - Datum: " . 
        $row["verkOrdDatum"]. " - Aantal: " . 
        $row["verkOrdBestAantal"]. "<br>";
    }
} else {
    echo "Error executing query: " . $pdo->errorInfo()[2];
}
?>