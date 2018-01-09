<?php
// Start session
    session_start();

if(!isset($_SESSION["user_name"]))
    $_SESSION["user_name"] = null;

// Config. databáze
include_once("lib/config.php");
$link = pripojeni();
mquery($link, "SET NAMES 'uft8'");

// Zpracování registrace
$msg = "";
if(isset($_POST["name"]) && isset($_POST["pass1"]) && isset($_POST["pass2"]) && !empty($_POST["name"]) && !empty($_POST["pass1"]) && !empty($_POST["pass2"]))
{
    $_POST["name"] = (string)$_POST["name"];
    $_POST["pass1"] = (string)$_POST["pass1"];
    $_POST["pass2"] = (string)$_POST["pass2"];
    
    $everythingIsAllRight = true;
    if(strlen($_POST["name"]) < 2 || strlen($_POST["name"]) > 50)
    {
        $everythingIsAllRight = false;
        $msg = $msg . "Uživatelské jméno musí být mezi 2 a 50 znaky dlouhé. ";
    }
    if(strlen($_POST["pass1"]) < 5 || strlen($_POST["pass1"] > 72))// min. alespoň 10 znaků!
    {
        $everythingIsAllRight = false;
        $msg = $msg . "Heslo musí být mezi 10 a 72 znaky dlouhé. ";
    }
    if($_POST["pass1"] != $_POST["pass2"])
    {
        $everythingIsAllRight = false;
        $msg = $msg . "Zadaná hesla se musí shodovat. ";
    }
    
    if($everythingIsAllRight)
    {
        $name = mysqli_real_escape_string($link, $_POST["name"]);
        $pass = mysqli_real_escape_string($link, password_hash(($_POST["pass1"]), PASSWORD_DEFAULT));
        
        $result = mquery($link, "SELECT COUNT(*) FROM testHesla WHERE user_name='$name'");
        $zaznam = mfetcharray($result);
        if($zaznam["COUNT(*)"] > 0)
            $msg = $msg . "Uživatelské jméno už existuje.";
        else
        {
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO testHesla (user_name, hsh, joined) VALUES ('$name', '$pass', '$date')";
            mquery($link, $sql);
            $msg = $msg . "Registrace proběhla úspěšně.";
        }
    }
}
?>


<!doctype html>
<html>
    <head>
        <title>Ukázka - Registrace</title>
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
        <h1>Registrace</h1>
        <?php
            echo($msg . "<br />");
            if($_SESSION["user_name"] === null)
            {
        ?>
                <form action="reg.php" method="post">
                    <table>
                        <tr>
                            <td>Uživatelské jméno: </td>
                            <td><input type="text" name="name" /></td>
                        </tr>
                        <tr>
                            <td>Heslo: </td>
                            <td><input type="password" name="pass1" /></td>
                        </tr>
                        <tr>
                            <td>Heslo znovu: </td>
                            <td><input type="password" name="pass2" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" /></td>
                        </tr>
                    </table>
                </form>
                <br />
        <?php
            }
            else
                echo("Přihlášený uživatel se registrovat nemůže. <br />");
        ?>
        
        <footer>
            Reklama:
            <br /><endora />
        </footer>
    </body>
</html>

<?php mclose($link); ?>