<?php
//include connection file
include 'Connection.php'; // Inclure la classe Connection

//create an instance of class Connection
$conn = new Connection(); // Créer une instance de la classe Connection

//call the selectDatabase method
$dbName = "chap4Db"; // Utiliser le nom de la base de données
$conn->selectDatabase($dbName); // Sélectionner la base de données

//include the client file
include 'Client.php'; // Inclure la classe Client

// Vérifier si l'ID est spécifié dans l'URL
$id = $_GET['id'] ?? null; // Utiliser l'opérateur null coalescent pour éviter les erreurs

if ($id) {
    //call the static deleteClient method and pass the id
    $result = Client::deleteClient($conn, $id); // Appeler la méthode pour supprimer le client

    if ($result) {
        header("Location: read.php?message=Client supprimé avec succès!"); // Rediriger avec un message de succès
        exit();
    } else {
        header("Location: read.php?error=Erreur lors de la suppression du client."); // Rediriger avec un message d'erreur
        exit();
    }
} else {
    // Rediriger vers la page de liste des utilisateurs si l'ID n'est pas spécifié
    header("Location: read.php?error=ID du client non spécifié.");
    exit();
}
?>
