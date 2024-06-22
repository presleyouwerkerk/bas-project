<?php
// update.php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

$errors = [];

if (isset($_GET['verkOrdId'])) {
    $verkOrdId = $_GET['verkOrdId'];
    $order = $verkooporder->getVerkooporderById($verkOrdId);
    $klanten = $verkooporder->getAllKlanten();
    $artikelen = $verkooporder->getAllArtikelen();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verkOrdId = $_POST['verkOrdId'];
    $verkooporder->klantId = $_POST['klantId'];
    $verkooporder->artId = $_POST['artId'];
    $verkooporder->verkOrdDatum = $_POST['verkOrdDatum'];
    $verkooporder->verkOrdBestAantal = $_POST['verkOrdBestAantal'];
    $verkooporder->verkOrdStatus = $_POST['verkOrdStatus'];

    if ($verkooporder->updateVerkooporder($verkOrdId)) {
        header("Location: read.php");
        exit();
    } else {
        $errors[] = "Er is een fout opgetreden";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkooporder bijwerken</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/index.html'; ?>

    <?php foreach ($errors as $error) : ?>
        <?php echo '<p class="error">' . $error; ?>
    <?php endforeach; ?>

    <h1 class="heading">Verkooporder bijwerken</h1>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="verkOrdId" value="<?php echo $verkOrdId; ?>">

        <div class="form-group">
            <label for="klantId">Klant:</label>
            <select id="klantId" name="klantId" class="update-field">
                <?php foreach ($klanten as $klant) : ?>
                    <option value="<?php echo $klant['klantId']; ?>" <?php echo $klant['klantId'] == $order['klantId'] ? 'selected' : ''; ?>>
                        <?php echo $klant['klantNaam']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="artId">Artikel:</label>
            <select id="artId" name="artId" class="update-field">
                <?php foreach ($artikelen as $artikel) : ?>
                    <option value="<?php echo $artikel['artId']; ?>" <?php echo $artikel['artId'] == $order['artId'] ? 'selected' : ''; ?>>
                        <?php echo $artikel['artOmschrijving']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="verkOrdDatum">Datum:</label>
            <input id="verkOrdDatum" name="verkOrdDatum" class="update-field" type="date" value="<?php echo $order['verkOrdDatum']; ?>">
        </div>

        <div class="form-group">
            <label for="verkOrdBestAantal">Aantal:</label>
            <input id="verkOrdBestAantal" name="verkOrdBestAantal" class="update-field" type="number" value="<?php echo $order['verkOrdBestAantal']; ?>">
        </div>

        <div class="form-group">
            <label for="verkOrdStatus">Status:</label>
            <select id="verkOrdStatus" name="verkOrdStatus" class="update-field">
                <option value="Onderweg" <?php echo $order['verkOrdStatus'] == 'Onderweg' ? 'selected' : ''; ?>>Onderweg</option>
                <option value="Geleverd" <?php echo $order['verkOrdStatus'] == 'Geleverd' ? 'selected' : ''; ?>>Geleverd</option>
                <option value="Geannuleerd" <?php echo $order['verkOrdStatus'] == 'Geannuleerd' ? 'selected' : ''; ?>>Geannuleerd</option>
            </select>
        </div>

        <input type='submit' class="submit" value='Bijwerken'>
    </form>

</body>

</html>