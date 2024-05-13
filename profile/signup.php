<?php
// signup.php

global $pdo;
require '../config.php';

// Vérifier que la méthode HTTP utilisée est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nameOfUser = $_POST['nameOfUser'] ?? '';
    $firstNameOfUser = $_POST['firstNameOfUser'] ?? '';
    $emailOfUser = $_POST['emailOfUser'] ?? '';
    $password = $_POST['password'] ?? '';
    $phoneOfUser = $_POST['phoneOfUser'] ?? '';
    $addressOfUser = $_POST['addressOfUser'] ?? '';
    $townOfUser = $_POST['townOfUser'] ?? '';
    $postalCodeOfUser = $_POST['postalCodeOfUser'] ?? '';
    $type = $_POST['type'] ?? '';
    $siret = $_POST['siret'] ?? '';

    if (empty($emailOfUser) || empty($password) || empty($nameOfUser) || empty($firstNameOfUser)) {
        die("Please fill all required fields!");
    }

    // Hasher le mot de passe
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Préparer une requête SQL pour insérer l'utilisateur
    $sql = "INSERT INTO user (nameOfUser, firstNameOfUser, emailOfUser, passwordHash, phoneOfUser, addressOfUser, townOfUser, postalCodeOfUser, type, siret) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nameOfUser, $firstNameOfUser, $emailOfUser, $passwordHash, $phoneOfUser, $addressOfUser, $townOfUser, $postalCodeOfUser, $type, $siret]);
        echo "User registered successfully!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "This email is already registered!";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Please use the POST method to send data.";
}

