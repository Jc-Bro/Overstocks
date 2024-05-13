<?php
global $pdo;
require '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOfUser = $_POST['emailOfUser'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($emailOfUser) || empty($password)) {
        die("Please fill all required fields!");
    }

    $sql = "SELECT id_user, nameOfUser, emailOfUser, passwordHash FROM user WHERE emailOfUser = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$emailOfUser]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['passwordHash'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nameOfUser'] = $user['nameOfUser'];
            $_SESSION['emailOfUser'] = $user['emailOfUser'];
            header("Location: ../home.php");
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
    <title>Inscription</title>
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
