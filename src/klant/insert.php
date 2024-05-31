<?php
// insert.php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST["insert"])) {
		$klant = new Klant();

		$klant->klantNaam = $_POST['klantnaam'];
		$klant->klantEmail = $_POST['klantemail'];
		$klant->klantAdres = $_POST['klantadres'];
		$klant->klantPostcode = $_POST['klantpostcode'];
		$klant->klantWoonplaats = $_POST['klantwoonplaats'];

		$errors = $klant->validateInsertKlant();

		if (empty($errors)) {
			if ($klant->insertKlant()) {
				header("Location: ../../public/index.html");
				exit();
			} else {
				$errors[] = "Insertion failed";
			}
		}
	}
}

if (!empty($errors)) {
	echo '<p>' . implode('<br>', $errors) . '</p>';
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crud</title>
</head>

<body>
	<h1>Nieuwe klant</h1>
	<form method="post">
		<input type="text" name="klantnaam" placeholder="Naam" required />
		<br><br>
		<input type="text" name="klantemail" placeholder="Email" required />
		<br><br>
		<input type="text" name="klantadres" placeholder="Adres" required />
		<br><br>
		<input type="text" name="klantpostcode" placeholder="Postcode" required />
		<br><br>
		<input type="text" name="klantwoonplaats" placeholder="Woonplaats" required />
		<br><br>
		<input type='submit' name='insert' value='Submit'>
		<br><br>
		<a href='read.php'>Terug</a>
	</form>
</body>

</html>