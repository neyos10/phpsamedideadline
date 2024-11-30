<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>


<div class="container my-5">
    <h2>List of users from database</h2>
    <a  class="btn btn-primary" href="create.php" role="button">Signup</a>


    <br>
    <br>
    <table class="table">
       <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>


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
        //call the static selectAllClients method and store the result of the method in $clients
       $tableName = "Clients"; // Nom de la table
       $clients = Client::selectAllClients($tableName, $conn); // Appeler la méthode avec le nom de la table et la connexion
       
        // Vérifiez si des clients ont été récupérés
        if (empty($clients)) {
            echo "<tr><td colspan='5'>Aucun utilisateur trouvé.</td></tr>"; // Message si aucun utilisateur n'est trouvé
        } else {
            foreach ($clients as $row) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a class='btn btn-success btn-sm' href='update.php?id={$row['id']}'>Modifier</a>
                        <a class='btn btn-danger btn-sm' href='delete.php?id={$row['id']}'>Supprimer</a>
                    </td>
                </tr>";
            }
        }
        
        ?>
        </tbody>
        
    </table>
    </div>
</body>
</html>
