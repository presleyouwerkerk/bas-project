<?php
// update.php

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $errors[] = "Er is een fout opgetreden bij het bijwerken van het artikel";
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
    <?php
    include '../../public/index.html';

    if (!empty($errors)) {
        echo '<p class="error">' . implode($errors) . '</p>';
    }
    ?>

    <h1 class="heading">Artikel bijwerken</h1>
    <form class="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="artId" value="<?php echo $artId; ?>">
        <input class="field" type="text" name="artOmschrijving" placeholder="Omschrijving" value="<?php echo $artikel['artOmschrijving']; ?>">
        <input class="field" type="number" step="0.01" name="artInkoop" placeholder="Inkoop" value="<?php echo $artikel['artInkoop']; ?>">
        <input class="field" type="number" step="0.01" name="artVerkoop" placeholder="Verkoop" value="<?php echo $artikel['artVerkoop']; ?>">
        <input class="field" type="number" name="artVoorraad" placeholder="Voorraad" value="<?php echo $artikel['artVoorraad']; ?>">
        <input class="field" type="number" name="artMinVoorraad" placeholder="Min Voorraad" value="<?php echo $artikel['artMinVoorraad']; ?>">
        <input class="field" type="number" name="artMaxVoorraad" placeholder="Max Voorraad" value="<?php echo $artikel['artMaxVoorraad']; ?>">
        <input class="field" type="number" name="artLocatie" placeholder="Locatie" value="<?php echo $artikel['artLocatie']; ?>">
        <input class="submit" type='submit' value='Submit'>
    </form>

</body>

</html>
