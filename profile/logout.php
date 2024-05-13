<?php
// logout.php
session_start();

// Détruire toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

echo "Logged out successfully!";

header("Location: ../home.php");
