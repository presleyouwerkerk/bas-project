<?php
// insert.php

require __DIR__ . '/../../vendor/autoload.php';

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
				header("Location: read.php");
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
	<link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
	<h1>New customer</h1>
	<form method="post">
		<input type="text" name="klantnaam" placeholder="Klantnaam" />
		<br><br>
		<input type="text" name="klantemail" placeholder="klantemail" />
		<br><br>
		<input type="text" name="klantadres" placeholder="klantadres" />
		<br><br>
		<input type="text" name="klantpostcode" placeholder="klantpostcode" />
		<br><br>
		<input type="text" name="klantwoonplaats" placeholder="klantwoonplaats" />
		<br><br>
		<input type='submit' name='insert' value='Submit'>
	</form></br>

	<a href='read.php'>Back</a>
</body>

</html>