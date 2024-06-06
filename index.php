<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
<h1 class="text-amber-400">Page d'Accueil</h1>

<?php if ($isLoggedIn): ?>
<p>Bonjour, <?= htmlspecialchars($_SESSION['firstNameOfUser']) ?>!</p>
<a href="profile/profile.php">Profil</a>
<a href="./profile/logout.php">Déconnexion</a>
<?php else: ?>
<a href="./profile/signup.php">S'inscrire</a> |
<a href="./profile/login.php">Se connecter</a>
<?php endif; ?>

</body>
</html>
