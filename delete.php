<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "testDb";

$conn = mysqli_connect($servername, $username, $password, $dbName);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Vérification de l'ID de l'utilisateur
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer l'utilisateur
    $stmt = $conn->prepare("DELETE FROM Clients WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirection vers la liste des utilisateurs après la suppression
        header("Location: read.php");
        exit();
    } else {
        echo "Erreur lors de la suppression : " . $stmt->error;
    }

    // Fermer l'instruction
    $stmt->close();
} else {
    echo "Aucun ID d'utilisateur spécifié.";
}

// Fermer la connexion
mysqli_close($conn);
?> 