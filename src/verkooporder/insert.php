<?php
require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

$artikelen = $verkooporder->getAllArtikelen();
$klanten = $verkooporder->getAllKlanten();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klantId = isset($_POST['klantId']) ? $_POST['klantId'] : null;
    $verkooporder->klantId = $klantId;
    $artId = isset($_POST['artId']) ? $_POST['artId'] : null;
    $verkooporder->artId = $artId;
    $verkooporder->verkOrdBestAantal = $_POST['verkOrdBestAantal'];
    $verkooporder->verkOrdDatum = $_POST['verkOrdDatum'];

    $errors = $verkooporder->validateVerkooporder();

    if (empty($errors)) {
        if ($verkooporder->insertVerkooporder()) {
            header("Location: read.php");
            exit;
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
    <title>Nieuwe verkooporder</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.html'; ?>

    <div class="main-content">
        <h1 class="heading">Nieuwe verkooporder</h1>

        <?php foreach ($errors as $error) : ?>
            <?php echo '<p class="error">' . $error; ?>
        <?php endforeach; ?>

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-group">
                <label for="klantId">Klant:</label>
                <select id="klantId" class="field" name="klantId">
                    <option value="" disabled selected hidden>Klant</option>
                    <?php foreach ($klanten as $klant) : ?>
                        <option value="<?php echo $klant['klantId']; ?>"><?php echo $klant['klantNaam']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="artId">Artikel:</label>
                <select id="artId" class="field" name="artId">
                    <option value="" disabled selected hidden>Artikel</option>
                    <?php foreach ($artikelen as $artikel) : ?>
                        <option value="<?php echo $artikel['artId']; ?>"><?php echo $artikel['artOmschrijving']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="verkOrdBestAantal">Aantal:</label>
                <input id="verkOrdbestAantal" class="field" type="number" name="verkOrdBestAantal" placeholder="Aantal">
            </div>

            <div class="form-group">
                <label for="verkOrdDatum">Datum:</label>
                <input id="verkOrdDatum" class="field" type="date" name="verkOrdDatum">
            </div>

            <input class="submit" type="submit" value="Submit">
        </form>
    </div>
</body>

</html>