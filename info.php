<?php
// Start session
    session_start();

if(!isset($_SESSION["user_name"]))
    $_SESSION["user_name"] = null;

// Config. databáze
include_once("lib/config.php");
$link = pripojeni();
mquery($link, "SET NAMES 'uft8'");
?>


<!doctype html>
<html>
    <head>
        <title>Ukázka - Informace</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <ul>
            <li><a href="index.php">Domů</a></li>
            <li><a href="info.php">Informace</a></li>
            <li><a href="hsh.php">Hashe</a></li>
            <?php
                if($_SESSION["user_name"] === null)
                {
            ?>
            <li class="right"><a href="reg.php">Registrace</a></li>
            <li class="right"><a href="login.php">Přihlášení</a></li>
            <?php 
                }

                if($_SESSION["user_name"] !== null)
                {
            ?>
            <li><a href="dat.php">Data</a></li>
            <li class="right"><a href="logout.php">Odhlášení</a></li>
            <?php 
                } 
            ?>
        </ul>
        <h1>Informace</h1>
        <p>
            <?php
                $result = mquery($link, "SELECT COUNT(*) FROM testHesla");
                $zaznam = mfetcharray($result);

                echo("Celkový počet zaregistrovaných účtů: " . $zaznam["COUNT(*)"] . "<br />");
            
                if($_SESSION["user_name"] === null)
                    echo("V tuto chvíli nejste přihlášen.");
                else
                    echo("Jméno přihlášeného uživatele je: " . $_SESSION["user_name"]);
            ?>
        </p>
        <footer>
            Reklama:
            <br /><endora />
        </footer>
    </body>
</html>

<?php mclose($link); ?>