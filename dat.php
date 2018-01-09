<?php
// Start the session
    session_start();

if(!isset($_SESSION["user_name"]))
    $_SESSION["user_name"] = null;


include_once("lib/config.php");
$link = pripojeni();
mquery($link, "SET NAMES 'uft8'");

?>


<!doctype html>
<html>
    <head>
        <title>Ukázka - Data</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <ul>
            <li><a href="index.php">Domů</a></li>
            <li><a href="info.php">Informace</a></li>
            <li><a href="hsh.php">Hashe</a></li>
            <?php
                if($_SESSION["user_name"]===null)
                {
            ?>
            <li class="right"><a href="reg.php">Registrace</a></li>
            <li class="right"><a href="login.php">Přihlášení</a></li>
            <?php 
                }

                if($_SESSION["user_name"]!==null)
                {
            ?>
            <li><a href="dat.php">Data</a></li>
            <li class="right"><a href="logout.php">Odhlášení</a></li>
            <?php 
                } 
            ?>
        </ul>
        
        <h1>Data</h1>
        <p>
            <?php
                if($_SESSION["user_name"] === null)
                    echo("Tato stránka je přístupná jen přihlášeným uživatelům.");
                else
                {
                    $vysledek = mquery($link, "SELECT ID, jmeno, prijmeni FROM osoba");    

                    echo("<table>");
                    while ($zaznam = mfetcharray($vysledek))
                    {
                        echo("<tr>");
                        echo("<td>" . $zaznam["ID"] . ".</td>");
                        echo("<td>" . $zaznam["jmeno"] . "</td>");
                        echo("<td>" . $zaznam["prijmeni"] . "</td>");
                        echo("</tr>");
                    }
                    echo("</table>");
                }
            ?>
        </p>
        <footer>
            Reklama:
            <br /><endora />
        </footer>
    </body>
</html>

<?php mclose($link); ?>