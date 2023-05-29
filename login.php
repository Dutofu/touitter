<?php
session_start();

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Vérifie si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les informations d'identification soumises
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

        // Requête pour récupérer l'utilisateur correspondant aux informations d'identification fournies
        $query = "SELECT id FROM users WHERE username = :username AND password = :password";
        $statement = $database->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);
        $statement->execute();

        // Vérifie si l'utilisateur existe dans la base de données
        if ($statement->rowCount() > 0) {
            // Utilisateur trouvé, enregistre l'ID utilisateur dans la session
            $_SESSION['user_id'] = $statement->fetch(PDO::FETCH_ASSOC)['id'];

            // Redirige vers la page d'accueil
            header("Location: index.php");
            exit();
        } else {
            // Identifiants invalides, affiche un message d'erreur
            $error_message = "Identifiants invalides. Veuillez réessayer.";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page de connexion</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center">Connexion</h1>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Votre nom">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </div>
        </form>
        <p class="text-center">Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>