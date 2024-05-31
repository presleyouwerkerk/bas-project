<?php
// select.php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;

$verkooporder = new Verkooporder();
$verkooporders = $verkooporder->selectOrder();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkooporders</title>
    <link rel="stylesheet" href="../../public/css/verkooporder.css">
</head>

<body>
    <h1>Verkooporders</h1>
    <table>
        <thead>
            <tr>
                <th>Verkooporder ID</th>
                <th>Klant ID</th>
                <th>Artikel ID</th>
                <th>Datum</th>
                <th>Aantal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($verkooporders)): ?>
                <?php foreach ($verkooporders as $order): ?>
                    <tr>
                        <td><?php echo $order['verkOrdId']; ?></td>
                        <td><?php echo $order['klantId']; ?></td>
                        <td><?php echo $order['artId']; ?></td>
                        <td><?php echo $order['verkOrdDatum']; ?></td>
                        <td><?php echo $order['verkOrdBestAantal']; ?></td>
                        <td><?php echo $order['verkOrdStatus']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Geen verkooporders gevonden.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href='../../public/index.html'>Terug</a>
</body>

</html>