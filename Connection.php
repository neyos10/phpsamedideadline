<?php
class Connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        // Créer la connexion
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password);

        // Vérifier la connexion
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully<br>";
    }

    function createDatabase($dbName) {
        // Créer une base de données avec la connexion de la classe
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if (mysqli_query($this->conn, $sql)) {
            echo "Database created successfully<br>";
        } else {
            echo "Error creating database: " . mysqli_error($this->conn) . "<br>";
        }
    }

    function selectDatabase($dbName) {
        // Sélectionner la base de données avec la connexion de la classe
        if (mysqli_select_db($this->conn, $dbName)) {
            echo "Database selected successfully<br>";
        } else {
            echo "Error selecting database: " . mysqli_error($this->conn) . "<br>";
        }
    }

    function createTable($query) {
        // Vérifiez si la requête n'est pas vide
        if (empty($query)) {
            die("La requête ne peut pas être vide.");
        }

        // Créer une table avec la requête
        if (mysqli_query($this->conn, $query)) {
            echo "Table created successfully<br>";
        } else {
            echo "Error creating table: " . mysqli_error($this->conn) . "<br>";
        }
    }

    // Fermer la connexion
    public function closeConnection() {
        mysqli_close($this->conn);
    }
}
?>