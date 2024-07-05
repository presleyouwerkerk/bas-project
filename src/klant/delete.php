<?php

require '../../vendor/autoload.php';

use BasProject\classes\Klant;
use BasProject\classes\Connection;

session_start();

if (!isset($_SESSION['roleId']) || $_SESSION['roleId'] != 3) {
    header("Location: /bas-project/src/login/login.php");
    exit();
}

$connection = new Connection();
$klant = new Klant($connection);

if (isset($_POST['delete'])) {
    $klantId = $_POST['klantId'];
    $klant->deleteKlant($klantId);
    header("Location: read.php");
    exit();
}