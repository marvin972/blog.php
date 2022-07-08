<?php


function getAllArticles($limit = 10,$order = 'DESC')
{
    global $pdo;
    $sql = "SELECT * FROM articles ORDER BY created_at $order LIMIT $limit";
    $query = $pdo->prepare($sql);
    $query->execute();
    $articles = $query->fetchAll();
    return $articles;
}