<?php
require '../../vendor/autoload.php';

use BasProject\classes\Connection;
use BasProject\classes\User;

session_start();

$connection = $connection = new Connection();
$user = new User($connection, $rolNaam, $rolWachtwoord);

$user->logout();

header("Location: login.php");
exit();