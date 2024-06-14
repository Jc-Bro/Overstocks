<?php
global $isLoggedIn, $isLoggedIn;
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
    <header>
        <section class="bg-[#15362f] h-24 mb-[30px]">
            <div class="align-middle flex p-4 justify-between w-[80%] m-auto">
                <a href="../index.php"><img src="../img/logo_overstocks.png"></a>
                <?php if ($isLoggedIn): ?>
                    <a href="profile/profile.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Mon compte</a>
                <?php else: ?>
                    <div class="flex gap-6">
                        <a href="./profile/login.php" class="flex justify-center self-center text-white border-[3px] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Se connecter</a>
                        <a href="./profile/signup.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">S'inscrire</a>
                    </div>
                <?php endif; ?>
            </div>

        </section>
    </header>
    <main>
        <section class="w-[60%] m-auto mt-[30px]">
            <div class="p-4 w-[80%]">

                <h2 class="text-[45px]">Mes informations</h2>
                <p class="text-[20px] text-[#15362f] m-2">Prénom : <?= htmlspecialchars($firstNameOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Nom : <?= htmlspecialchars($nameOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Email : <?= htmlspecialchars($emailOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Téléphone : <?= htmlspecialchars($phoneOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Adresse : <?= htmlspecialchars($addressOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Ville : <?= htmlspecialchars($townOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Code postal : <?= htmlspecialchars($postalCodeOfUser) ?></p>
                <p class="text-[20px] text-[#15362f] m-2">Type : <?= htmlspecialchars($typeOfUser) ?></p>

                <?php if ($typeOfUser === 'professionnel'): ?>
                    <p class="text-[20px] text-[#15362f] m-2">Numéro de SIRET : <?= htmlspecialchars($siretOfUser) ?></p>
                <?php endif; ?>
            </div>
        </section>
    </main>
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
    <!-- Lien pour Tailwind-->
    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
