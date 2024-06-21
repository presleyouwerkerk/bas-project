<?php
require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

$connection = new Connection();
$klantInstance = new Klant($connection);

$errors = [];

if (isset($_GET['klantId'])) {
    $klantId = $_GET['klantId'];
    $klant = $klantInstance->getKlantById($klantId);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $klantId = $_POST['klantId'];
    $klantInstance->klantNaam = $_POST['klantNaam'];
    $klantInstance->klantEmail = $_POST['klantEmail'];
    $klantInstance->klantAdres = $_POST['klantAdres'];
    $klantInstance->klantPostcode = $_POST['klantPostcode'];
    $klantInstance->klantWoonplaats = $_POST['klantWoonplaats'];

    if ($klantInstance->updateKlant($klantId)) {
        header("Location: read.php");
        exit();
    } else {
        $errors[] = "Er is een fout opgetreden bij het bijwerken van de klantgegevens";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant bijwerken</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php
    include '../../public/index.html';

    if (!empty($errors)) {
        echo '<p class="error">' . implode($errors) . '</p>';
    }
    ?>

    <h1 class="heading">Klant bijwerken</h1>
    <form class="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="klantId" value="<?php echo $klantId; ?>">
        <input class="field" type="text" name="klantNaam" placeholder="Naam" value="<?php echo $klant['klantNaam']; ?>">
        <input class="field" type="text" name="klantEmail" placeholder="Email" value="<?php echo $klant['klantEmail']; ?>">
        <input class="field" type="text" name="klantAdres" placeholder="Adres" value="<?php echo $klant['klantAdres']; ?>">
        <input class="field" type="text" name="klantPostcode" placeholder="Postcode" value="<?php echo $klant['klantPostcode']; ?>">
        <input class="field" type="text" name="klantWoonplaats" placeholder="Woonplaats" value="<?php echo $klant['klantWoonplaats']; ?>">
        <input class="submit" type='submit' value='Submit'>
    </form>

</body>

</html>