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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&display=swap" rel="stylesheet">
</head>
<body class="font-geologica">
    <section class="bg-[#15362f] h-24 ">
        <div class="align-middle flex p-4 justify-between w-[80%] m-auto">
            <img src="img/logo_overstocks.png">
            <?php if ($isLoggedIn): ?>
                <a href="profile/profile.php">Profil</a>
                <a href="./profile/logout.php">Déconnexion</a>
            <?php else: ?>
                <div class="flex gap-6">
                    <a href="./profile/login.php" class="flex justify-center self-center text-white border-[3px] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Se connecter</a>
                    <a href="./profile/signup.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">S'inscrire</a>
                </div>
            <?php endif; ?>
        </div>

    </section>

<script src="https://cdn.tailwindcss.com"></script>


</body>
</html>
