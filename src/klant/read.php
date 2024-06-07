<?php
// read.php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;

$klant = new Klant();
$klanten = $klant->selectKlant();
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
    <h1 class="heading">CRUD Klant</h1>
    <table class="table">
        <thead>
            <tr>
                <th class="cell">Klant ID</th>
                <th class="cell">Naam</th>
                <th class="cell">Email</th>
                <th class="cell">Adres</th>
                <th class="cell">Postcode</th>
                <th class="cell">Woonplaats</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($klanten)): ?>
                <?php foreach ($klanten as $klant): ?>
                    <tr>
                        <td class="cell"><?php echo $klant['klantId']; ?></td>
                        <td class="cell"><?php echo $klant['klantNaam']; ?></td>
                        <td class="cell"><?php echo $klant['klantEmail']; ?></td>
                        <td class="cell"><?php echo $klant['klantAdres']; ?></td>
                        <td class="cell"><?php echo $klant['klantPostcode']; ?></td>
                        <td class="cell"><?php echo $klant['klantWoonplaats']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="cell" colspan="6">Geen klanten gevonden</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="insert.php" class="link">Nieuwe klant</a>
    <a href='../../public/index.html' class="link">Terug</a>
</body>

</html>