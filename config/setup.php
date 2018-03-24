<?php
include_once('database.php');
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
	$bdd->query("DROP DATABASE IF EXISTS hypertube");
	$bdd->query("CREATE DATABASE hypertube");
	$bdd->query("use hypertube");

	$bdd->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');

	$bdd->query('SET time_zone = "+00:00";');

	header('Location: /');
	exit();
}
catch (Exception $e)
{
	header('Location: /error.php');
	exit;
}
?>