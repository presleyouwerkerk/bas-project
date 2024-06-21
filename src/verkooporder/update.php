<?php
// update.php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

$verkOrdId = $_GET['verkOrdId']; 

$verkooporderData = $verkooporder->getVerkooporderById($verkOrdId);
$klanten = $verkooporder->getAllKlanten();
$artikelen = $verkooporder->getAllArtikelen();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klantId = $_POST['klantId'];
    $artId = $_POST['artId'];
    $verkOrdDatum = $_POST['verkOrdDatum'];
    $verkOrdBestAantal = $_POST['verkOrdBestAantal'];

    $verkooporder->klantId = $klantId;
    $verkooporder->artId = $artId;
    $verkooporder->verkOrdDatum = $verkOrdDatum;
    $verkooporder->verkOrdBestAantal = $verkOrdBestAantal;

    $errors = $verkooporder->validateVerkooporder();

    if (empty($errors)) {
        if ($verkooporder->updateVerkooporder($verkOrdId, $klantId, $artId)) {
            header("Location: read.php");
            exit();
        } else {
            $errors[] = "Failed to update verkooporder";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Verkooporder</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <?php include '../../public/index.html'; ?>
    
    <h1 class="heading">Update Verkooporder</h1>
    <?php if (!empty($errors)) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">

        <select id="klantId" name="klantId" class="field">
            <?php foreach ($klanten as $klant) : ?>
                <option value="<?php echo $klant['klantId']; ?>" <?php echo $klant['klantId'] == $verkooporderData['klantId'] ? 'selected' : ''; ?>>
                    <?php echo $klant['klantNaam']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select id="artId" name="artId" class="field">
            <?php foreach ($artikelen as $artikel) : ?>
                <option value="<?php echo $artikel['artId']; ?>" <?php echo $artikel['artId'] == $verkooporderData['artId'] ? 'selected' : ''; ?>>
                    <?php echo $artikel['artOmschrijving']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="date" id="verkOrdDatum" name="verkOrdDatum" class="field" value="<?php echo $verkooporderData['verkOrdDatum']; ?>">
 
        <input type="number" id="verkOrdBestAantal" name="verkOrdBestAantal" class="field" value="<?php echo $verkooporderData['verkOrdBestAantal']; ?>">

        <button type="submit" name="submit" class="submit">Update</button>
    </form>

</body>
</html>
