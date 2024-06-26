<?php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

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
    <?php include '../../public/nav.html'; ?>

    <div class="main-content">
        <h1 class="heading">Klanten</h1>

        <table>
            <tr>
                <th class="cell" colspan="7">
                    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input class="search-field" type="text" name="search" placeholder="Zoek">
                        <input class="search-button" type="submit" value="">
                    </form>
                </th>
            </tr>
            <?php if (!empty($klanten)) : ?>
                <tr>
                    <th class="cell">Klant</th>
                    <th class="cell">Email</th>
                    <th class="cell">Adres</th>
                    <th class="cell">Postcode</th>
                    <th class="cell" colspan="3">Woonplaats</th>
                </tr>
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
                                <input type="submit" value="Bijwerken" class="button">
                            </form>
                        </td>
                        <td class="cell">
                            <form action="delete.php" method="POST">
                                <input type="hidden" name="klantId" value="<?php echo $klant['klantId']; ?>">
                                <input type="submit" name="delete" value="Verwijder" class="button">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td class="cell">Geen klant gevonden</td>
                </tr>
            <?php endif; ?>
        </table>

        <a class="link" href="insert.php">Nieuwe klant</a>
    </div>
</body>

</html>