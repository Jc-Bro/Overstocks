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
    $sql = "INSERT INTO user (nameOfUser, firstNameOfUser, emailOfUser, passwordHash, phoneOfUser, addressOfUser, townOfUser, postalCodeOfUser, typeOfUser, siretOfUser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
<h2>Inscription</h2>
<form action="signup.php" method="post">
    <label>Nom: <input type="text" name="nameOfUser" required></label><br>
    <label>Prénom: <input type="text" name="firstNameOfUser" required></label><br>
    <label>Email: <input type="email" name="emailOfUser" required></label><br>
    <label>Mot de passe: <input type="password" name="password" required></label><br>
    <label>Téléphone: <input type="text" name="phoneOfUser"></label><br>
    <label>Adresse: <input type="text" name="addressOfUser"></label><br>
    <label>Ville: <input type="text" name="townOfUser"></label><br>
    <label>Code Postal: <input type="text" name="postalCodeOfUser"></label><br>
    <label>Type:
        <select name="type">
            <option value="professionnel">Professionnel</option>
            <option value="particulier">Particulier</option>
        </select>
    </label><br>
    <label>SIRET (si professionnel): <input type="text" name="siret"></label><br>
    <button type="submit">S'inscrire</button>
</form>
</body>
</html>

