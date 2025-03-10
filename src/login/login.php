<?php

require '../../vendor/autoload.php';

use BasProject\classes\Connection;
use BasProject\classes\User;

session_start();

if (isset($_SESSION['roleId'])) {
    header("Location: /bas-project/public/index.php");
    exit();
}

$errors = [];

$connection = new Connection();
$user = new User($connection);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userData = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    $errors = $user->validateUser($userData);

    if (empty($errors)) {
        if ($user->loginUser($userData)) {
            switch ($_SESSION['roleId']) {
                case 1:
                    header("Location: ../verkooporder/read.php");
                    break;
                case 2:
                    header("Location: ../artikel/read.php");
                    break;
                case 3:
                    header("Location: ../klant/read.php");
                    break;
                case 4:
                    header("Location: ../artikel/read.php");
                    break;
            }
            exit();
        } else {
            $errors[] = "Invalid credentials";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include '../../public/nav.php'; ?>

    <div class="main-content">
        <h1 class="heading">Inloggen</h1>

        <?php foreach ($errors as $error) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endforeach; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="field" placeholder="Username">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="field" placeholder="Password">
            </div>

            <input type="submit" value="Inloggen" class="submit">
        </form>
    </div>
</body>

</html>