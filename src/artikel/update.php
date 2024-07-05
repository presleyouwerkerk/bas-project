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
$artikelInstance = new Artikel($connection);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artId = $_POST['artId'];

    $artikelData = [
        'artOmschrijving' => $_POST['artOmschrijving'],
        'artInkoop' => $_POST['artInkoop'],
        'artVerkoop' => $_POST['artVerkoop'],
        'artVoorraad' => $_POST['artVoorraad'],
        'artMinVoorraad' => $_POST['artMinVoorraad'],
        'artMaxVoorraad' => $_POST['artMaxVoorraad'],
        'artLocatie' => $_POST['artLocatie']
    ];

    if ($artikelInstance->updateArtikel($artId, $artikelData)) {
        header("Location: read.php");
        exit();
    } else {
        $errors[] = "Er is een fout opgetreden";
    }
}

if (isset($_GET['artId'])) {
    $artId = $_GET['artId'];
    $artikel = $artikelInstance->getArtikelById($artId);
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
    <?php include '../../public/nav.php'; ?>

    <div class="main-content">
        <h1 class="heading">Artikel bijwerken</h1>

        <?php foreach ($errors as $error) : ?>
            <?php echo '<p class="error">' . $error; ?>
        <?php endforeach; ?>

        <form method="POST" action="update.php">
            <input type="hidden" name="artId" value="<?php echo $artId; ?>">

            <div class="form-group">
                <label for="artOmschrijving">Artikel:</label>
                <input id="artOmschrijving" class="field" type="text" name="artOmschrijving" placeholder="Artikel" value="<?php echo $artikel['artOmschrijving']; ?>">
            </div>

            <div class="form-group">
                <label for="artInkoop">Inkoopprijs:</label>
                <input id="artInkoop" class="field" type="number" step="0.01" name="artInkoop" placeholder="Inkoopprijs" value="<?php echo $artikel['artInkoop']; ?>">
            </div>

            <div class="form-group">
                <label for="artVerkoop">Verkoopprijs:</label>
                <input id="artVerkoop" class="field" type="number" step="0.01" name="artVerkoop" placeholder="Verkoopprijs" value="<?php echo $artikel['artVerkoop']; ?>">
            </div>

            <div class="form-group">
                <label for="artVoorraad">Voorraad:</label>
                <input id="artVoorraad" class="field" type="number" name="artVoorraad" placeholder="Huidge voorraad" value="<?php echo $artikel['artVoorraad']; ?>">
            </div>

            <div class="form-group">
                <label for="artMinVoorraad">Minimum voorraad:</label>
                <input id="artMinVoorraad" class="field" type="number" name="artMinVoorraad" placeholder="Minimum voorraad" value="<?php echo $artikel['artMinVoorraad']; ?>">
            </div>

            <div class="form-group">
                <label for="artMaxVoorraad">Maximum voorraad:</label>
                <input id="artMaxVoorraad" class="field" type="number" name="artMaxVoorraad" placeholder="Maximum voorraad" value="<?php echo $artikel['artMaxVoorraad']; ?>">
            </div>

            <div class="form-group">
                <label for="artLocatie">Magazijn locatie:</label>
                <input id="artLocatie" class="field" type="number" name="artLocatie" placeholder="Magazijn locatie" value="<?php echo $artikel['artLocatie']; ?>">
            </div>

            <input class="submit" type='submit' value='Bijwerken'>
        </form>
    </div>
</body>

</html>