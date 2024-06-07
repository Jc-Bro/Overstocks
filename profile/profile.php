<?php
global $pdo;
session_start(); // Démarrer la session

// Inclure la configuration de la base de données
require '../config.php';
// Inclure le template produit
//require 'product_template.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

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

// Vérifiez que la connexion à la base de données est établie
if (!$pdo) {
    die("La connexion à la base de données a échoué.");
}

// Récupérer les produits de l'utilisateur
//$userId = $_SESSION['user_id'];
//$sql = "SELECT * FROM Product WHERE id_user = ?";
//$stmt = $pdo->prepare($sql);
//$stmt->execute([$userId]);
//$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>

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
<section class="w-[60%] m-auto">

    <!-- Ajouter le texte avec le nom et le prénom de l'utilisateur -->
    <div class="flex justify-between items-baseline mb-[30px]">
        <h2 class="font-geologica text-[55px] text-[#004D42] font-semibold">Bonjour, <?= htmlspecialchars($firstNameOfUser) ?> <?= htmlspecialchars($nameOfUser) ?>!</h2>
        <a href="logout.php" class="underline">Se déconnecter</a>
    </div>
    <h3 class="text-[45px] mb-[50px] font-semibold">Paramètres</h3>
    <div class="flex gap-[30px] mb-[30px]">
        <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
            <a href="infoprofile.php" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FFBB050] to-[#5EFCBD25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Mes informations</a>
        </div>
        <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
            <a href="#" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FFBB050] to-[#5EFCBD25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Mes favoris</a>
        </div>
    </div>
    <div class="flex gap-[30px] mb-[]">
        <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
            <a href="#" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FFBB050] to-[#5EFCBD25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Mes achats</a>
        </div>
        <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
            <a href="#" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FFBB050] to-[#5EFCBD25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Besoin d'aide ?</a>
        </div>
    </div>

    <?php if ($typeOfUser === 'professionnel'): ?>
        <h3 class="text-[45px] mb-[50px] mt-[50px font-semibold">Espace vendeur</h3>
        <div class="flex gap-[30px] mb-[30px]">
            <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
                <a href="#" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FC3FB75] to-[#3FC3FB25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Ajout produit</a>
            </div>
            <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
                <a href="myproduct.php" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FC3FB75] to-[#3FC3FB25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Mes produits</a>
            </div>
        </div>
        <div class="flex gap-[30px]">
            <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
                <a href="#" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FC3FB75] to-[#3FC3FB25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Mes ventes</a>
            </div>
            <div class="bg-gradient-to-r from-[#A7D8D0] to-[#A7D8D050] rounded-[25px] p-0.5">
                <a href="#" class="grid content-center w-[400px] h-[100px] justify-center bg-gradient-to-r from-[#3FC3FB75] to-[#3FC3FB25] rounded-[25px] text-[#1B453C] font-medium text-[35px] ">Abonnement</a>
            </div>
        </div>
    <?php endif; ?>

</section>

<!-- Lien pour Tailwind-->
<script src="https://cdn.tailwindcss.com"></script>

</body>
</html>
