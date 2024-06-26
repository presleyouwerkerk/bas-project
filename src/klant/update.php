<?php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

$connection = new Connection();
$klantInstance = new Klant($connection);

$errors = [];

if (isset($_GET['klantId'])) {
    $klantId = $_GET['klantId'];
    $klant = $klantInstance->getKlantById($klantId);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $klantId = $_POST['klantId'];
    $klantInstance->klantNaam = $_POST['klantNaam'];
    $klantInstance->klantEmail = $_POST['klantEmail'];
    $klantInstance->klantAdres = $_POST['klantAdres'];
    $klantInstance->klantPostcode = $_POST['klantPostcode'];
    $klantInstance->klantWoonplaats = $_POST['klantWoonplaats'];

    if ($klantInstance->updateKlant($klantId)) {
        header("Location: read.php");
        exit();
    } else {
        $errors[] = "Er is een fout opgetreden";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant bijwerken</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.html'; ?>

    <div class="main-content">
        <h1 class="heading">Klant bijwerken</h1>

        <?php foreach ($errors as $error) : ?>
            <?php echo '<p class="error">' . $error; ?>
        <?php endforeach; ?>

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <input type="hidden" name="klantId" value="<?php echo $klantId; ?>">

            <div class="form-group">
                <label for="klantNaam">Klant:</label>
                <input id="klantNaam" class="field" type="text" name="klantNaam" placeholder="Naam" value="<?php echo $klant['klantNaam']; ?>">
            </div>

            <div class="form-group">
                <label for="klantEmail">Email:</label>
                <input id="klantEmail" class="field" type="text" name="klantEmail" placeholder="Email" value="<?php echo $klant['klantEmail']; ?>">
            </div>

            <div class="form-group">
                <label for="klantAdres">Adres:</label>
                <input id="klantAdres" class="field" type="text" name="klantAdres" placeholder="Adres" value="<?php echo $klant['klantAdres']; ?>">
            </div>

            <div class="form-group">
                <label for="klantPostcode">Postcode:</label>
                <input id="klantPostcode" class="field" type="text" name="klantPostcode" placeholder="Postcode" value="<?php echo $klant['klantPostcode']; ?>">
            </div>

            <div class="form-group">
                <label for="klantWoonPlaats">Woonplaats:</label>
                <input id="klantWoonPlaats" class="field" type="text" name="klantWoonplaats" placeholder="Woonplaats" value="<?php echo $klant['klantWoonplaats']; ?>">
            </div>

            <input class="submit" type='submit' value='Bijwerken'>
        </form>
    </div>
</body>

</html>