<?php
// insert.php

require '../../vendor/autoload.php';

use BasProject\classes\Artikel;
use BasProject\classes\Connection;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["submit"])) {
        $connection = new Connection();
        $artikel = new Artikel($connection);

        $artikel->artOmschrijving = $_POST['artOmschrijving'];
        $artikel->artInkoop = $_POST['artInkoop'];
        $artikel->artVerkoop = $_POST['artVerkoop'];
        $artikel->artVoorraad = $_POST['artVoorraad'];
        $artikel->artMinVoorraad = $_POST['artMinVoorraad'];
        $artikel->artMaxVoorraad = $_POST['artMaxVoorraad'];
        $artikel->artLocatie = $_POST['artLocatie'];

        $errors = $artikel->validateArtikel();

        if (empty($errors)) {
            if ($artikel->insertArtikel()) {
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
        echo '<p class="error">' . implode('<br>', $errors) . '</p>';
    }
    ?>

    <h1 class="heading">Nieuw artikel</h1>
    <form method="post">
        <input class="field" type="text" name="artOmschrijving" placeholder="Artikel omschrijving">
        <input class="field" type="number" step="0.01" name="artInkoop" placeholder="Inkoopprijs">
        <input class="field" type="number" step="0.01" name="artVerkoop" placeholder="Verkoopprijs">
        <input class="field" type="number" name="artVoorraad" placeholder="Huidige voorraad">
        <input class="field" type="number" name="artMinVoorraad" placeholder="Minimale voorraad">
        <input class="field" type="number" name="artMaxVoorraad" placeholder="Maximale voorraad">
        <input class="field" type="number" name="artLocatie" placeholder="Locatie">
        <input class="submit" type='submit' name='submit' value='Submit'>
    </form>
</body>

</html>