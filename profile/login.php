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
} else {
    echo "Please use the POST method to send data.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
<h2>Connexion</h2>
<form action="login.php" method="post">
    <label>Email: <input type="email" name="emailOfUser" required></label><br>
    <label>Mot de passe: <input type="password" name="password" required></label><br>
    <button type="submit">Se connecter</button>
</form>
</body>
</html>
