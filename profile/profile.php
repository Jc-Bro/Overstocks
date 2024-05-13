<?php
session_start(); // Démarrer la session

// Rediriger vers home.php si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../home.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
<h1>Profil de l'Utilisateur</h1>
<p>Prénom : <?= htmlspecialchars($_SESSION['firstNameOfUser'] ?? '') ?></p>
<p>Nom : <?= htmlspecialchars($_SESSION['nameOfUser'] ?? '') ?></p>
<p>Email : <?= htmlspecialchars($_SESSION['emailOfUser'] ?? '') ?></p>
<p>Téléphone : <?= htmlspecialchars($_SESSION['phoneOfUser'] ?? '') ?></p>
<p>Adresse : <?= htmlspecialchars($_SESSION['addressOfUser'] ?? '') ?></p>
<p>Ville : <?= htmlspecialchars($_SESSION['townOfUser'] ?? '') ?></p>
<p>Code postal : <?= htmlspecialchars($_SESSION['postalCodeOfUser'] ?? '') ?></p>
<p>Type : <?= htmlspecialchars($_SESSION['typeOfUser'] ?? '') ?></p>
<p>Numéro de SIRET : <?= htmlspecialchars($_SESSION['siretOfUser'] ?? '') ?></p>

<a href="../home.php">Accueil</a> |
<a href="logout.php">Déconnexion</a>
</body>
</html>
