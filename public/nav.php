<nav>
    <ul>
        <li><a href="/bas-project/public/index.php">Bas</a></li>
        
        <?php if (isset($_SESSION['roleId']) && $_SESSION['roleId'] == 3) : ?>
            <li><a href="/bas-project/src/klant/read.php">Klanten</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['roleId']) && ($_SESSION['roleId'] == 2 || $_SESSION['roleId'] == 4)) : ?>
            <li><a href="/bas-project/src/artikel/read.php">Artikelen</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['roleId']) && ($_SESSION['roleId'] == 1 || $_SESSION['roleId'] == 3)) : ?>
            <li><a href="/bas-project/src/verkooporder/read.php">Verkooporders</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['roleId'])) : ?>
            <li><a href="/bas-project/src/login/logout.php">Uitloggen</a></li>
        <?php else: ?>
            <li><a href="/bas-project/src/login/login.php">Inloggen</a></li>
        <?php endif; ?>
    </ul>
</nav>
