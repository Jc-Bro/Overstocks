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
    $siret = $_POST['siret'] ?? null;

    if (empty($emailOfUser) || empty($password) || empty($nameOfUser) || empty($firstNameOfUser)) {
        die("Please fill all required fields!");
    }

    // Hasher le mot de passe
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Commencer une transaction
    $pdo->beginTransaction();

    try {
        // Préparer une requête SQL pour insérer l'utilisateur
        $sqlUser = "INSERT INTO User (nameOfUser, firstNameOfUser, mailOfUser, passwordHash, phoneOfUser, addressOfUser, townOfUser, postalCodeOfUser, typeOfUser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute([$nameOfUser, $firstNameOfUser, $emailOfUser, $passwordHash, $phoneOfUser, $addressOfUser, $townOfUser, $postalCodeOfUser, $type]);

        // Récupérer l'ID de l'utilisateur nouvellement inséré
        $userId = $pdo->lastInsertId();

        // Si le type d'utilisateur est "professionnel", insérer dans la table Seller
        if ($type === 'professionnel' && !empty($siret)) {
            $sqlSeller = "INSERT INTO Seller (id_user, siret) VALUES (?, ?)";
            $stmtSeller = $pdo->prepare($sqlSeller);
            $stmtSeller->execute([$userId, $siret]);
        }

        // Commit la transaction
        $pdo->commit();
        // Redirection vers la page d'accueil après l'inscription réussie
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, rollback la transaction
        $pdo->rollBack();
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

    <script>
        function toggleSiretField() {
            const typeField = document.querySelector('select[name="type"]');
            const siretField = document.querySelector('input[name="siret"]');
            const siretLabel = document.getElementById('siretLabel');
            if (typeField.value === 'professionnel') {
                siretLabel.style.display = 'block';
                siretField.disabled = false;
            } else {
                siretLabel.style.display = 'none';
                siretField.disabled = true;
                siretField.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            toggleSiretField(); // Ensure the correct display when the page loads
        });
    </script>
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
        <select name="type" onchange="toggleSiretField()">
            <option value="professionnel">Professionnel</option>
            <option value="particulier">Particulier</option>
        </select>
    </label><br>
    <label id="siretLabel" style="display: none;">SIRET: <input type="text" name="siret" disabled></label><br>
    <button type="submit">S'inscrire</button>
</form>
</body>
</html>
