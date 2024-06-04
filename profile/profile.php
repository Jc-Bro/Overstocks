<?php
session_start(); // Démarrer la session

// Rediriger vers index.php si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

// Variables de session
$firstNameOfUser = $_SESSION['firstNameOfUser'] ?? '';
$nameOfUser = $_SESSION['nameOfUser'] ?? '';
$emailOfUser = $_SESSION['emailOfUser'] ?? '';
$phoneOfUser = $_SESSION['phoneOfUser'] ?? '';
$addressOfUser = $_SESSION['addressOfUser'] ?? '';
$townOfUser = $_SESSION['townOfUser'] ?? '';
$postalCodeOfUser = $_SESSION['postalCodeOfUser'] ?? '';
$typeOfUser = $_SESSION['typeOfUser'] ?? '';
$siretOfUser = $_SESSION['siretOfUser'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
<h1>Profil de l'Utilisateur</h1>
<p>Prénom : <?= htmlspecialchars($firstNameOfUser) ?></p>
<p>Nom : <?= htmlspecialchars($nameOfUser) ?></p>
<p>Email : <?= htmlspecialchars($emailOfUser) ?></p>
<p>Téléphone : <?= htmlspecialchars($phoneOfUser) ?></p>
<p>Adresse : <?= htmlspecialchars($addressOfUser) ?></p>
<p>Ville : <?= htmlspecialchars($townOfUser) ?></p>
<p>Code postal : <?= htmlspecialchars($postalCodeOfUser) ?></p>
<p>Type : <?= htmlspecialchars($typeOfUser) ?></p>

<?php if ($typeOfUser === 'professionnel'): ?>
    <p>Numéro de SIRET : <?= htmlspecialchars($siretOfUser) ?></p>
<?php endif; ?>

<a href="../index.php">Accueil</a> |
<a href="logout.php">Déconnexion</a> |
<a href="addproduct.php">Ajouter un produit</a>
</body>
</html>
