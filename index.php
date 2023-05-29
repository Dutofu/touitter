<?php
session_start();

$connection = false; // Variable indiquant si l'utilisateur est connecté ou non
// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    // Récupérer l'ID de l'utilisateur connecté à partir de la base de données
    $userId = $_SESSION['user_id'];
    $database = new PDO('mysql:host=localhost;dbname=twitter', 'root', '');
    $query = $database->prepare('SELECT id FROM users WHERE id = :userId');
    $query->bindParam(':userId', $userId);
    $query->execute();

    // Vérifier si l'ID de l'utilisateur existe dans la base de données
    if ($query->rowCount() > 0) {
        $connection = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touitter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <a href="#" class="titre">Touitter</a>

        <div class="nav-links">
            <ul>
                <li><a href="#">Acceuil</a></li>
                <li><a href="#">Catégories</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">S'inscrire</a></li>
            </ul>
        </div>
        <img src="img/menu-btn.png" alt="menu-btn" class="menu-btn">
    </header>

    <div class="grid">

        <nav>
            <select id="color-filter">
                <option value="">Toutes les couleurs</option>
                <option value="red">Rouge</option>
                <option value="blue">Bleu</option>
                <option value="green">Vert</option>
            </select>

            <form action="logout.php" method="post">
                <button type="submit">Déconnexion</button>
            </form>
        </nav>


        <main>

            <form method="POST" action="inserer.php">
                <input type="text" name="montitre" placeholder="Votre titre" required>
                <input type="text" name="montweet" placeholder="Votre tweet" required>
                <select name="couleur" required>
                    <option value="red">Rouge</option>
                    <option value="blue">Bleu</option>
                    <option value="green">Vert</option>
                </select>
                <button type="submit">Tweeter !</button>
            </form>

            <div class="tweet-box">
                <?php 


                // Connection à la base de données PDO
                $database = new PDO ('mysql:host=localhost;dbname=twitter', 'root', '');    

                $jeveuxlesdonnes = $database->prepare('SELECT * FROM tweets');
                $jeveuxlesdonnes->execute();
                $lesdonnes = $jeveuxlesdonnes->fetchAll();

                ?>
                <?php foreach ($lesdonnes as $tweet): ?>
                    <?php
                    $tagColorClass = '';
            
                    if ($tweet['couleur'] === 'red') {
                        $tagColorClass = 'red';
                    } elseif ($tweet['couleur'] === 'blue') {
                        $tagColorClass = 'blue';
                    } elseif ($tweet['couleur'] === 'green') {
                        $tagColorClass = 'green';
                    }

                    
                    ?>
            
                    <div class="tweet-p <?php echo $tagColorClass; ?>"  data-color="<?php echo $tweet['couleur']; ?>">
                        <h1>Id : <?php echo $tweet['user_id']; ?></h1>
                        <h2><?php echo $tweet['titre']; ?></h2>
                        <p><?php echo $tweet['tweet']; ?></p>
                        <p><?php echo date("d/m/Y", strtotime($tweet['date'])) . " à " . date("H:i", strtotime($tweet['date'])); ?></p>
                        <form method="POST" action="supprimer_post.php">
                            <input type="hidden" name="post_id" value="<?php echo $tweet['id']; ?>">
                            <button type="submit">Supprimer le post</button>
                        </form>
                    </div>
            
                <?php endforeach; ?>
            </div>

        </main>

    </div>
    
    <div class="ajout">
    <img src="img/plus.png" alt="plus" class="plus">
    </div>

    <script>
        // Passer la valeur de $isUserLoggedIn à JavaScript
        var connection = <?php echo $connection ? 'true' : 'false'; ?>;
    </script>
    <script src="main.js"></script>


</body>
</html>
