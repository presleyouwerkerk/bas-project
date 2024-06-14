<?php
require '../../vendor/autoload.php';

use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

$connection = new Connection();
$verkooporder = new Verkooporder($connection);

$verkOrdId = $_POST['verkOrdId'];
$verkOrdStatus = $_POST['verkOrdStatus'];

if ($verkooporder->updateVerkooporderStatus($verkOrdId, $verkOrdStatus)) {
    header("Location: read.php");
    exit();
} else {
    echo "Error bijwerken verkooporderstatus.";
}
