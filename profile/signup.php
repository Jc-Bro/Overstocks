<?php
global $pdo;
require '../config.php';

// Vérifier que la méthode HTTP utilisée est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nameOfUser = $_POST['nameOfUser'] ?? '';
    $firstNameOfUser = $_POST['firstNameOfUser'] ?? '';
    $emailOfUser = $_POST['emailOfUser'] ?? '';
    $password = $_POST['password'] ?? '';
    $phoneOfUser = $_POST['phoneOfUser'] ?? '';
    $addressOfUser = $_POST['addressOfUser'] ?? '';
    $townOfUser = $_POST['townOfUser'] ?? '';
    $postalCodeOfUser = $_POST['postalCodeOfUser'] ?? '';
    $type = $_POST['type'] ?? '';
    $siret = $_POST['siret'] ?? null;

    if (empty($emailOfUser) || empty($password) || empty($nameOfUser) || empty($firstNameOfUser)) {
        die("Please fill all required fields!");
    }

    // Hasher le mot de passe
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Commencer une transaction
    $pdo->beginTransaction();

    try {
        // Préparer une requête SQL pour insérer l'utilisateur
        $sqlUser = "INSERT INTO User (nameOfUser, firstNameOfUser, mailOfUser, passwordHash, phoneOfUser, addressOfUser, townOfUser, postalCodeOfUser, typeOfUser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute([$nameOfUser, $firstNameOfUser, $emailOfUser, $passwordHash, $phoneOfUser, $addressOfUser, $townOfUser, $postalCodeOfUser, $type]);

        // Récupérer l'ID de l'utilisateur nouvellement inséré
        $userId = $pdo->lastInsertId();

        // Si le type d'utilisateur est "professionnel", insérer dans la table Seller
        if ($type === 'professionnel' && !empty($siret)) {
            $sqlSeller = "INSERT INTO Seller (id_user, siret) VALUES (?, ?)";
            $stmtSeller = $pdo->prepare($sqlSeller);
            $stmtSeller->execute([$userId, $siret]);
        }

        // Commit la transaction
        $pdo->commit();
        echo "User registered successfully!";
        header("Location: ../index.php"); // Rediriger vers la page d'accueil après l'inscription
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, rollback la transaction
        $pdo->rollBack();
        if ($e->getCode() == 23000) {
            echo "This email is already registered!";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO user (nameOfUser, mailOfUser, passwordHash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            // Connecter automatiquement l'utilisateur après l'inscription
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            header('Location: index.php');
            exit();
        } else {
            echo "Erreur lors de l'inscription.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <script>
        function toggleSiretField() {
            const typeField = document.querySelector('select[name="type"]');
            const siretField = document.querySelector('input[name="siret"]');
            const siretLabel = document.getElementById('siretLabel');
            if (typeField.value === 'professionnel') {
                siretLabel.style.display = 'block';
                siretField.disabled = false;
            } else {
                siretLabel.style.display = 'none';
                siretField.disabled = true;
                siretField.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            toggleSiretField(); // Ensure the correct display when the page loads
        });
    </script>
</head>
<body>
<header>
    <section class="bg-[#15362f] h-24 ">
        <div class="align-middle flex p-4 justify-between w-[80%] m-auto">
            <img src="../img/logo_overstocks.png">
                <div class="flex gap-6">
                    <a href="/login.php" class="flex justify-center self-center text-white border-[3px] rounded-2xl w-[150px] pt-[6px] pb-[8px]">Se connecter</a>
                    <a href="/signup.php" class="flex justify-center self-center bg-[#0FFA9C] border-[3px] border-[#0FFA9C] rounded-2xl w-[150px] pt-[6px] pb-[8px]">S'inscrire</a>
                </div>
        </div>

    </section>
</header>
<main>
    <section class="w-[60%] m-auto mt-[30px]">
        <h2>Inscription</h2>
        <form action="signup.php" method="post">
            <div class="flex gap-[50px]">
                <label class="font-normal text-[26px] mb-[20px]">Nom: <input type="text" name="nameOfUser" class=" my-[20px] w-[50%] border-2 border-black rounded-xl" required></label><br>
                <label class="font-normal text-[26px] mb-[20px]">Prénom: <input type="text" name="firstNameOfUser" class=" my-[20px] w-[50%] border-2 border-black rounded-xl" required></label><br>
            </div>
            <label class="font-normal text-[26px] mb-[20px]">Email: <input type="email" name="emailOfUser" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
            <label class="font-normal text-[26px] mb-[20px]">Mot de passe: <input type="password" name="password" class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
            <label class="font-normal text-[26px] mb-[20px]">Téléphone: <input type="text" name="phoneOfUser" class=" my-[20px] w-[100%] border-2 border-black rounded-xl"></label><br>
            <label class="font-normal text-[26px] mb-[20px]">Adresse: <input type="text" name="addressOfUser" class=" my-[20px] w-[100%] border-2 border-black rounded-xl"></label><br>
            <label class="font-normal text-[26px] mb-[20px]">Ville: <input type="text" name="townOfUser" class=" my-[20px] w-[100%] border-2 border-black rounded-xl"></label><br>
            <label class="font-normal text-[26px] mb-[20px]">Code Postal: <input type="text" name="postalCodeOfUser" class=" my-[20px] w-[100%] border-2 border-black rounded-xl"></label><br>
            <label class="font-normal text-[26px] mb-[20px]">Type:
                <select name="type" onchange="toggleSiretField()">
                    <option value="professionnel">Professionnel</option>
                    <option value="particulier">Particulier</option>
                </select>
            </label><br>
            <label id="siretLabel" style="display: none;" class="font-normal text-[26px] mb-[20px]">SIRET: <input type="text" name="siret" disabled class=" my-[20px] w-[100%] border-2 border-black rounded-xl" required></label><br>
            <button type="submit">S'inscrire</button>
        </form>
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
