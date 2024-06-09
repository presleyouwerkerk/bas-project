<?php
require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;

$verkooporder = new Verkooporder();
$artikelen = $verkooporder->getAllArtikelen();
$klanten = $verkooporder->getAllKlanten();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $klantId = isset($_POST['klantId']) ? $_POST['klantId'] : null;
        $verkooporder->klantId = $klantId;
        $artId = isset($_POST['artId']) ? $_POST['artId'] : null;
        $verkooporder->artId = $artId;
        $verkooporder->verkOrdBestAantal = $_POST['verkOrdBestAantal'];
        $verkooporder->verkOrdDatum = $_POST['verkOrdDatum'];
        $verkooporder->verkOrdStatus = $_POST['verkOrdStatus'];

        $errors = $verkooporder->validateInsertVerkooporder();

        if (empty($errors)) {
            if ($verkooporder->insertVerkooporder()) {
                header("Location: read.php");
                exit;
            } else {
                $errors[] = "Insertion failed";
            }
        }
    }
}

if (!empty($errors)) {
    echo '<p style="margin-left: 20px;">' . implode($errors) . '</p>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Verkooporders</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <h1 class="heading">Nieuwe verkooporder</h1>
    <form method="post">
        <select class="field" name="klantId">
            <option value="" disabled selected hidden>Klant</option>
            <?php foreach ($klanten as $klant) : ?>
                <option value="<?php echo $klant['klantId']; ?>"><?php echo $klant['klantNaam']; ?></option>
            <?php endforeach; ?>
        </select>

        <select class="field" name="artId">
            <option value="" disabled selected hidden>Artikel</option>
            <?php foreach ($artikelen as $artikel) : ?>
                <option value="<?php echo $artikel['artId']; ?>"><?php echo $artikel['artOmschrijving']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <input class="field" type="number" name="verkOrdBestAantal" placeholder="Aantal" min="0">
        <input class="field" type="date" name="verkOrdDatum">
        <input class="field" type="number" name="verkOrdStatus" placeholder="Status" min="0">
        <button class="field" type="submit" name="submit">Submit</button>
    </form>
    <a href='read.php' class="link">Terug</a>
</body>

</html>