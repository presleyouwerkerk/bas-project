<?php
require '../../vendor/autoload.php';

use BasProject\classes\Artikel;
use BasProject\classes\Connection;

$connection = new Connection();
$artikelInstance = new Artikel($connection);

$errors = [];

if (isset($_GET['artId'])) {
    $artId = $_GET['artId'];
    $artikel = $artikelInstance->getArtikelById($artId);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artId = $_POST['artId'];
    $artikelInstance->artOmschrijving = $_POST['artOmschrijving'];
    $artikelInstance->artInkoop = $_POST['artInkoop'];
    $artikelInstance->artVerkoop = $_POST['artVerkoop'];
    $artikelInstance->artVoorraad = $_POST['artVoorraad'];
    $artikelInstance->artMinVoorraad = $_POST['artMinVoorraad'];
    $artikelInstance->artMaxVoorraad = $_POST['artMaxVoorraad'];
    $artikelInstance->artLocatie = $_POST['artLocatie'];

    if ($artikelInstance->updateArtikel($artId)) {
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
    <title>Artikel bijwerken</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/index.html'; ?>

    <?php foreach ($errors as $error) : ?>
        <?php echo '<p class="error">' . $error; ?>
    <?php endforeach; ?>

    <h1 class="heading">Artikel bijwerken</h1>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="artId" value="<?php echo $artId; ?>">

        <div class="form-group">
            <label for="artOmschrijving">Artikel:</label>
            <input id="artOmschrijving" class="field" type="text" name="artOmschrijving" placeholder="Omschrijving" value="<?php echo $artikel['artOmschrijving']; ?>">
        </div>

        <div class="form-group">
            <label for="artInkoop">Inkoopprijs:</label>
            <input id="artInkoop" class="field" type="number" step="0.01" name="artInkoop" placeholder="Inkoop" value="<?php echo $artikel['artInkoop']; ?>">
        </div>

        <div class="form-group">
            <label for="artVerkoop">Verkoopprijs:</label>
            <input id="artVerkoop" class="field" type="number" step="0.01" name="artVerkoop" placeholder="Verkoop" value="<?php echo $artikel['artVerkoop']; ?>">
        </div>

        <div class="form-group">
            <label for="artVoorraad">Voorraad:</label>
            <input id="artVoorraad" class="field" type="number" name="artVoorraad" placeholder="Voorraad" value="<?php echo $artikel['artVoorraad']; ?>">
        </div>

        <div class="form-group">
            <label for="artMinVoorraad">Minimum voorraad:</label>
            <input id="artMinVoorraad" class="field" type="number" name="artMinVoorraad" placeholder="Min Voorraad" value="<?php echo $artikel['artMinVoorraad']; ?>">
        </div>

        <div class="form-group">
            <label for="artMaxVoorraad">Maximum voorraad:</label>
            <input id="artMaxVoorraad" class="field" type="number" name="artMaxVoorraad" placeholder="Max Voorraad" value="<?php echo $artikel['artMaxVoorraad']; ?>">
        </div>

        <div class="form-group">
            <label for="artLocatie">Magazijn locatie:</label>
            <input id="artLocatie" class="field" type="number" name="artLocatie" placeholder="Locatie" value="<?php echo $artikel['artLocatie']; ?>">
        </div>

        <input class="submit" type='submit' value='Bijwerken'>
    </form>

</body>

</html>