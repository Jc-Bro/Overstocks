<?php
session_start(); // Démarrer la session

// Rediriger vers index.php si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

global $pdo;
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'] ?? '';
    $productDescription = $_POST['productDescription'] ?? '';
    $productCategory = $_POST['productCategory'] ?? '';
    $productStock = $_POST['productStock'] ?? 0;
    $productSize = $_POST['productSize'] ?? '';
    $productDimensions = $_POST['productDimensions'] ?? '';

    // Vérifier que les champs obligatoires sont remplis
    if (empty($productName) || empty($productDescription) || empty($productCategory) || empty($_FILES['productImage']['name'])) {
        die("Veuillez remplir tous les champs obligatoires !");
    }

    // Gérer le téléchargement de l'image
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($imageFileType, $allowedTypes)) {
        die("Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.");
    }

    if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
        die("Désolé, une erreur s'est produite lors du téléchargement de votre fichier.");
    }

    // Préparer et exécuter la requête SQL pour insérer le produit
    try {
        $sql = "INSERT INTO Product (productName, productImage, productDescription, productCategory, productStock, productSize, productDimensions) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productName, $targetFile, $productDescription, $productCategory, $productStock, $productSize, $productDimensions]);
        echo "Produit ajouté avec succès !";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
</head>
<body>
<h1>Ajouter un produit</h1>
<form action="addproduct.php" method="post" enctype="multipart/form-data">
    <label>Nom du produit: <input type="text" name="productName" required></label><br>
    <label>Photo du produit: <input type="file" name="productImage" accept="image/*" required></label><br>
    <label>Description du produit: <textarea name="productDescription" required></textarea></label><br>
    <label>Catégorie du produit:
        <select name="productCategory" required>
            <option value="mobilier">Mobilier</option>
            <option value="éléctronique">Éléctronique</option>
            <option value="matières premières">Matières premières</option>
            <option value="textile">Textile</option>
            <option value="mécanique">Mécanique</option>
            <option value="autres">Autres</option>
        </select>
    </label><br>
    <label>Nombre de stock: <input type="number" name="productStock"></label><br>
    <label>Taille du produit: <input type="text" name="productSize"></label><br>
    <label>Dimensions du produit: <input type="text" name="productDimensions"></label><br>
    <button type="submit">Ajouter le produit</button>
</form>
<a href="profile.php">Retour au profil</a>
</body>
</html>
