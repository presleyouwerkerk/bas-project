<?php
// insert.php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST["submit"])) {
		$connection = new Connection();
		$klant = new Klant($connection);

		$klant->klantNaam = $_POST['klantnaam'];
		$klant->klantEmail = $_POST['klantemail'];
		$klant->klantAdres = $_POST['klantadres'];
		$klant->klantPostcode = $_POST['klantpostcode'];
		$klant->klantWoonplaats = $_POST['klantwoonplaats'];

		$errors = $klant->validateKlant();

		if (empty($errors)) {
			if ($klant->insertKlant()) {
				header("Location: read.php");
				exit();
			} else {
				$errors[] = "Insertion failed";
			}
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crud</title>
	<link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
	<?php 
	include '../../public/index.html'; 
	
	if (!empty($errors)) {
		echo '<p class="error">' . implode($errors) . '</p>';
	}
	?>

	<h1 class="heading">Nieuwe klant</h1>
	<form method="post">
		<input class="field" type="text" name="klantnaam" placeholder="Naam">
		<input class="field" type="text" name="klantemail" placeholder="Email">
		<input class="field" type="text" name="klantadres" placeholder="Adres">
		<input class="field" type="text" name="klantpostcode" placeholder="Postcode">
		<input class="field" type="text" name="klantwoonplaats" placeholder="Woonplaats">
		<input class="submit" type='submit' name='submit' value='Submit'>
	</form>
</body>

</html>