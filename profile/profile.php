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

// Récupérer les produits de l'utilisateur
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM Product WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
<h1>Profil de l'Utilisateur</h1>

<?php if ($typeOfUser === 'professionnel'): ?>
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
