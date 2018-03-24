<?php

date_default_timezone_set("Europe/Paris");
try
{
	$bdd = new PDO('mysql:dbname=hypertube;host=localhost;charset=utf8', 'root', 'root');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
}
catch (Exception $e)
{
	print "Erreur !: " . $e->getMessage() . "<br/>";
	exit;
}

include "lang/english";
include "lang/french";

session_start();
?>
