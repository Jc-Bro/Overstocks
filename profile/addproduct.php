<?php
global $isLoggedIn;
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

    <section class="w-[60%] m-auto mb-[50px]">

            <h1 class="mb-[50px]">Ajouter un produit</h1>
            <form action="addproduct.php" method="post" enctype="multipart/form-data">
                <label>Nom du produit: <input type="text" name="productName" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
                <label>Photo du produit: <input type="file" name="productImage" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" accept="image/*" required></label><br>
                <label>Description du produit: <textarea name="productDescription" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></textarea></label><br>
                <label>Catégorie du produit:
                    <select name="productCategory" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required>
                        <option value="mobilier">Mobilier</option>
                        <option value="éléctronique">Éléctronique</option>
                        <option value="matières premières">Matières premières</option>
                        <option value="textile">Textile</option>
                        <option value="mécanique">Mécanique</option>
                        <option value="autres">Autres</option>
                    </select>
                </label><br>
                <label>Nombre de stock: <input type="number" name="productStock" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
                <label>Taille du produit: <input type="text" name="productSize" class=" my-[20px] w-[100%] border-2 border-black rounded-xl"></label><br>
                <label>Dimensions du produit: <input type="text" name="productDimensions" class=" my-[20px] w-[100%] border-2 border-black rounded-xl"></label><br>
                <button type="submit" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px] my-[30px]">Ajouter le produit</button>
            </form>

        <a href="profile.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Retour au profil</a>

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
<script src="https://cdn.tailwindcss.com"></script>

</body>
</html>
