<?php

require '../../vendor/autoload.php';

use BasProject\classes\Artikel;
use BasProject\classes\Connection;

session_start();

if (!isset($_SESSION['roleId']) || ($_SESSION['roleId'] != 2 && $_SESSION['roleId'] != 4)) {
    header("Location: /bas-project/src/login/login.php");
    exit();
}

$errors = [];

$connection = new Connection();
$artikel = new Artikel($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $artikelData = [
        'artOmschrijving' => $_POST['artOmschrijving'],
        'artInkoop' => $_POST['artInkoop'],
        'artVerkoop' => $_POST['artVerkoop'],
        'artVoorraad' => $_POST['artVoorraad'],
        'artMinVoorraad' => $_POST['artMinVoorraad'],
        'artMaxVoorraad' => $_POST['artMaxVoorraad'],
        'artLocatie' => $_POST['artLocatie']
    ];

    $errors = $artikel->validateArtikel($artikelData);

    if (empty($errors)) {
        if ($artikel->insertArtikel($artikelData)) {
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
    <title>Nieuw artikel</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.php'; ?>

    <div class="main-content">
        <h1 class="heading">Nieuw artikel</h1>

        <?php foreach ($errors as $error) : ?>
            <?php echo '<p class="error">' . $error; ?>
        <?php endforeach; ?>

        <form method="POST" action="create.php">
            <div class="form-group">
                <label for="artOmschrijving">Artikel:</label>
                <input id="artOmschrijving" class="field" type="text" name="artOmschrijving" placeholder="Artikel">
            </div>

            <div class="form-group">
                <label for="artInkoop">Inkoopprijs:</label>
                <input id="artInkoop" class="field" type="number" step="0.01" name="artInkoop" placeholder="Inkoopprijs">
            </div>

            <div class="form-group">
                <label for="artVerkoop">Verkoopprijs:</label>
                <input id="artVerkoop" class="field" type="number" step="0.01" name="artVerkoop" placeholder="Verkoopprijs">
            </div>

            <div class="form-group">
                <label for="artVoorraad">Huidige voorraad:</label>
                <input id="artVoorraad" class="field" type="number" name="artVoorraad" placeholder="Huidige voorraad">
            </div>

            <div class="form-group">
                <label for="artMinVoorraad">Minimum voorraad:</label>
                <input id="artMinVoorraad" class="field" type="number" name="artMinVoorraad" placeholder="Minimum voorraad">
            </div>

            <div class="form-group">
                <label for="artMaxVoorraad">Maximum voorraad:</label>
                <input id="artMaxVoorraad" class="field" type="number" name="artMaxVoorraad" placeholder="Maximum voorraad">
            </div>

            <div class="form-group">
                <label for="artLocatie">Magazijn locatie:</label>
                <input id="artLocatie" class="field" type="number" name="artLocatie" placeholder="Magazijn locatie">
            </div>

            <input class="submit" type="submit" value="Submit">
        </form>
    </div>
</body>

</html>