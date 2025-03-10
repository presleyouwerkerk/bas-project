<?php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

session_start();

if (!isset($_SESSION['roleId']) || $_SESSION['roleId'] != 3) {
	header("Location: /bas-project/src/login/login.php");
	exit();
}

$errors = [];

$connection = new Connection();
$klant = new Klant($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$klantData = [
		'klantNaam' => $_POST['klantNaam'],
		'klantEmail' => $_POST['klantEmail'],
		'klantAdres' => $_POST['klantAdres'],
		'klantPostcode' => $_POST['klantPostcode'],
		'klantWoonplaats' => $_POST['klantWoonplaats']
	];

	$errors = $klant->validateKlant($klantData);

	if (empty($errors)) {
		if ($klant->insertKlant($klantData)) {
			header("Location: read.php");
			exit();
		} else {
			$errors[] = "Insertion failed";
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nieuwe klant</title>
	<link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
	<?php include '../../public/nav.php'; ?>

	<div class="main-content">
		<h1 class="heading">Nieuwe klant</h1>

		<?php foreach ($errors as $error) : ?>
			<?php echo '<p class="error">' . $error; ?>
		<?php endforeach; ?>

		<form method="POST" action="create.php">
			<div class="form-group">
				<label for="klantNaam">Klant:</label>
				<input id="klantNaam" class="field" type="text" name="klantNaam" placeholder="Klant">
			</div>

			<div class="form-group">
				<label for="klantEmail">Email:</label>
				<input id="klantEmail" class="field" type="text" name="klantEmail" placeholder="Email">
			</div>

			<div class="form-group">
				<label for="klantAdres">Adres:</label>
				<input id="klantAdres" class="field" type="text" name="klantAdres" placeholder="Adres">
			</div>

			<div class="form-group">
				<label for="klantPostcode">Postcode:</label>
				<input id="klantPostcode" class="field" type="text" name="klantPostcode" placeholder="Postcode">
			</div>

			<div class="form-group">
				<label for="klantWoonPlaats">Woonplaats:</label>
				<input id="klantWoonPlaats" class="field" type="text" name="klantWoonplaats" placeholder="Woonplaats">
			</div>

			<input class="submit" type='submit' value='Submit'>
		</form>
	</div>
</body>

</html>