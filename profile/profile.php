<?php
session_start(); // Démarrer la session

// Inclure la configuration de la base de données
require '../config.php';

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
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM Product WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclure le template produit
require 'product_template.php';
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
    <a href="addproduct.php">Ajouter un produit</a>
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
</body>
</html>
