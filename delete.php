<?php
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
}
