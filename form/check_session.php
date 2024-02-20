<?php
session_start();

// Vérifier si une session est active
if(isset($_SESSION['pseudo'])) {
    // Rediriger l'utilisateur vers une page indiquant qu'il est déjà connecté
    header("Location: session_active.php");
    exit;
}
?>
