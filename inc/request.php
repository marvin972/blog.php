<?php


function getArticles($id) {
    global $pdo;
    $sql = "SELECT * FROM articles WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id',$id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}



function getAllArticles($limit = 10,$order = 'DESC')
{
    global $pdo;
    $sql = "SELECT * FROM articles ORDER BY created_at $order LIMIT $limit";
    $query = $pdo->prepare($sql);
    $query->execute();
    $articles = $query->fetchAll();
    return $articles;
}

function publishedArticles() {
    global $pdo;
    $sql = "SELECT * FROM articles WHERE statu = 'publish' ORDER BY created_at LIMIT 10";
$query = $pdo->prepare($sql);
$query->execute();
$articles = $query->fetchall();
return $articles;
}

function getComments(){
    
}