<?php

require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

session_start();

if (!isset($_SESSION['roleId']) || ($_SESSION['roleId'] != 1 && $_SESSION['roleId'] != 3)) {
    header("Location: /bas-project/src/login/login.php");
    exit();
}

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

if (isset($_POST['delete'])) {
    $verkOrdId = $_POST['verkOrdId'];
    $verkooporder->deleteVerkooporder($verkOrdId);
    header("Location: read.php");
    exit();
}
