<?php
// login.php

global $pdo;
require '../config.php';
session_start();

// Vérifier que la méthode HTTP utilisée est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOfUser = $_POST['emailOfUser'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($emailOfUser) || empty($password)) {
        die("Please fill all required fields!");
    }

    // Préparer une requête SQL pour sélectionner l'utilisateur
    $sql = "select id_user, nameOfUser, passwordHash from user where emailOfUser = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$emailOfUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['passwordHash'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nameOfUser'] = $user['nameOfUser'];
            echo "Logged in successfully!";
        } else {
            echo "Invalid email or password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Please use the POST method to send data.";
}

