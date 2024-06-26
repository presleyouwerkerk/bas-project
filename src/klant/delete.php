<?php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

$connection = new Connection();
$klantInstance = new Klant($connection);

if (isset($_POST['delete'])) {
    $klantId = $_POST['klantId'];
    $klantInstance->deleteKlant($klantId);
    header("Location: read.php");
    exit();
}