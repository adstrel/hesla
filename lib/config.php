<?php

include_once("connect.php");

function pripojeni()
{
	global $muj_server;
	global $uzivatel;
	global $a1234;
	global $databaze;
	$link = mysqli_connect($muj_server, $uzivatel, $a1234, $databaze);
	
	if(!$link)
	{
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
    	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    	echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    	exit;
	}
	
	return $link;
}


function mquery($link, $dotaz)
{
  return mysqli_query($link, $dotaz);
}

function mfetcharray($vysledek)
{
  return mysqli_fetch_array($vysledek);
}

function mclose($link)
{
  mysqli_close($link);
}

?>