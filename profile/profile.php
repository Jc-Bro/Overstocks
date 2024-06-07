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
        <img src="../img/logo_overstocks.png">
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
<section class="w-[70%]">

    <!-- Ajouter le texte avec le nom et le prénom de l'utilisateur -->
    <h2 class="">Bonjour, <?= htmlspecialchars($firstNameOfUser) ?> <?= htmlspecialchars($nameOfUser) ?>!</h2>

    <h1>Profil de l'Utilisateur</h1>
    <?php if ($typeOfUser === 'professionnel'): ?>
        <h2>Informations vendeur</h2>
        <h2>Mes produits</h2>
        <?php
        if (!empty($products)) {
            foreach ($products as $product) {
                displayProduct($product); // Utiliser le template pour afficher chaque produit
            }
        } else {
            echo "<p>Aucun produit trouvé.</p>";
        }
        ?>
        <a href="myproduct.php">Mes produits</a>
    <?php endif; ?>

    <a href="../index.php">Accueil</a> |
    <a href="logout.php">Déconnexion</a> |
    <a href="infoprofile.php">Mes informations</a>
</section>

<!-- Lien pour Tailwind-->
<script src="https://cdn.tailwindcss.com"></script>

</body>
</html>
