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

	//users
	$bdd->query("CREATE TABLE users(
				id_user INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				email TEXT NOT NULL,
				login TEXT NOT NULL,
				passwd TEXT NOT NULL,
				last_name TEXT NOT NULL,
				first_name TEXT NOT NULL,
				confirm BIT NOT NULL DEFAULT 0,
				cle TEXT NOT NULL,
				cle_passwd TEXT)");
	
	//comments
	$bdd->query("CREATE TABLE comments(
				id_comment INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				user_id INT NOT NULL,
				movie_id TEXT NOT NULL,
				content TEXT NOT NULL,
				created_at TEXT NOT NULL)");

	//hash
	$bdd->query("CREATE TABLE hash(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				hash TEXT NOT NULL,
				path TEXT NOT NULL)");

	header('Location: /');
	exit;
}
catch (Exception $e)
{
	header('Location: /error.php');
	exit;
}
?>
