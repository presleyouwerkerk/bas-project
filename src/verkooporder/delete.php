<?php
require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

if (isset($_POST['delete'])) {
    $verkOrdId = $_POST['verkOrdId'];
    $verkooporder->deleteVerkooporder($verkOrdId);
    header("Location: read.php");
    exit();
}
