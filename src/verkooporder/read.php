<?php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchTerm)) {
    $verkooporders = $verkooporder->searchVerkooporder($searchTerm);
} else {
    $verkooporders = $verkooporder->selectVerkooporder();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkooporders</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.html'; ?>

    <div class="main-content">
        <h1 class="heading">Verkooporders</h1>

        <table class="table">
            <tr>
                <th class="cell" colspan="7">
                    <form class="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input class="search-field" type="text" name="search" placeholder="Zoek">
                        <input class="search-button" type="submit" value="">
                    </form>
                </th>
            </tr>
            <?php if (!empty($verkooporders)) : ?>
                <tr>
                    <th class="cell">Klant</th>
                    <th class="cell">Artikel</th>
                    <th class="cell">Datum</th>
                    <th class="cell">Aantal</th>
                    <th class="cell" colspan="3">Status</th>
                </tr>
                <?php foreach ($verkooporders as $order) : ?>
                    <tr>
                        <td class="cell"><?php echo $order['klantNaam']; ?></td>
                        <td class="cell"><?php echo $order['artOmschrijving']; ?></td>
                        <td class="cell"><?php echo $order['verkOrdDatum']; ?></td>
                        <td class="cell"><?php echo $order['verkOrdBestAantal']; ?></td>
                        <td class="cell"><?php echo $order['verkOrdStatus']; ?></td>
                        <td class="cell">
                            <form action="update.php" method="GET">
                                <input type="hidden" name="verkOrdId" value="<?php echo $order['verkOrdId']; ?>">
                                <input type="submit" value="Bijwerken" class="button">
                            </form>
                        </td>
                        <td class="cell">
                            <form action="delete.php" method="POST">
                                <input type="hidden" name="verkOrdId" value="<?php echo $order['verkOrdId']; ?>">
                                <input type="submit" name="delete" value="Verwijder" class="button">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td class="cell">Geen verkooporders gevonden</td>
                </tr>
            <?php endif; ?>
        </table>

        <a href="insert.php" class="link">Nieuwe verkooporder</a>
    </div>
</body>

</html>