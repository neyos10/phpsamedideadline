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

// Initialiser les variables
$message = "";
$nom = "";
$prenom = "";
$email = "";

// Vérification de l'ID de l'utilisateur
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM Clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $nom = $user['firstname'];
        $prenom = $user['lastname'];
        $email = $user['email'];
    } else {
        $message = "Utilisateur non trouvé.";
    }
}

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);

    // Mettre à jour l'utilisateur
    $stmt = $conn->prepare("UPDATE Clients SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nom, $prenom, $email, $id);

    if ($stmt->execute()) {
        $message = "Utilisateur mis à jour avec succès !";
        header("Location: read.php"); // Redirection après mise à jour
        exit();
    } else {
        $message = "Erreur lors de la mise à jour : " . $stmt->error;
    }

    // Fermer l'instruction
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Modifier l'Utilisateur</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        Nom: <input type="text" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required><br>
        Prénom: <input type="text" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>

<?php
// Fermer la connexion
mysqli_close($conn);
?> 