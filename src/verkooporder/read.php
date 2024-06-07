<?php
// read.php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;

$verkooporder = new Verkooporder();
$verkooporders = $verkooporder->selectVerkooporder();
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
    <table class="table">
        <thead>
            <tr>
                <th class="cell">Verkooporder ID</th>
                <th class="cell">Klant ID</th>
                <th class="cell">Artikel ID</th>
                <th class="cell">Datum</th>
                <th class="cell">Aantal</th>
                <th class="cell">Status</th>
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
                        <td class="cell"><?php echo $order['verkOrdStatus']; ?></td>
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