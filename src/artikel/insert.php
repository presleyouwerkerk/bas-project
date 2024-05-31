<?php
// insert.php

require '../../vendor/autoload.php';

use BasProject\classes\Artikel;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["insert"])) {
        $artikel = new Artikel();

        $artikel->artOmschrijving = $_POST['artOmschrijving'];
        $artikel->artInkoop = floatval($_POST['artInkoop']); 
        $artikel->artVerkoop = floatval($_POST['artVerkoop']);  
        $artikel->artVoorraad = intval($_POST['artVoorraad']);  
        $artikel->artMinVoorraad = intval($_POST['artMinVoorraad']);  
        $artikel->artMaxVoorraad = intval($_POST['artMaxVoorraad']);  
        $artikel->artLocatie = intval($_POST['artLocatie']);

        $errors = $artikel->validateInsertArtikel();

        if (empty($errors)) {
            if ($artikel->insertArtikel()) {
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
    <h1>Nieuw artikel</h1>
    <form method="post">
        <input type="text" name="artOmschrijving" placeholder="Artikel omschrijving" required />
        <br><br>
        <input type="number" step="0.01" name="artInkoop" placeholder="Inkoopprijs" required />
        <br><br>
        <input type="number" step="0.01" name="artVerkoop" placeholder="Verkoopprijs" required />
        <br><br>
        <input type="number" name="artVoorraad" placeholder="Huidige voorraad" required />
        <br><br>
        <input type="number" name="artMinVoorraad" placeholder="Minimale voorraad" required />
        <br><br>
        <input type="number" name="artMaxVoorraad" placeholder="Maximale voorraad" required />
        <br><br>
        <input type="number" name="artLocatie" placeholder="Locatie in het magazijn" required />
        <br><br>
        <input type='submit' name='insert' value='Submit'>
        <br><br>
        <a href='read.php'>Terug</a>
    </form>
</body>

</html>