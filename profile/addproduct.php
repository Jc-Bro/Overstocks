<?php
session_start(); // Démarrer la session

// Rediriger vers index.php si l'utilisateur n'est pas connecté ou s'il n'est pas professionnel
if (!isset($_SESSION['user_id']) || $_SESSION['typeOfUser'] !== 'professionnel') {
    header("Location: ../index.php");
    exit;
}

global $pdo;
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
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
    $imageData = file_get_contents($_FILES['productImage']['tmp_name']);
    $imageFileType = strtolower(pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($imageFileType, $allowedTypes)) {
        die("Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.");
    }

    // Préparer et exécuter la requête SQL pour insérer le produit
    try {
        $sql = "INSERT INTO Product (id_user, productName, productImage, productDescription, productCategory, productStock, productSize, productDimensions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $productName);
        $stmt->bindParam(3, $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(4, $productDescription);
        $stmt->bindParam(5, $productCategory);
        $stmt->bindParam(6, $productStock, PDO::PARAM_INT);
        $stmt->bindParam(7, $productSize);
        $stmt->bindParam(8, $productDimensions);
        $stmt->execute();
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
