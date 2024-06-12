<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

?>
<!-- Partie front-->
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
    <header>
        <section class="bg-[#15362f] h-24 ">
            <div class="align-middle flex p-4 justify-between w-[80%] m-auto">
                <img src="img/logo_overstocks.png">
                <?php if ($isLoggedIn): ?>
                    <a href="profile/profile.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Mon compte</a>
                    <!-- <a href="./profile/logout.php">Déconnexion</a> -->
                <?php else: ?>
                    <div class="flex gap-6">
                        <a href="./profile/login.php" class="flex justify-center self-center text-white border-[3px] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Se connecter</a>
                        <a href="./profile/signup.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">S'inscrire</a>
                    </div>
                <?php endif; ?>
            </div>

        </section>
    </header>

    <footer>
        <section class="bg-[#15362f] text-white">
            <div class="w-[90%] flex pt-[40px] m-auto">
                <div class="w-[50%]">
                    <a><img src="../img/logo_overstocks.png"></a>
                </div>
                <div class="w-[16%]">
                    <h5 class="text-[25px] font-normal mb-[20px]">Profil</h5>
                    <div class="grid">
                        <a href="#" class="mb-[10px]">Informations</a>
                        <a href="#" class="mb-[10px]">Abonnement</a>
                        <a href="#" class="mb-[10px]">Aide</a>
                    </div>
                </div>
                <div class="w-[16%]">
                    <h5 class="text-[25px] font-normal text-white mb-[20px]">Produits</h5>
                    <div class="grid">
                        <a href="#" class="mb-[10px]">Panier</a>
                        <a href="#" class="mb-[10px]">Achats</a>
                        <a href="#" class="mb-[10px]">Favoris</a>
                    </div>
                </div>
                <div class="w-[16%]">
                    <h5 class="text-[25px] font-normal mb-[20px]">Profil</h5>
                    <div class="flex gap-[30px]">
                        <a href="#"><img src="../img/icone_linkedin.svg"></a>
                        <a href="#"><img src="../img/icone_instagram.svg"></a>
                        <a href="#"><img src="../img/icone_facebook.svg"></a>
                    </div>
                </div>
            </div>
            <div class="w-[90%] m-auto flex justify-between mt-[20px] pb-[20px]">
                <div>
                    <p>©2024 Overstocks. Tout droits réservés.</p>
                </div>
                <div class="flex gap-[30px]">
                    <a href="#">Mentions légales</a>
                    <a href="#">CGV</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </section>
    </footer>

<script src="https://cdn.tailwindcss.com"></script>


</body>
</html>
