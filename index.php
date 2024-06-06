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
    <section class="bg-[#15362f] h-24">
        <?php if ($isLoggedIn): ?>
            <p>Bonjour, <?= htmlspecialchars($_SESSION['firstNameOfUser']) ?>!</p>
            <a href="profile/profile.php">Profil</a>
            <a href="./profile/logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="./profile/signup.php" class="text-white border-2 rounded-2xl px-10">S'inscrire</a> |
            <a href="./profile/login.php">Se connecter</a>
        <?php endif; ?>

    </section>

<script src="https://cdn.tailwindcss.com"></script>


</body>
</html>
