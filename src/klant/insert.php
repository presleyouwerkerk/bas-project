<?php
// insert.php

require __DIR__ . '/../classes/connection.php';

use BasProject\classes\Connection;

if (isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen")
{
	$connection = new Connection();
    $pdo = $connection->getPdo();

    $stmt = $pdo->prepare("INSERT INTO Klant (klantnaam, klantemail) VALUES (:klantnaam, :klantemail)");

    $stmt->bindParam(':klantnaam', $_POST['klantnaam']);
    $stmt->bindParam(':klantemail', $_POST['klantemail']);

    $stmt->execute();

    header("Location: read.php");
    exit();
} 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
	<h1>CRUD Klant</h1>
	<h2>Add new customer</h2>
	<form method="post">
	<label for="nv">Klantnaam:</label>
	<input type="text" id="nv" name="klantnaam" placeholder="Klantnaam" required/>
	<br><br>   
	<label for="an">Klantemail:</label>
	<input type="text" id="an" name="klantemail" placeholder="Klantemail" required/>
	<br><br>
	<input type='submit' name='insert' value='Submit'>
	</form></br>

	<a href='read.php'>Back</a>
</body>
</html>