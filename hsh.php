<?php
// Start the session
    session_start();

if(!array_key_exists("user_name", $_SESSION))
    $_SESSION["user_name"] = null;

// Config. databáze
include_once("lib/config.php");
$link = pripojeni();
mquery($link, "SET NAMES 'uft8'");

?>


<!doctype html>
<html>
    <head>
        <title>Ukázka - Domů</title>
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
        
        <h1>Hashe</h1>
        <p>
            Zde si můžete vyzkoušet základní pricip hashování:
        </p>
        <form action="hsh.php" method="post">
            Výraz: <input type="text" name="text" /> <input type="submit" />
        </form>
        <br />
        <?php
            if(isset($_POST["text"]))        
            {
                ?>
                <table>
                    <tr>
                        <th>Název algoritmu</th>
                        <th>Hash</th>
                    </tr>
                    <tr>
                        <td>Seed</td>
                        <td><?php echo($_POST["text"]); ?></td>
                    </tr>
                    <tr>
                        <td class="red">md5</td>
                        <td><?php echo(md5($_POST["text"])); ?></td>
                    </tr>
                    <tr>
                        <td class="red">sha1</td>
                        <td><?php echo(sha1($_POST["text"])); ?></td>
                    </tr>
                    <tr>
                        <td class="yellow">blowfish</td>
                        <td><?php echo(crypt($_POST["text"], '$2a$07$saltsaltsaltsaltsaltsa')); ?></td>
                    </tr>
                    <tr>
                        <td class="green">Nativní php fce</td>
                        <td><?php echo(password_hash(($_POST["text"]), PASSWORD_DEFAULT)); ?></td>
                    </tr>
                </table>
                <?php
            }
        ?>
        <br />
        <footer>
            Reklama:
            <br /><endora />
        </footer>
    </body>
</html>

<?php mclose($link); ?>