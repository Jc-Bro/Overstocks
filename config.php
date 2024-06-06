<?php
// config.php

$host = '193.203.168.104';  // ou l'IP du serveur de base de données
$dbname = 'u535044803_db_overstocks';
$username = 'u535044803_overstocks';  // Utilisateur de la base de données
$password = 'JeSuisUnMotDePasseSécurisé123!';  // Mot de passe de l'utilisateur de la base de données

//$host = 'localhost';  // ou l'IP du serveur de base de données
//$port = '3306';
//$dbname = 'db_overstocks';
//$username = 'root';  // Utilisateur de la base de données
//$password = '';  // Mot de passe de l'utilisateur de la base de données


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Définir le mode d'erreur PDO à exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

