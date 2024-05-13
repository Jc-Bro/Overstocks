<?php
// config.php

$host = 'localhost';  // ou l'IP du serveur de base de données
$dbname = 'db_overstocks';
$username = 'root';  // Utilisateur de la base de données
$password = '';  // Mot de passe de l'utilisateur de la base de données

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Définir le mode d'erreur PDO à exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

