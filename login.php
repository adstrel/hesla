<?php
// Start session
    session_start();

if(!isset($_SESSION["user_name"]))
    $_SESSION["user_name"] = null;

// Config. databáze
include_once("lib/config.php");
$link = pripojeni();
mquery($link, "SET NAMES 'uft8'");

// Zpracování přihlášení
$msg = "";
$prihlaseniProbehlo = false;
if(isset($_POST["name"]) && isset($_POST["pass1"]) && !empty($_POST["name"]) && !empty($_POST["pass1"]))
{
    $name = mysqli_real_escape_string($link, $_POST["name"]);
    $pass = mysqli_real_escape_string($link, $_POST["pass1"]);
    
    $result = mquery($link, "SELECT hsh FROM testHesla WHERE user_name='$name'");
    $msg = "Zkontrolujte zadané údaje.";
    if(mysqli_num_rows($result) > 0)
    {
        $zaznam = mfetcharray($result);
        if(password_verify($pass, $zaznam["hsh"]))
        {
            $_SESSION["user_name"] = $name;
            $user_name = $name;
            $prihlaseniProbehlo = true;
            $msg = "Přihlášení proběhlo úspěšně.";
        }
    }
}
?>


<!doctype html>
<html>
    <head>
        <title>Ukázka - Přihlášení</title>
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
        <h1>Přihlášení</h1>
        <?php
            echo("<p>" . $msg . "</p>");
            if($_SESSION["user_name"] === null)
            {
        ?>
                <form action="login.php" method="post">
                    <table>
                        <tr>
                            <td>Uživatelské jméno: </td>
                            <td><input type="text" name="name" id="name" /></td>
                        </tr>
                        <tr>
                            <td>Heslo: </td>
                            <td><input type="password" name="pass1" id="pass1" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" /></td>
                        </tr>
                    </table>
                </form>
                <br />
        <?php
            }
            elseif(!$prihlaseniProbehlo)
                echo("<p>Přihlášený uživatel se znovu přihlásit nemůže.</p>");
        ?>
        
        <footer>
            Reklama:
            <br /><endora />
        </footer>
    </body>
</html>

<?php mclose($link); ?>