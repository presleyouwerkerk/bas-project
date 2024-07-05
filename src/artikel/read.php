<?php

require '../../vendor/autoload.php';

use BasProject\classes\Artikel;
use BasProject\classes\Connection;

session_start();

if (!isset($_SESSION['roleId']) || ($_SESSION['roleId'] != 2 && $_SESSION['roleId'] != 4)) {
    header("Location: /bas-project/src/login/login.php");
    exit();
}

$connection = new Connection();
$artikelInstance = new Artikel($connection);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchTerm)) {
    $artikelen = $artikelInstance->searchArtikel($searchTerm);
} else {
    $artikelen = $artikelInstance->selectArtikel();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikelen</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.php'; ?>

    <div class="main-content">
        <h1 class="heading">Artikelen</h1>

        <table>
            <tr>
                <th class="cell" colspan="9">
                    <form class="search-form" method="GET" action="read.php">
                        <input class="search-field" type="text" name="search" placeholder="Zoek">
                        <input class="search-button" type="submit" value="">
                    </form>
                </th>
            </tr>
            <tr>
                <th class="cell">Artikel</th>
                <th class="cell">Inkoopprijs</th>
                <th class="cell">Verkoopprijs</th>
                <th class="cell">Huidige voorraad</th>
                <th class="cell">Minimum voorraad</th>
                <th class="cell">Maximum voorraad</th>
                <th class="cell">Magazijn locatie</th>
                <th class="cell"></th>
                <th class="cell"></th>
            </tr>
            <?php if (!empty($artikelen)) : ?>
                <?php foreach ($artikelen as $artikel) : ?>
                    <tr>
                        <td class="cell"><?php echo $artikel['artOmschrijving']; ?></td>
                        <td class="cell"><?php echo $artikel['artInkoop']; ?></td>
                        <td class="cell"><?php echo $artikel['artVerkoop']; ?></td>
                        <td class="cell"><?php echo $artikel['artVoorraad']; ?></td>
                        <td class="cell"><?php echo $artikel['artMinVoorraad']; ?></td>
                        <td class="cell"><?php echo $artikel['artMaxVoorraad']; ?></td>
                        <td class="cell"><?php echo $artikel['artLocatie']; ?></td>
                        <td class="cell">
                            <form action="update.php" method="GET">
                                <input type="hidden" name="artId" value="<?php echo $artikel['artId'] ?>">
                                <input type="submit" value="Bijwerken" class="update-button">
                            </form>
                        </td>
                        <td class="cell">
                            <form action="delete.php" method="POST">
                                <input type="hidden" name="artId" value="<?php echo $artikel['artId']; ?>">
                                <input type="submit" name="delete" value="Verwijder" class="delete-button">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td class="cell" colspan="9">Geen artikelen gevonden</td>
                </tr>
            <?php endif; ?>
        </table>

        <a href="create.php" class="link">Nieuw artikel</a>
    </div>
</body>

</html>