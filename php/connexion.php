<?php

date_default_timezone_set("Europe/Paris");
try
{
	$bdd = new PDO('mysql:dbname=hypertube;host=127.0.0.1;charset=utf8', 'root', 'root');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
}
catch (Exception $e)
{
	header('Location: /error.php');
	exit;
}

session_start();

if (!isset($_SESSION['id']))
	$_SESSION['id'] = "";
if (!isset($_SESSION['login']))
	$_SESSION['login'] = "";

if(!isset($_SESSION["lang"]) || $_SESSION['lang'] == "")
{
	$_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == "fr")
		include_once($_SERVER['DOCUMENT_ROOT']."/language/french.php");
	else
		include_once($_SERVER['DOCUMENT_ROOT']."/language/english.php");
}
else if($_SESSION["lang"] == "fr")
	include_once($_SERVER['DOCUMENT_ROOT']."/language/french.php");
else
	include_once($_SERVER['DOCUMENT_ROOT']."/language/english.php");

function check_post($var)
{
	if (!isset($_POST[$var]))
		return FALSE;
	else if (empty($_POST[$var]))
		return FALSE;
	else
		return TRUE;
}

function check_get($var)
{
	if (!isset($_GET[$var]))
		return FALSE;
	else if (empty($_GET[$var]))
		return FALSE;
	else
		return TRUE;
}

?>
