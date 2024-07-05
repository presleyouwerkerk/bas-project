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
$artikel = new Artikel($connection);

if (isset($_POST['delete'])) {
    $artId = $_POST['artId'];
    $artikel->deleteArtikel($artId);
    header("Location: read.php");
    exit();
}