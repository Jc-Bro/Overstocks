<?php
global $pdo;
session_start();
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOfUser = $_POST['emailOfUser'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($emailOfUser) || empty($password)) {
        die("Please fill all required fields!");
    }

    $sql = "SELECT id_user, nameOfUser, firstNameOfUser, mailOfUser, passwordHash, phoneOfUser, addressOfUser, townOfUser, postalCodeOfUser, typeOfUser FROM User WHERE mailOfUser = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$emailOfUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['passwordHash'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nameOfUser'] = $user['nameOfUser'];
            $_SESSION['firstNameOfUser'] = $user['firstNameOfUser'];
            $_SESSION['emailOfUser'] = $user['mailOfUser'];
            $_SESSION['phoneOfUser'] = $user['phoneOfUser'];
            $_SESSION['addressOfUser'] = $user['addressOfUser'];
            $_SESSION['townOfUser'] = $user['townOfUser'];
            $_SESSION['postalCodeOfUser'] = $user['postalCodeOfUser'];
            $_SESSION['typeOfUser'] = $user['typeOfUser'];

            // Récupérer le SIRET si l'utilisateur est un professionnel
            if ($user['typeOfUser'] === 'professionnel') {
                $sqlSeller = "SELECT siret FROM Seller WHERE id_user = ?";
                $stmtSeller = $pdo->prepare($sqlSeller);
                $stmtSeller->execute([$user['id_user']]);
                $seller = $stmtSeller->fetch(PDO::FETCH_ASSOC);
                $_SESSION['siretOfUser'] = $seller['siret'] ?? '';
            }

            header("Location: ../index.php");
            exit;
        } else {
            echo "Invalid email or password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
<header>
    <section class="bg-[#15362f] h-24 ">
        <div class="align-middle flex p-4 justify-between w-[80%] m-auto">
            <img src="../img/logo_overstocks.png">
            <div class="flex gap-6">
                <a href="login.php" class="flex justify-center self-center text-white border-[3px] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Se connecter</a>
                <a href="signup.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">S'inscrire</a>
            </div>
        </div>

    </section>
</header>
<main>
    <section class="w-[60%] m-auto mt-[30px]">
        <div class="align-middle p-4 w-[80%] m-auto">
            <h2 class="mb-[50px] text-[45px]">Connexion</h2>
            <form action="login.php" method="post">
                <label class="font-normal text-[26px] mb-[20px]">Email: <input type="email" name="emailOfUser" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
                <label class="font-normal text-[26px] mb-[20px]">Mot de passe: <input type="password" name="password" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
                <button type="submit" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Se connecter</button>
            </form>
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

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
