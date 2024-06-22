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
    <title>CRUD klant</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/index.html'; ?>

    <h1 class="heading">CRUD Klant</h1>

    <form class="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input class="search-field" type="text" name="search" placeholder="Zoek">
        <input class="search-button" type="submit" value="">
    </form>

    <table class="table">
        <thead>
            <tr>
                <th class="cell">Klant</th>
                <th class="cell">Email</th>
                <th class="cell">Adres</th>
                <th class="cell">Postcode</th>
                <th class="cell">Woonplaats</th>
                <th class="cell"></th>
                <th class="cell"></th>
            </tr>
        </thead>
        <tbody>
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
                    <td class="cell" colspan="6">Geen klant gevonden</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="insert.php" class="link">Nieuwe klant</a>
</body>

</html>