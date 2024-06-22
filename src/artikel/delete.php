<?php
require '../../vendor/autoload.php';

use BasProject\classes\Artikel;
use BasProject\classes\Connection;

$connection = new Connection();
$artikelInstance = new Artikel($connection);

if (isset($_POST['delete'])) {
    $artId = $_POST['artId'];
    $artikelInstance->deleteArtikel($artId);
    header("Location: read.php");
    exit();
}