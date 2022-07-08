<?php
require('../inc/fonction.php');
require('../inc/pdo.php');
require('../inc/request.php');

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $articles = getArticles($id);
    if(!empty($articles)) {
        
        $sql = "DELETE FROM articles WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id',$id, PDO::PARAM_INT);
        $query->execute();
        
        header('Location: listingPost.php');
        exit();
    }
}

