<?php
session_start();

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Redirige vers la page d'accueil si l'utilisateur est déjà connecté
    header("Location: index.php");
    exit();
}

// Vérifie si le formulaire d'inscription est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Connexion à la base de données
        $host = 'localhost';
        $dbname = 'twitter';
        $username_db = 'root';
        $password_db = '';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $database = new PDO($dsn, $username_db, $password_db);

        // Vérifie si l'utilisateur existe déjà
        $query = "SELECT id FROM users WHERE username = :username";
        $statement = $database->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            // Utilisateur existant, affiche un message d'erreur
            $error_message = "Nom d'utilisateur déjà utilisé. Veuillez choisir un autre nom d'utilisateur.";
        } else {
            // Insère l'utilisateur dans la base de données
            $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $statement = $database->prepare($query);
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            $statement->execute();

            // Redirige vers la page de connexion
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Inscription</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Inscription</h1>
                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Votre nom">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>


