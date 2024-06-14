<?php
// read.php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

if (isset($_POST['delete'])) {
    $verkOrdId = $_POST['verkOrdId'];
    $verkooporder->deleteVerkooporder($verkOrdId);
}

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
    <title>CRUD Verkooporders</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <h1 class="heading">CRUD Verkooporders</h1>

    <form class="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input class="search-field" type="text" name="search" placeholder="Zoek">
        <input class="search-button" type="submit" value="">
    </form>

    <table class="table">
        <thead>
            <tr>
                <th class="cell">Verkooporder ID</th>
                <th class="cell">Klant ID</th>
                <th class="cell">Artikel ID</th>
                <th class="cell">Datum</th>
                <th class="cell">Aantal</th>
                <th class="cell">Status</th>
                <th class="cell"></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($verkooporders)) : ?>
                <?php foreach ($verkooporders as $order) : ?>
                    <tr>    
                        <td class="cell"><?php echo $order['verkOrdId']; ?></td>
                        <td class="cell"><?php echo $order['klantId']; ?></td>
                        <td class="cell"><?php echo $order['artId']; ?></td>
                        <td class="cell"><?php echo $order['verkOrdDatum']; ?></td>
                        <td class="cell"><?php echo $order['verkOrdBestAantal']; ?></td>
                        <td class="cell">
                            <form action="orderstatus.php" method="POST">
                                <input type="hidden" name="verkOrdId" value="<?php echo $order['verkOrdId']; ?>">
                                <select class="dropdown" name="verkOrdStatus" onchange="this.form.submit()">
                                    <option value="Onderweg" <?php echo ($order['verkOrdStatus'] == 'Onderweg') ? 'selected' : ''; ?>>Onderweg</option>
                                    <option value="Geleverd" <?php echo ($order['verkOrdStatus'] == 'Geleverd') ? 'selected' : ''; ?>>Geleverd</option>
                                    <option value="Geannuleerd" <?php echo ($order['verkOrdStatus'] == 'Geannuleerd') ? 'selected' : ''; ?>>Geannuleerd</option>
                                </select>
                            </form>
                        </td>
                        <td class="cell">
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="verkOrdId" value="<?php echo $order['verkOrdId']; ?>">
                                <input type="submit" name="delete" value="Verwijder" class="delete-button">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td class="cell" colspan="6">Geen verkooporders gevonden</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="insert.php" class="link">Nieuwe verkooporder</a>
    <a href='../../public/index.html' class="link">Terug</a>
</body>

</html>