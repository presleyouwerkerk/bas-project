<?php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

session_start();

if (!isset($_SESSION['roleId']) || $_SESSION['roleId'] != 3) {
    header("Location: /bas-project/src/login/login.php");
    exit();
}

$connection = new Connection();
$klantInstance = new Klant($connection);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchTerm)) {
    $klanten = $klantInstance->searchKlant($searchTerm);
} else {
    $klanten = $klantInstance->selectKlant();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.php'; ?>

    <div class="main-content">
        <h1 class="heading">Klanten</h1>

        <table>
            <tr>
                <th class="cell" colspan="7">
                    <form method="GET" action="read.php">
                        <input class="search-field" type="text" name="search" placeholder="Zoek">
                        <input class="search-button" type="submit" value="">
                    </form>
                </th>
            </tr>
            <tr>
                <th class="cell">Klant</th>
                <th class="cell">Email</th>
                <th class="cell">Adres</th>
                <th class="cell">Postcode</th>
                <th class="cell">Woonplaats</th>
                <th class="cell"></th>
                <th class="cell"></th>
            </tr>
            <?php if (!empty($klanten)) : ?>
                <?php foreach ($klanten as $klant) : ?>
                    <tr>
                        <td class="cell"><?php echo $klant['klantNaam']; ?></td>
                        <td class="cell"><?php echo $klant['klantEmail']; ?></td>
                        <td class="cell"><?php echo $klant['klantAdres']; ?></td>
                        <td class="cell"><?php echo $klant['klantPostcode']; ?></td>
                        <td class="cell"><?php echo $klant['klantWoonplaats']; ?></td>
                        <td class="cell">
                            <form action="update.php" method="GET">
                                <input type="hidden" name="klantId" value="<?php echo $klant['klantId']; ?>">
                                <input type="submit" value="Bijwerken" class="update-button">
                            </form>
                        </td>
                        <td class="cell">
                            <form action="delete.php" method="POST">
                                <input type="hidden" name="klantId" value="<?php echo $klant['klantId']; ?>">
                                <input type="submit" name="delete" value="Verwijder" class="delete-button">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td class="cell" colspan="7">Geen klant gevonden</td>
                </tr>
            <?php endif; ?>
        </table>

        <a class="link" href="create.php">Nieuwe klant</a>
    </div>
</body>

</html>