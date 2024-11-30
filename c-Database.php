<?php
require 'Connection.php'; // Inclure la classe Connection

// Créer une instance de la classe Connection
$conn = new Connection();

$dbName = "chap4Db";
$conn->createDatabase($dbName);


$conn->selectDatabase($dbName);

// Définir la requête pour créer la table
$tableQuery = "
CREATE TABLE IF NOT EXISTS Clients (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(80),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Vérifiez si la variable $tableQuery est définie

    // Appeler la méthode createTable pour créer la table avec la requête
    $conn->createTable($tableQuery);




?>
