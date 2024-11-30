<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Client {
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $reg_date; 

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($firstname, $lastname, $email, $password) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password; 
    }

    public function insertClient($tableName, $conn) {
        $stmt = $conn->prepare("INSERT INTO $tableName (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->firstname, $this->lastname, $this->email, $this->password);

        if ($stmt->execute()) {
            self::$successMsg = "Utilisateur créé avec succès !";
            header("Location: login.php");
            exit();
        } else {
            self::$errorMsg = "Erreur lors de la création de l'utilisateur : " . $stmt->error;
        }
    }

    public static function selectAllClients($tableName, $conn) {
        $data = []; // Initialiser le tableau pour stocker les résultats

        // Requête SQL pour sélectionner tous les clients
        $sql = "SELECT * FROM $tableName";
        $result = mysqli_query($conn->getConnection(), $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row; // Ajouter chaque ligne au tableau
            }
        

        return $data; // Retourner le tableau des clients
    }

    static function selectClientById($tableName, $conn, $id) {
        // Sélectionner un client par ID et retourner le résultat
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Retourner la ligne du client
    }

    static function updateClient($client, $tableName, $conn, $id) {
        // Mettre à jour un client avec les valeurs de $client
        $stmt = $conn->prepare("UPDATE $tableName SET firstname = ?, lastname = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $client->firstname, $client->lastname, $client->email, $client->password, $id);

        if ($stmt->execute()) {
            header("Location: read.php");
            exit();
        } else {
            self::$errorMsg = "Erreur lors de la mise à jour : " . $stmt->error;
        }

        $stmt->close();
    }

    static function deleteClient($tableName, $conn, $id) {
        // Supprimer un client par son ID
        $stmt = $conn->prepare("DELETE FROM $tableName WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: read.php");
            exit();
        } else {
            self::$errorMsg = "Erreur lors de la suppression : " . $stmt->error;
        }

        $stmt->close();
    }
}
?>


