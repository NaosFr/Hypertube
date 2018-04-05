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
				cle_passwd TEXT,
				image TEXT NOT NULL,
				api INT NOT NULL)");
	
	//comments
	$bdd->query("CREATE TABLE comments(
				id_comment INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				id_user INT NOT NULL,
				id_movie TEXT NOT NULL,
				comment TEXT NOT NULL,
				date INT NOT NULL)");

	//genres
	$bdd->query("CREATE TABLE genres(
				id_genre INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				genre TEXT NOT NULL)");

	$bdd->query("INSERT INTO genres (genre) VALUES
				('Action'),
				('Adventure'),
				('Animation'),
				('Biography'),
				('Comedy'),
				('Crime'),
				('Documentary'),
				('Drama'),
				('Family'),
				('Fantasy'),
				('History'),
				('Horror'),
				('Music'),
				('Musical'),
				('Mystery'),
				('Romance'),
				('Sci-Fi'),
				('Sport'),
				('Thriller'),
				('War'),
				('Western')");

	//hash
	$bdd->query("CREATE TABLE hash(
				id_hash INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				hash TEXT NOT NULL,
				path TEXT NOT NULL,
				downloaded INT UNSIGNED NOT NULL)");

	//views
	$bdd->query("CREATE TABLE views(
				id_views INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				id_user INT UNSIGNED NOT NULL,
				id_movie TEXT NOT NULL,
				hash_movie TEXT NOT NULL)");

	header('Location: /');
	exit;
}
catch (Exception $e)
{
	header('Location: /error.php');
	exit;
}
?>
