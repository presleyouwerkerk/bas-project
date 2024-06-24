<?php
require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST["submit"])) {
		$connection = new Connection();
		$klant = new Klant($connection);

		$klant->klantNaam = $_POST['klantNaam'];
		$klant->klantEmail = $_POST['klantEmail'];
		$klant->klantAdres = $_POST['klantAdres'];
		$klant->klantPostcode = $_POST['klantPostcode'];
		$klant->klantWoonplaats = $_POST['klantWoonplaats'];

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
	<title>Nieuwe klant</title>
	<link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
	<?php include '../../public/nav.html'; ?>

	<div class="main-content">
		<h1 class="heading">Nieuwe klant</h1>

		<?php foreach ($errors as $error) : ?>
			<?php echo '<p class="error">' . $error; ?>
		<?php endforeach; ?>

		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
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

			<input class="submit" type='submit' name='submit' value='Submit'>
		</form>
	</div>
</body>

</html>