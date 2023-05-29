<!--
require_once 'database.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if (
    isset($_POST['form'])
    && $_POST['form'] === "formulaire_supp_article"
  ) {
    if (
      !empty($_POST['article_id']) 
    ) {
      $data=[
        'article_id'=>$_POST['article_id'],
        
      ];

      $request=$database->prepare("DELETE FROM articles WHERE id =:article_id");
      $request->execute($data);
      header("Location:index.php");
    }
  }
} -->

<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if (isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    
    // Supprimez le post de la base de données en utilisant l'ID fourni
    $request = $database->prepare("DELETE FROM tweets WHERE id = :post_id");
    $request->bindParam(':post_id', $postId);
    $request->execute();

    // Redirigez l'utilisateur vers une autre page après la suppression (par exemple, la page d'accueil)
    header("Location: index.php");
    exit();
  }
}
?>