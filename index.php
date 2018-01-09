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
		
		<h1>Hlavní stránka</h1>
		<p>
			Tato stránka je pomůckou pro ukázání zpracovávání a práce s hesly. 
			Source code <a href="source.zip">ZDE</a>.
		</p>
		
		<footer>
			Reklama:
			<br /><endora />
		</footer>
	</body>
</html>

<?php mclose($link); ?>