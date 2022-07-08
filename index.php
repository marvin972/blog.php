<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');



$articles = publishedArticles();

include ('inc/header.php');
?>

<h1>Home page</h1>

<h2>Les articles</h2>
    <ul>
        <?php foreach($articles as $article) {
         ?>
            <li>
            <h2><?php echo ucfirst($article['title']); ?></h2>
        <p><strong>Auteur : </strong><?php echo nl2br($article['auteur']); ?></p>
        <p><strong>Status : </strong><?php echo nl2br($article['statu']); ?></p>

        <p><strong>Date de création : </strong><?php echo date('d/m/Y à H:i', strtotime($article['created_at'])); ?>
        </p>
                <a href="single.php?id=<?php echo $article['id']; ?>">Voir plus</a>
            </li>
        <?php } ?>
    </ul>


<?php 