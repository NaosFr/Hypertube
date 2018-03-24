<?php
include 'database.php';
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
	$bdd->query("DROP DATABASE IF EXISTS matcha");
	$bdd->query("CREATE DATABASE matcha");
	$bdd->query("use matcha");



	$bdd->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');

	$bdd->query('SET time_zone = "+00:00";');

	$bdd->query('');


	session_start();

	unset($_SESSION['id']);
	unset($_SESSION['login']);
	echo '<script>document.location.href="../index.php";</script>';
	exit();
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
        echo '<script>document.location.href="error.php";</script>';
}
?>