<?php
require '../../vendor/autoload.php';

use BasProject\classes\Connection;
use BasProject\classes\User;

session_start();

if (!isset($_SESSION['roleId'])) {
    header("Location: /bas-project/public/index.php");
    exit();
}

$connection = $connection = new Connection();
$user = new User($connection, $rolNaam, $rolWachtwoord);

$user->logout();

header("Location: login.php");
exit();